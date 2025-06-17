@extends('layouts.guest')

@section('content')
<div class="auth-bg" style="min-height:100vh;">
    <div class="auth-content" style="height:100vh; display:flex; align-items:center; justify-content:center;">
        <div style="width:400px; text-align:center;">
            @if(session('error'))
                <div style="background:#e74c3c; color:#fff; font-weight:bold; border-radius:0.5rem; padding:0.7rem 1.2rem; margin-bottom:1.2rem; box-shadow:0 2px 8px #e74c3c99; font-size:1.1rem;">{{ session('error') }}</div>
            @endif
            @if($errors->has('email'))
                <div style="background:#e74c3c; color:#fff; font-weight:bold; border-radius:0.5rem; padding:0.7rem 1.2rem; margin-bottom:1.2rem; box-shadow:0 2px 8px #e74c3c99; font-size:1.1rem;">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <h2 style="font-size:2rem; font-weight:400; margin-bottom:2rem; color:#fff;">Login</h2>
            <form method="POST" action="{{ route('login') }}">
                    @csrf
                <input type="text" name="email" placeholder="Email" required autofocus style="width:100%; padding:0.75rem; border-radius:0.5rem; border:none; font-size:1rem; color:#000; margin-bottom:1.5rem; box-shadow:2px 2px 4px #6e5445;">
                <input type="password" name="password" placeholder="Password" required style="width:100%; padding:0.75rem; border-radius:0.5rem; border:none; font-size:1rem; color:#000; margin-bottom:2rem; box-shadow:2px 2px 4px #6e5445;">
                <button type="submit" class="btn-green" style="width:100%; font-size:1.3rem; box-shadow:2px 2px 4px #6e5445; color:#000;">Login</button>
                </form>
            <div style="margin-top:1.5rem; color:#000;">
                <a style="color:#fff;">Don't have an account? <a href="{{ route('register') }}" style="color:#b3b3ff; text-decoration:underline;">Sign Up now!</a></a>
            </div>
        </div>
    </div>
</div>
<div class="btn-green" style="display:none"></div>
@endsection
