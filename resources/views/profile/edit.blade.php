<x-app-layout>
    {{-- title --}}
    <x-slot name="title">
        {{ __('Edit Profile') }}
    </x-slot>
    {{-- akhir title --}}
    <div class="w-full mx-4 xl:w-[80%]">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 xl:p-8 bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-image-profile')
                </div>
            </div>

            <div class="p-4 xl:p-8 bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 xl:p-8 bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 xl:p-8 bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
