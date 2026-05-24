<!-- Reset Password Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('home') }}" class="">
                        <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>{{ config('app.name') }}</h3>
                    </a>
                    <h3>Set New Password</h3>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form wire:submit.prevent="resetPassword">
                    <div class="form-floating mb-3">
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="resetEmail"
                            placeholder="name@example.com"
                            wire:model.defer="email"
                        >
                        <label for="resetEmail">Email address</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="resetPassword"
                            placeholder="New password"
                            wire:model.defer="password"
                        >
                        <label for="resetPassword">New password</label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input
                            type="password"
                            class="form-control"
                            id="resetPasswordConfirmation"
                            placeholder="Confirm password"
                            wire:model.defer="password_confirmation"
                        >
                        <label for="resetPasswordConfirmation">Confirm password</label>
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-3">
                        <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
                        <span wire:loading wire:target="resetPassword">Resetting...</span>
                    </button>

                    <p class="text-center mb-0">
                        <a href="{{ route('admin.login') }}">Back to login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Reset Password End -->

