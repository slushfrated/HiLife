@extends('layouts.guest')

@section('content')
<div class="auth-bg" style="min-height:100vh; display:flex; flex-direction:column; justify-content:center;">
    <div class="auth-header" style="display:flex; justify-content:space-between; align-items:center; padding: 2rem 3rem 0 3rem;"></div>
    <div class="auth-content" style="flex:1; display:flex; align-items:center; justify-content:center; min-height:80vh;">
        <div style="width:500px; text-align:center;">
            <h2 style="font-size:2.2rem; font-weight:400; margin-bottom:1rem; color:#fff;">Welcome Aboard, Grindmasters! <span style="font-size:1.5rem;">☕</span></h2>
            <div style="color:#f5e6d8; font-size:1.2rem; margin-bottom:2rem;">New around here? Let's get you a name!</div>
            @if ($errors->any())
                <div style="color: #ffb3b3; margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('set-name.store') }}">
                @csrf
                <input type="text" name="name" placeholder="Enter your name here!" required autofocus style="width:100%; padding:0.9rem; border-radius:0.6rem; border:none; font-size:1.1rem; color:#333; margin-bottom:2rem; box-shadow:2px 2px 6px #6e5445;">
                <button type="submit" style="background:#5e7154; color:#fff; font-size:1.2rem; padding:0.7rem 2.5rem; border-radius:0.5rem; border:none; box-shadow:2px 2px 6px #6e5445; cursor:pointer;">That's my name!</button>
            </form>
        </div>
    </div>
</div>
@endsection