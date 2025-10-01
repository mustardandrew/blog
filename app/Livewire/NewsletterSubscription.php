<?php

namespace App\Livewire;

use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewsletterSubscription extends Component
{
    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('nullable|string|max:255')]
    public $name = '';

    public $isSubscribed = false;

    public $message = '';

    public function mount(): void
    {
        if (Auth::check()) {
            $this->email = Auth::user()->email;
            $this->name = Auth::user()->name;

            // Check if user is already subscribed
            $this->checkExistingSubscription();
        }
    }

    public function updatedEmail($value): void
    {
        // Real-time validation for email field only
        $this->validateOnly('email');
    }

    public function updatedName($value): void
    {
        // Real-time validation for name field only
        $this->validateOnly('name');
    }

    public function subscribe(): void
    {
        $this->validate();

        // Check if already subscribed
        $existingSubscription = Newsletter::where('email', $this->email)
            ->where('is_active', true)
            ->first();

        if ($existingSubscription) {
            $this->message = 'You are already subscribed to our newsletter!';
            $this->isSubscribed = true;

            return;
        }

        // Create new subscription
        $newsletter = Newsletter::create([
            'email' => $this->email,
            'name' => $this->name ?: null,
            'user_id' => Auth::id(),
            'verification_token' => Auth::guest() ? Str::random(60) : null,
            'email_verified_at' => Auth::check() ? now() : null,
            'subscribed_at' => now(),
        ]);

        $this->isSubscribed = true;

        if (Auth::guest()) {
            $this->message = 'Thank you for subscribing! Please check your email to confirm your subscription.';
        } else {
            $this->message = 'Thank you for subscribing to our newsletter!';
        }

        $this->reset(['email', 'name']);
    }

    public function resetForm(): void
    {
        $this->reset(['email', 'name', 'isSubscribed', 'message']);

        if (Auth::check()) {
            $this->email = Auth::user()->email;
            $this->name = Auth::user()->name;
            $this->checkExistingSubscription();
        }
    }

    private function checkExistingSubscription(): void
    {
        if (Newsletter::where('email', $this->email)->where('is_active', true)->exists()) {
            $this->isSubscribed = true;
            $this->message = 'You are already subscribed to our newsletter!';
        }
    }

    public function render()
    {
        return view('livewire.newsletter-subscription');
    }
}
