@extends('layouts.guest')

@section('content')
<div class="auth-bg" style="min-height:100vh; display:flex; flex-direction:column;">
    <div class="auth-header" style="display:flex; justify-content:flex-start; align-items:center; padding: 2rem 0 0 2rem;">
        <div class="date-box" style="background:#6e5445; color:#fff; padding:0.75rem 2.5rem 0.75rem 1.5rem; border-radius:0.5rem; font-size:1.2rem;">
            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
            <span class="time-box" id="clock" style="margin-left:2rem; font-weight:bold; font-size:1.3rem;">00:00</span>
        </div>
    </div>
    <div style="flex:1; display:flex; align-items:center; justify-content:center; min-height:80vh;">
        <div style="display:flex; width:100%; max-width:1100px; justify-content:center; align-items:center;">
            <div style="flex:1; display:flex; justify-content:center; align-items:center;">
                <div style="font-size:6rem; font-family:serif; color:#fff; line-height:1.05; text-align:right;">Hi!<br>Life</div>
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