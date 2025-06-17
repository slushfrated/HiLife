@extends('layouts.guest')

@section('content')
<div class="auth-bg">
    <div class="auth-header">
        <!-- Date and time removed -->
    </div>
    <div class="auth-content">
        <div style="display:flex; align-items:center; width:100%; justify-content:center;">
            <div class="welcome" style="display:flex; flex-direction:column; align-items:center; width:100%; text-align:center;">
                <h2 style="font-weight:400; font-size:2rem; margin-bottom:1rem;">Welcome Aboard, Grindmasters! <span style="font-size:1.5rem;">☕</span></h2>
                <div style="margin-bottom:1.5rem;">New around here? Let's get you a name!</div>
                <form method="POST" action="{{ route('set-name.store') }}" style="width:350px;">
                    @csrf
                    <input type="text" name="name" placeholder="Enter your name here!" required style="width:100%; padding:0.75rem; border-radius:0.5rem; border:none; font-size:1rem; color:#333; margin-bottom:1rem;">
                    <button type="submit" class="btn-green" style="margin-top:1.5rem;">That's my name!</button>
                </form>
            </div>
        </div>
    </div>
    <div class="floating-speaker">
        <span style="font-size:2rem; color:white;">🔊</span>
    </div>
</div>
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