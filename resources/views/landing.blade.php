@extends('layouts.guest')

@section('content')
<div class="auth-bg" style="height:100vh; display:flex; align-items:center; justify-content:center;">
    <div style="display:flex; width:100%; max-width:800px; justify-content:center; align-items:center; gap:2.5rem;">
            <div style="flex:1; display:flex; justify-content:center; align-items:center;">
            <div style="font-size:6rem; font-family:'Inter',sans-serif; color:#fff; line-height:1.05; text-align:right;">Hi!<br>Life</div>
            </div>
            <div style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                <div style="font-size:2.5rem; margin-bottom:1.2rem;">☀️</div>
                <div style="color:#fff; font-size:1.25rem; margin-bottom:1.5rem;">Welcome to HiLife! Let's get you started!</div>
                <a href="{{ route('login') }}" style="width:100%; text-align:center; display:block;">
                    <button class="btn-green" style="width:320px; font-size:1.5rem; box-shadow:2px 2px 4px #6e5445; margin-bottom:1.2rem; color:#000;">Log In</button>
                </a>
                <div style="color:#fff; font-size:1rem;">
                    Don't have an account? <a href="{{ route('register') }}" style="color:#b3b3ff; text-decoration:underline;">Sign Up now!</a>
            </div>
        </div>
    </div>
</div>
<div class="btn-green" style="display:none"></div>
@endsection