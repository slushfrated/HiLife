<section>
    <header>
        <h2 style="color:var(--quest-card-text, #4b3a2f); font-size:1.5rem; font-weight:bold;">{{ __('Profile Information') }}</h2>

        <p class="mt-1 text-sm" style="color:var(--quest-card-text, #4b3a2f); opacity:0.85;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Profile Picture Display -->
    <div class="mb-4 flex flex-col items-center">
        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default-avatar.png') }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover border-2 border-gray-300 shadow" />
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" style="color:var(--quest-card-text, #4b3a2f); font-weight:bold;" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" style="color:var(--quest-card-text, #4b3a2f); font-weight:bold;" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Profile Picture Upload -->
        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" style="color:var(--quest-card-text, #4b3a2f); font-weight:bold;" />
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm" style="color:var(--quest-card-text, #4b3a2f); opacity:0.85;"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
