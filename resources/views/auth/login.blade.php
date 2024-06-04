@extends('auth.layouts')

@section('auth_content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Login">
                    </div>
                </form>

                <!-- Google Login Button -->
                <div class="row mb-3">
                    <div class="col-md-8 offset-md-2">
                        <div class="google-login-container d-flex justify-content-center align-items-center">
                           
                            <div id="g_id_onload"
                                 data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
                                 data-context="signin"
                                 data-ux_mode="popup"
                                 data-callback="handleGoogleResponse"
                                 data-auto_prompt="false">
                            </div>
                            <div class="g_id_signin"
                                 data-type="standard"
                                 data-shape="rectangular"
                                 data-theme="outline"
                                 data-text="sign_in_with"
                                 data-size="large"
                                 data-logo_alignment="left">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

<script>
    function handleGoogleResponse(response) {
        // Send the ID token to your backend for verification and authentication
        const token = response.credential;
    
        fetch('/auth/google/callback', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ token: token })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "{{ route('dashboard') }}";
            } else {
                alert('Google login failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Google login failed');
        });
    }
    </script>
    
@endsection
