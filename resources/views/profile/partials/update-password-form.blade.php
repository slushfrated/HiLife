<section>
    <header>
        <h2 style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-size:1.3rem; font-weight:bold; font-family:var(--font-family,inherit);">
            {{ __('Update Password') }}
        </h2>

        <p style="color:var(--text, var(--quest-card-text, #4b3a2f)); opacity:0.85; font-family:var(--font-family,inherit);">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-weight:bold; font-family:var(--font-family,inherit);" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-weight:bold; font-family:var(--font-family,inherit);" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-weight:bold; font-family:var(--font-family,inherit);" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm" style="color:var(--text, var(--quest-card-text, #4b3a2f)); opacity:0.85; font-family:var(--font-family,inherit);"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
