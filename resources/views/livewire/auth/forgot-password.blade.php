<div class="auth-card">
    <h1 class="auth-card__title">Forgot password?</h1>
    <p class="auth-card__subtitle">Enter your email and we will send you a link to choose a new password.</p>

    @if (session('status'))
        <div class="auth-alert auth-alert--success" role="status">{{ session('status') }}</div>
    @endif

    <form wire:submit="sendResetLink" class="auth-form" autocomplete="off">
        <div class="form-group">
            <label for="reset-email">Email address</label>
            <input type="email" id="reset-email" wire:model="email" class="form-control" placeholder="you@example.com" required autocomplete="email">
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="auth-btn" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="sendResetLink">Send reset link</span>
            <span wire:loading wire:target="sendResetLink">Sending…</span>
        </button>
    </form>

    <p class="auth-card__footer">
        <a href="{{ route('login') }}" wire:navigate>&larr; Back to sign in</a>
    </p>
</div>
