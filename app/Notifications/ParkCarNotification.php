<?php

namespace App\Notifications;

use App\Models\Car;
use App\Models\ParkCar;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ParkCarNotification extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private ParkCar $parkCar)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $diff = now()->diff($this->parkCar->end_time);

        if ($diff->h > 0) {
            $time_left = $diff->format('%H:%I');
        } else {
            $time_left = $diff->format('%I:%S');
        }

        $message = (new WebPushMessage)
            ->title(__('parking.park_car.title', ["registration_number" => $this->parkCar->car->registration_number]))
            ->body(__('parking.park_car.body', ["time_left" => $time_left]))
            ->tag("park-car-{$this->parkCar->id}")
            ->renotify(false)
            ->options([
                'silent' => true
            ])
            ->data([
                'registration_number' => $this->parkCar->car->registration_number,
                'endTime' => $this->parkCar->end_time->toDateTimeString(),
                'type' => 'park-car',
            ])
            ->action(__('parking.park_car.action.add_time'), 'park-car-add-time');

        return $message;
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array<string, string>
     */
    public function viaQueues(): array
    {
        return [
            WebPushChannel::class => 'web-push-queue',
        ];
    }
}
