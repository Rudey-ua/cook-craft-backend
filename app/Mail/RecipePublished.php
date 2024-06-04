<?php

namespace App\Mail;

use App\Models\Recipe;
use App\Traits\FIleTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecipePublished extends Mailable
{
    use Queueable, SerializesModels, FIleTrait;

    /**
     * Create a new message instance.
     */
    public function __construct(protected Recipe $recipe)
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipe->user->firstname . __(" published a new recipe!");

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.recipe_published',
            with: [
                'recipe' => $this->recipe,
                'coverPhoto' => $this->getProfileImageUrl($this->recipe->user->profile_image)
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
