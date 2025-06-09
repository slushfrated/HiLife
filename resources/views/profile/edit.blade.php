<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto space-y-8">
            <div style="background:var(--container-bg); color:var(--container-text); border-radius:1.2rem; box-shadow:0 2px 12px #0002; padding:2.5rem 2.5rem 2rem 2.5rem;">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div style="background:var(--container-bg); color:var(--quest-card-text, #4b3a2f); border-radius:1.2rem; box-shadow:0 2px 12px #0002; padding:2.5rem 2.5rem 2rem 2.5rem;">
                <div class="max-w-xl mx-auto">
                    <form method="POST" action="{{ route('profile.theme') }}">
                        @csrf
                        <div>
                            <label for="current_theme_id" class="block text-sm font-medium mb-2" style="color:var(--quest-card-text, #4b3a2f);">Theme</label>
                            <select id="current_theme_id" name="current_theme_id" style="color:#222; background:#fff;" class="block w-full mt-1 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @php
                                    $themes = \App\Models\Theme::all()->unique('name');
                                @endphp
                                @foreach($themes as $theme)
                                    <option value="{{ $theme->id }}" @if($user->current_theme_id == $theme->id) selected @endif>
                                        {{ $theme->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="mt-4 px-4 py-2 rounded font-bold" style="background:#222; color:#fff; border:none;">Save Theme</button>
                    </form>
                </div>
            </div>
            <div style="background:var(--container-bg); color:var(--container-text); border-radius:1.2rem; box-shadow:0 2px 12px #0002; padding:2.5rem 2.5rem 2rem 2.5rem;">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div style="background:var(--container-bg); color:var(--container-text); border-radius:1.2rem; box-shadow:0 2px 12px #0002; padding:2.5rem 2.5rem 2rem 2.5rem;">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
