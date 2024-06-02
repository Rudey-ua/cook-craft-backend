<?php

namespace App\Listeners;

use App\Events\RecipePublished;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecipePublished as RecipePublishedEmail;

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
            Mail::to($subscriber->user->email)->send(new RecipePublishedEmail($event->recipe));
        }
    }
}
