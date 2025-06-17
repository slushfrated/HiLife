@extends('layouts.guest')

@section('content')
<div class="auth-bg" style="min-height:100vh;">
    <div class="auth-content" style="height:100vh; display:flex; align-items:center; justify-content:center;">
        <div style="width:400px; text-align:center;">
            <h2 style="font-size:2rem; font-weight:400; margin-bottom:2rem; color:#fff;">Sign Up</h2>
            @if ($errors->any())
                <div style="background: #ffeaea; color: #e74c3c; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.2rem; text-align:left;">
                    <ul style="margin: 0; padding-left: 1.2em;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="email" placeholder="Email" required autofocus style="width:100%; padding:0.75rem; border-radius:0.5rem; border:none; font-size:1rem; color:#333; margin-bottom:1.5rem; box-shadow:2px 2px 4px #6e5445;">
                <input type="password" name="password" placeholder="Password" required style="width:100%; padding:0.75rem; border-radius:0.5rem; border:none; font-size:1rem; color:#333; margin-bottom:1.5rem; box-shadow:2px 2px 4px #6e5445;">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required style="width:100%; padding:0.75rem; border-radius:0.5rem; border:none; font-size:1rem; color:#333; margin-bottom:2rem; box-shadow:2px 2px 4px #6e5445;">
                <button type="submit" class="btn-green" style="width:100%; font-size:1.3rem; box-shadow:2px 2px 4px #6e5445;">Sign Up</button>
            </form>
            <div style="margin-top:1.5rem; color:#fff;">
                Already have an account? <a href="{{ route('login') }}" style="color:#b3b3ff; text-decoration:underline;">Log In.</a>
            </div>
        </div>
    </div>
</div>
<div class="btn-green" style="display:none"></div>
@endsection
