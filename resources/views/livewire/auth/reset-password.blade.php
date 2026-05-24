<div class="auth-card">
    <h1 class="auth-card__title">Set new password</h1>
    <p class="auth-card__subtitle">Choose a strong password for your account.</p>

    @if (session('status'))
        <div class="auth-alert auth-alert--success" role="status">{{ session('status') }}</div>
    @endif

    <form wire:submit="resetPassword" class="auth-form" autocomplete="off">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" wire:model="email" class="form-control" required autocomplete="email">
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">New password</label>
            <input type="password" id="password" wire:model="password" class="form-control" placeholder="At least 8 characters" required autocomplete="new-password">
            @error('password')<span class="error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="auth-btn" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="resetPassword">Reset password</span>
            <span wire:loading wire:target="resetPassword">Saving…</span>
        </button>
    </form>

    <p class="auth-card__footer">
        <a href="{{ route('login') }}" wire:navigate>&larr; Back to sign in</a>
    </p>
</div>
