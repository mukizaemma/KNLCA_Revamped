<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('home') }}" class="">
                        <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>{{ config('app.name') }}</h3>
                    </a>
                    <h3>Admin Sign In</h3>
                </div>
                <form wire:submit="login">
                    <div class="form-floating mb-3">
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="floatingInput" 
                            placeholder="name@example.com"
                            wire:model="email"
                        >
                        <label for="floatingInput">Email address</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="floatingPassword" 
                            placeholder="Password"
                            wire:model="password"
                        >
                        <label for="floatingPassword">Password</label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" wire:model="remember">
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                        </div>
                        <a href="{{ route('admin.password.request') }}">Forgot Password</a>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">
                        <span wire:loading.remove wire:target="login">Sign In</span>
                        <span wire:loading wire:target="login">Signing in...</span>
                    </button>
                    <p class="text-center mb-0">Don't have an Account? <a href="{{ route('register') }}">Sign Up</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Sign In End -->
