<div class="auth-card">
    <h1 class="auth-card__title">Create account</h1>
    <p class="auth-card__subtitle">Register to stay connected with {{ optional(\App\Models\WebsiteSetting::first())->company_name ?? config('app.name') }}.</p>

    <form wire:submit="register" class="auth-form" autocomplete="off">
        <div class="form-group">
            <label for="name">Full name</label>
            <input type="text" id="name" wire:model="name" class="form-control" placeholder="Your name" required autocomplete="name">
            @error('name')<span class="error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" wire:model="email" class="form-control" placeholder="you@example.com" required autocomplete="email">
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" wire:model="password" class="form-control" placeholder="At least 8 characters" required autocomplete="new-password">
            @error('password')<span class="error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control" placeholder="Repeat password" required autocomplete="new-password">
        </div>

        <button type="submit" class="auth-btn" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="register">Create account</span>
            <span wire:loading wire:target="register">Creating account…</span>
        </button>
    </form>

    <p class="auth-card__footer">
        Already have an account?
        <a href="{{ route('login') }}" wire:navigate>Sign in</a>
    </p>
</div>
