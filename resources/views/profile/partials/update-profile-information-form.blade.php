<section>
    <header>
        <h2 style="color:var(--quest-card-text, #4b3a2f); font-size:1.5rem; font-weight:bold;">{{ __('Profile Information') }}</h2>

        <p class="mt-1 text-sm" style="color:var(--text, var(--quest-card-text, #4b3a2f)); opacity:0.85;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Profile Picture Display -->
    <div class="mb-4 flex flex-col items-center">
        <div style="position: relative; width: 238px; height: 238px; display: flex; align-items: center; justify-content: center;">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default-avatar.png') }}"
                 alt="Profile Picture"
                 style="width: 140px; height: 140px; border-radius: 50%; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); z-index: 1;" />
            @if($user->avatar_frame && $user->currentFrame)
                @php $isPng = Str::endsWith($user->currentFrame->image_path, '.png'); @endphp
                <img src="{{ asset($user->currentFrame->image_path) }}"
                     alt="Avatar Frame"
                     style="position: absolute; left: 50%; top: 50%; width: {{ $isPng ? '238px' : '140px' }}; height: {{ $isPng ? '238px' : '140px' }}; z-index: 2; pointer-events: none; transform: translate(-50%, -50%);" />
            @endif
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-weight:bold;" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-weight:bold;" />
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
            <x-input-label for="profile_picture" :value="__('Profile Picture')" style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-weight:bold;" />
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <!-- Avatar Frame Selection Dropdown -->
        @if(isset($allFrames) && count($allFrames))
        <div class="mb-4 flex flex-col items-center">
            <label for="avatar_frame" style="color:var(--text, var(--quest-card-text, #4b3a2f)); font-weight:bold; margin-bottom: 0.5rem;">Avatar Frame</label>
            <select id="avatar_frame" name="avatar_frame" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="max-width: 220px;">
                <option value="">No Frame</option>
                @foreach($allFrames as $frame)
                    @php $locked = !in_array($frame->id, $unlockedFrames ?? []); @endphp
                    <option value="{{ $frame->id }}" {{ $user->avatar_frame == $frame->id ? 'selected' : '' }} @if($locked) disabled @endif>
                        {{ $frame->name }} @if($locked) (Locked) @endif
                    </option>
                @endforeach
            </select>
            <div style="margin-top: 0.5rem; display: flex; gap: 1.5rem; flex-wrap: wrap; justify-content: center;">
                @foreach($allFrames as $frame)
                    @php 
                        $locked = !in_array($frame->id, $unlockedFrames ?? []);
                        $isPng = Str::endsWith($frame->image_path, '.png');
                        $frameSize = $isPng ? '100px' : '80px';
                        $bgSize = $frameSize;
                    @endphp
                    <div style="display: flex; flex-direction: column; align-items: center; position: relative; gap: 0.4rem;">
                        <div style="width:{{ $bgSize }}; height:{{ $bgSize }}; border-radius:1.1rem; background:var(--frame-preview-bg, #fffbe6); display:flex; align-items:center; justify-content:center; margin-bottom:0;">
                            <img src="{{ asset($frame->image_path) }}" alt="{{ $frame->name }}" style="width:{{ $frameSize }}; height:{{ $frameSize }}; opacity: {{ $locked ? '0.5' : '1' }};">
                        </div>
                        @if($locked)
                            <span style="position: absolute; top: 8px; left: 8px; color: #b00; background: rgba(255,255,255,0.7); border-radius: 50%; padding: 2px;">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M17 11V7a5 5 0 0 0-10 0v4" stroke="#b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="5" y="11" width="14" height="10" rx="2" stroke="#b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <span style="font-size: 0.8rem; color: #b00;">Locked</span>
                        @endif
                        <span style="font-size: 0.85rem; color: #555;">{{ $frame->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm" style="color:var(--text, var(--quest-card-text, #4b3a2f)); opacity:0.85;"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
