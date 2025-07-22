<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color:var(--header-text, var(--primary, #654D48)); font-family:var(--font-family, inherit);">
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
                            <select id="current_theme_id" name="current_theme_id" style="color:var(--input-text, #222); background:var(--input-bg, #fff); font-family:var(--font-family,inherit);" class="block w-full mt-1 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($allThemes as $theme)
                                    <option value="{{ $theme->id }}"
                                        @if($user->current_theme_id == $theme->id) selected @endif
                                        @if(!in_array($theme->id, $unlockedThemes)) disabled style="opacity:0.5; color:#aaa;" @endif>
                                        {{ $theme->name }}@if(!in_array($theme->id, $unlockedThemes)) (Locked)@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="mt-4 px-4 py-2 rounded font-bold" style="background:var(--primary, #222); color:var(--button-text, #fff); border:none;">Save Theme</button>
                    </form>
                </div>
            </div>
            <div style="background:var(--container-bg); color:var(--quest-card-text, #4b3a2f); border-radius:1.2rem; box-shadow:0 2px 12px #0002; padding:2.5rem 2.5rem 2rem 2.5rem;">
                <div class="max-w-xl mx-auto">
                    <form method="POST" action="{{ route('profile.updateTitle') }}">
                        @csrf
                        <div>
                            <label for="current_title_achievement_id" class="block text-sm font-medium mb-2" style="color:var(--quest-card-text, #4b3a2f);">Title</label>
                            <select id="current_title_achievement_id" name="current_title_achievement_id" style="color:var(--input-text, #222); background:var(--input-bg, #fff); font-family:var(--font-family,inherit);" class="block w-full mt-1 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" autocomplete="off">
                                <option value="" @if(!$user->current_title_achievement_id) selected @endif>None</option>
                                @foreach($user->achievements()->whereNotNull('unlocked_at')->get() as $achievement)
                                    <option value="{{ $achievement->id }}" @if($user->current_title_achievement_id == $achievement->id) selected @endif>{{ $achievement->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="mt-4 px-4 py-2 rounded font-bold" style="background:var(--primary, #222); color:var(--button-text, #fff); border:none;">Save Title</button>
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
