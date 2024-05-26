<?php

namespace App\Listeners;

use App\Events\RecipePublished;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendRecipePublishedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RecipePublished $event): void
    {
        $subscribers = Subscriber::where('author_id', $event->recipe->user_id)->get();

        foreach ($subscribers as $subscriber) {
            Mail::raw("A new recipe titled '{$event->recipe->title}' has been published by {$event->recipe->user->name}. Check it out!", function ($message) use ($subscriber) {
                $message->to($subscriber->user->email)
                    ->subject('New Recipe Published');
            });
        }
    }
}
