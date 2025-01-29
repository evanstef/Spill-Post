<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea name="description" id="description" rows="6" cols="10"
                            class="mt-1 block w-full border-gray-700 bg-gray-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm">{{ old('content', $user->description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>
        <x-primary-button class="mt-4" type="submit">{{ __('Save') }}</x-primary-button>
    </form>

    {{-- flash message --}}
    @if (session('status') === 'profile-updated')
        <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    x-init="setTimeout(() => show = false, 3000)"
         class="absolute top-20 right-3 sm:right-8 lg:right-14 rounded-lg flex items-center gap-2 bg-gray-700 text-white text-sm md:text-base font-bold px-3 py-2">
                <svg class="w-6 h-6 lg:w-8 lg:h-8" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-green-600" d="M19.4666 10.8187L13.2104 17.0895L10.8041 14.6833C10.6734 14.5306 10.5125 14.4066 10.3316 14.3191C10.1507 14.2316 9.95359 14.1824 9.75275 14.1746C9.55191 14.1669 9.35163 14.2007 9.16449 14.274C8.97735 14.3473 8.80739 14.4586 8.66527 14.6007C8.52315 14.7428 8.41194 14.9128 8.33862 15.0999C8.2653 15.287 8.23146 15.4873 8.23922 15.6882C8.24698 15.889 8.29616 16.0861 8.3837 16.267C8.47123 16.4479 8.59522 16.6088 8.74788 16.7395L12.175 20.1812C12.3112 20.3164 12.4728 20.4233 12.6505 20.4959C12.8282 20.5685 13.0185 20.6052 13.2104 20.6041C13.593 20.6025 13.9596 20.4506 14.2312 20.1812L21.5229 12.8895C21.6596 12.754 21.7681 12.5927 21.8421 12.415C21.9161 12.2373 21.9543 12.0466 21.9543 11.8541C21.9543 11.6616 21.9161 11.471 21.8421 11.2933C21.7681 11.1156 21.6596 10.9543 21.5229 10.8187C21.2496 10.5471 20.88 10.3946 20.4948 10.3946C20.1095 10.3946 19.7399 10.5471 19.4666 10.8187ZM15.5 0.916626C12.6157 0.916626 9.79612 1.77192 7.3979 3.37436C4.99968 4.9768 3.1305 7.2544 2.02672 9.91916C0.922945 12.5839 0.634146 15.5161 1.19685 18.345C1.75955 21.1739 3.14848 23.7724 5.18799 25.8119C7.22751 27.8515 9.82601 29.2404 12.6549 29.8031C15.4838 30.3658 18.416 30.077 21.0808 28.9732C23.7455 27.8694 26.0231 26.0002 27.6256 23.602C29.228 21.2038 30.0833 18.3843 30.0833 15.5C30.0833 13.5849 29.7061 11.6885 28.9732 9.91916C28.2403 8.14983 27.1661 6.54217 25.8119 5.18799C24.4577 3.8338 22.8501 2.7596 21.0808 2.02672C19.3114 1.29384 17.4151 0.916626 15.5 0.916626V0.916626ZM15.5 27.1666C13.1925 27.1666 10.9369 26.4824 9.01831 25.2004C7.09974 23.9185 5.60439 22.0964 4.72137 19.9646C3.83835 17.8328 3.60731 15.487 4.05747 13.2239C4.50763 10.9608 5.61877 8.88199 7.25039 7.25038C8.882 5.61877 10.9608 4.50763 13.2239 4.05747C15.487 3.6073 17.8328 3.83834 19.9646 4.72137C22.0964 5.60439 23.9185 7.09973 25.2004 9.01831C26.4824 10.9369 27.1666 13.1925 27.1666 15.5C27.1666 18.5942 25.9375 21.5616 23.7495 23.7495C21.5616 25.9375 18.5942 27.1666 15.5 27.1666V27.1666Z" fill="#FFFDFD"/>
                </svg>
                <p>{{ __('Profile Update Successfully') }}</p>
        </div>
    @endif
</section>
