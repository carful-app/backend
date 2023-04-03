<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;

trait SlugTrait
{
    private $idStore = [];
    private $slugStore = [];
    private $allStore = null;
    // Hold the class instance.
    private static $instance = null;
    // The object is created from within the class itself
    // only if the class has no instance.
    private static function getInstance()
    {
        if (self::$instance == null) {
            $className = static::class;
            self::$instance = new $className;
        }

        return self::$instance;
    }

    /**
     * Return id by slug.
     *
     * @param $slug string
     * @return int|null
     */
    public static function slugId($slug): ?int
    {
        // Check in cache first.
        $key = 'slugId:class-' . static::class . ':slug-' . $slug;
        $instance = self::getInstance();

        // If not in memory, then check in cache.
        if (!isset($instance->slugStore[$key])) {
            $instance->slugStore[$key] = Cache::get($key);
        }

        // Get from database.
        if (!isset($instance->slugStore[$key])) {
            $items = self::fetchAllFull();
            foreach ($items ?? [] as $item) {
                if ($item->slug == $slug) {
                    $instance->slugStore[$key] = (int) $item->id;
                }
            }
            Cache::put($key, $instance->slugStore[$key], 60 * 60 * 24 * 30); // Cache for 1 month.
        }

        return $instance->slugStore[$key];
    }

    /**
     * Return slug by id.
     *
     * @param $id int
     * @return string|null
     */
    public static function idSlug($id): ?string
    {
        // Check in MEMORY and CACHE first.
        $key = 'idSlug:class-' . static::class . ':id-' . $id;
        $instance = self::getInstance();

        // If not in MEMORY, then check in CACHE.
        if (!isset($instance->idStore[$key])) {
            $instance->idStore[$key] = Cache::get($key);
        }

        // Get from DATABASE.
        if (!isset($instance->idStore[$key])) {
            $items = self::fetchAllFull();
            foreach ($items ?? [] as $item) {
                if ($item->id == $id) {
                    $instance->idStore[$key] = $item->slug;
                }
            }
            Cache::put($key, $instance->idStore[$key], 60 * 60 * 24 * 30); // Cache for 1 month.
        }

        return $instance->idStore[$key];
    }

    /**
     * Return ids by slugArray.
     *
     * @param $arr array
     * @return array
     */
    public static function slugIds($arr)
    {
        foreach ($arr as &$a) {
            $a = self::slugId($a);
        }

        return $arr;
    }

    /**
     * Fetch all items in current table. Return a full-blown collection with all rows.
     *
     * @return Collection|array|null
     */
    public static function fetchAllFull()
    {
        // Check in cache first.
        $key = 'slugTrait-fetchAllFull:class-' . static::class;
        $instance = self::getInstance();

        // If not in memory, then check in cache.
        if (!isset($instance->allStore)) {
            $instance->allStore = Cache::get($key);
        }

        // Get from database.
        if (!isset($instance->allStore)) {
            $instance->allStore = static::orderBy('id')->get();
            Cache::put($key, $instance->allStore, 60 * 60 * 24 * 30); // Cache for 1 month.
        }

        return $instance->allStore;
    }
}
