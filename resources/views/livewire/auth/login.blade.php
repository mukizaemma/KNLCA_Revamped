<div class="auth-card">
    <h1 class="auth-card__title">Sign in</h1>
    <p class="auth-card__subtitle">Enter your email and password to access your account.</p>

    @if (session('status'))
        <div class="auth-alert auth-alert--success" role="status">{{ session('status') }}</div>
    @endif

    <form wire:submit="login" class="auth-form" autocomplete="off">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" wire:model="email" class="form-control" placeholder="you@example.com" required autocomplete="email">
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" wire:model="password" class="form-control" placeholder="Your password" required autocomplete="current-password">
            @error('password')<span class="error">{{ $message }}</span>@enderror
        </div>

        <div class="auth-form__row">
            <label class="auth-form__remember">
                <input type="checkbox" wire:model="remember" id="remember-me">
                Remember me
            </label>
            <a href="{{ route('password.request') }}" class="auth-form__link" wire:navigate>Forgot password?</a>
        </div>

        <button type="submit" class="auth-btn" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="login">Sign in</span>
            <span wire:loading wire:target="login">Signing in…</span>
        </button>
    </form>

    <p class="auth-card__footer">
        Don't have an account?
        <a href="{{ route('register') }}" wire:navigate>Create one</a>
    </p>
</div>
