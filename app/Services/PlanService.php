<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\PlanType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PlanService
{
    public static function getAllPlansByType(string $type): Collection
    {
        $key = 'plans_by_type_' . $type;

        $cache = Cache::get($key);

        if ($cache) {
            return $cache;
        }

        $types = [];

        if ($type == PlanType::MONTHLY) {
            $types = Plan::MONTHLY;
        } else if ($type == PlanType::ONE_TIME_USE) {
            $types = Plan::ONE_TIME_USE;
        }

        $plans = Plan::whereIn('id', Plan::slugIds($types))->get();

        Cache::put($key, $plans, 60 * 60 * 24);

        return $plans;
    }
}
