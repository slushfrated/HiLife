@extends('layouts.guest')

@section('content')
<div class="auth-bg" style="min-height:100vh;">
    <div class="auth-header" style="display:flex; justify-content:space-between; align-items:center; padding: 2rem 3rem 0 3rem;">
        <div class="date-box" style="background:#6e5445; color:#fff; padding:0.75rem 2.5rem 0.75rem 1.5rem; border-radius:0.5rem; font-size:1.2rem;">
            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
            <span class="time-box" id="clock" style="margin-left:2rem; font-weight:bold; font-size:1.3rem;">00:00</span>
        </div>
        <div class="brand-right" style="font-size:2rem; font-family:serif; color:#fff;">
            Hi!&nbsp; Life
        </div>
    </div>
    <div class="auth-content" style="flex:1; display:flex; align-items:center; justify-content:center; min-height:80vh;">
        <div style="width:400px; text-align:center;">
            <h2 style="font-size:2rem; font-weight:400; margin-bottom:2rem; color:#fff;">Sign Up</h2>
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

@push('scripts')
<script>
function updateClock() {
    const now = new Date();
    document.getElementById('clock').textContent =
        now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
}
setInterval(updateClock, 1000);
updateClock();
</script>
@endpush
