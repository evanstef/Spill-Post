<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative">
                <x-text-input id="update_password_current_password" class="block mt-1 w-full"
                             type="password"
                             name="current_password"
                             required autocomplete="current-password" />
                 <svg class="w-6 h-6 absolute top-2 right-2" id="show_updated_current_password" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path class="fill-white" d="M8 16C7.46957 16 6.96086 15.7893 6.58579 15.4142C6.21071 15.0391 6 14.5304 6 14C6 12.89 6.89 12 8 12C8.53043 12 9.03914 12.2107 9.41421 12.5858C9.78929 12.9609 10 13.4696 10 14C10 14.5304 9.78929 15.0391 9.41421 15.4142C9.03914 15.7893 8.53043 16 8 16ZM14 19V9H2V19H14ZM14 7C14.5304 7 15.0391 7.21071 15.4142 7.58579C15.7893 7.96086 16 8.46957 16 9V19C16 19.5304 15.7893 20.0391 15.4142 20.4142C15.0391 20.7893 14.5304 21 14 21H2C1.46957 21 0.960859 20.7893 0.585786 20.4142C0.210714 20.0391 0 19.5304 0 19V9C0 7.89 0.89 7 2 7H3V5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C8.65661 0 9.30679 0.129329 9.91342 0.380602C10.52 0.631876 11.0712 1.00017 11.5355 1.46447C11.9998 1.92876 12.3681 2.47995 12.6194 3.08658C12.8707 3.69321 13 4.34339 13 5V7H14ZM8 2C7.20435 2 6.44129 2.31607 5.87868 2.87868C5.31607 3.44129 5 4.20435 5 5V7H11V5C11 4.20435 10.6839 3.44129 10.1213 2.87868C9.55871 2.31607 8.79565 2 8 2Z" fill="black"/>
                 </svg>
                 <svg class="w-6 h-6 absolute hidden top-2 right-2" id="hide_updated_current_password" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path class="fill-white" d="M7.89 4.82L6.25 3.16C6.61716 2.2286 7.256 1.42917 8.08348 0.865621C8.91097 0.302074 9.88884 0.000466917 10.89 0C13.65 0 15.89 2.24 15.89 5V7H16.89C17.4204 7 17.9291 7.21071 18.3042 7.58579C18.6793 7.96086 18.89 8.46957 18.89 9V15.8L16.89 13.8V9H12.09L10.09 7H13.89V5C13.89 3.34 12.55 2 10.89 2C9.3 2 8 3.25 7.89 4.82ZM21 20.46L19.73 21.73L18.35 20.35C17.99 20.75 17.47 21 16.89 21H4.89C4.35957 21 3.85086 20.7893 3.47579 20.4142C3.10071 20.0391 2.89 19.5304 2.89 19V9C2.89 7.89 3.78 7 4.89 7H5L0 2L1.28 0.73L21 20.46ZM16.89 18.89L12.74 14.74C12.45 15.5 11.73 16 10.89 16C10.3596 16 9.85086 15.7893 9.47579 15.4142C9.10071 15.0391 8.89 14.5304 8.89 14C8.89 13.15 9.39 12.44 10.15 12.15L7 9H4.89V19H16.89V18.89Z" fill="black"/>
                 </svg>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative">
                <x-text-input id="update_password_password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required autocomplete="current-password" />
                 <svg class="w-6 h-6 absolute top-2 right-2" id="show_updated_new_password" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path class="fill-white" d="M8 16C7.46957 16 6.96086 15.7893 6.58579 15.4142C6.21071 15.0391 6 14.5304 6 14C6 12.89 6.89 12 8 12C8.53043 12 9.03914 12.2107 9.41421 12.5858C9.78929 12.9609 10 13.4696 10 14C10 14.5304 9.78929 15.0391 9.41421 15.4142C9.03914 15.7893 8.53043 16 8 16ZM14 19V9H2V19H14ZM14 7C14.5304 7 15.0391 7.21071 15.4142 7.58579C15.7893 7.96086 16 8.46957 16 9V19C16 19.5304 15.7893 20.0391 15.4142 20.4142C15.0391 20.7893 14.5304 21 14 21H2C1.46957 21 0.960859 20.7893 0.585786 20.4142C0.210714 20.0391 0 19.5304 0 19V9C0 7.89 0.89 7 2 7H3V5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C8.65661 0 9.30679 0.129329 9.91342 0.380602C10.52 0.631876 11.0712 1.00017 11.5355 1.46447C11.9998 1.92876 12.3681 2.47995 12.6194 3.08658C12.8707 3.69321 13 4.34339 13 5V7H14ZM8 2C7.20435 2 6.44129 2.31607 5.87868 2.87868C5.31607 3.44129 5 4.20435 5 5V7H11V5C11 4.20435 10.6839 3.44129 10.1213 2.87868C9.55871 2.31607 8.79565 2 8 2Z" fill="black"/>
                 </svg>
                 <svg class="w-6 h-6 absolute hidden top-2 right-2" id="hide_updated_new_password" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path class="fill-white" d="M7.89 4.82L6.25 3.16C6.61716 2.2286 7.256 1.42917 8.08348 0.865621C8.91097 0.302074 9.88884 0.000466917 10.89 0C13.65 0 15.89 2.24 15.89 5V7H16.89C17.4204 7 17.9291 7.21071 18.3042 7.58579C18.6793 7.96086 18.89 8.46957 18.89 9V15.8L16.89 13.8V9H12.09L10.09 7H13.89V5C13.89 3.34 12.55 2 10.89 2C9.3 2 8 3.25 7.89 4.82ZM21 20.46L19.73 21.73L18.35 20.35C17.99 20.75 17.47 21 16.89 21H4.89C4.35957 21 3.85086 20.7893 3.47579 20.4142C3.10071 20.0391 2.89 19.5304 2.89 19V9C2.89 7.89 3.78 7 4.89 7H5L0 2L1.28 0.73L21 20.46ZM16.89 18.89L12.74 14.74C12.45 15.5 11.73 16 10.89 16C10.3596 16 9.85086 15.7893 9.47579 15.4142C9.10071 15.0391 8.89 14.5304 8.89 14C8.89 13.15 9.39 12.44 10.15 12.15L7 9H4.89V19H16.89V18.89Z" fill="black"/>
                 </svg>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm New Password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="update_password_password_confirmation" class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation"
                             required autocomplete="current-password" />
                 <svg class="w-6 h-6 absolute top-2 right-2" id="show_updated_confirm_new_password" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path class="fill-white" d="M8 16C7.46957 16 6.96086 15.7893 6.58579 15.4142C6.21071 15.0391 6 14.5304 6 14C6 12.89 6.89 12 8 12C8.53043 12 9.03914 12.2107 9.41421 12.5858C9.78929 12.9609 10 13.4696 10 14C10 14.5304 9.78929 15.0391 9.41421 15.4142C9.03914 15.7893 8.53043 16 8 16ZM14 19V9H2V19H14ZM14 7C14.5304 7 15.0391 7.21071 15.4142 7.58579C15.7893 7.96086 16 8.46957 16 9V19C16 19.5304 15.7893 20.0391 15.4142 20.4142C15.0391 20.7893 14.5304 21 14 21H2C1.46957 21 0.960859 20.7893 0.585786 20.4142C0.210714 20.0391 0 19.5304 0 19V9C0 7.89 0.89 7 2 7H3V5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C8.65661 0 9.30679 0.129329 9.91342 0.380602C10.52 0.631876 11.0712 1.00017 11.5355 1.46447C11.9998 1.92876 12.3681 2.47995 12.6194 3.08658C12.8707 3.69321 13 4.34339 13 5V7H14ZM8 2C7.20435 2 6.44129 2.31607 5.87868 2.87868C5.31607 3.44129 5 4.20435 5 5V7H11V5C11 4.20435 10.6839 3.44129 10.1213 2.87868C9.55871 2.31607 8.79565 2 8 2Z" fill="black"/>
                 </svg>
                 <svg class="w-6 h-6 absolute hidden top-2 right-2" id="hide_updated_confirm_new_password" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path class="fill-white" d="M7.89 4.82L6.25 3.16C6.61716 2.2286 7.256 1.42917 8.08348 0.865621C8.91097 0.302074 9.88884 0.000466917 10.89 0C13.65 0 15.89 2.24 15.89 5V7H16.89C17.4204 7 17.9291 7.21071 18.3042 7.58579C18.6793 7.96086 18.89 8.46957 18.89 9V15.8L16.89 13.8V9H12.09L10.09 7H13.89V5C13.89 3.34 12.55 2 10.89 2C9.3 2 8 3.25 7.89 4.82ZM21 20.46L19.73 21.73L18.35 20.35C17.99 20.75 17.47 21 16.89 21H4.89C4.35957 21 3.85086 20.7893 3.47579 20.4142C3.10071 20.0391 2.89 19.5304 2.89 19V9C2.89 7.89 3.78 7 4.89 7H5L0 2L1.28 0.73L21 20.46ZM16.89 18.89L12.74 14.74C12.45 15.5 11.73 16 10.89 16C10.3596 16 9.85086 15.7893 9.47579 15.4142C9.10071 15.0391 8.89 14.5304 8.89 14C8.89 13.15 9.39 12.44 10.15 12.15L7 9H4.89V19H16.89V18.89Z" fill="black"/>
                 </svg>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>
        <x-primary-button class="mt-4" type="submit">{{ __('Save') }}</x-primary-button>
    </form>

    {{-- flash message --}}
    @if (session('status') === 'password-updated')
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
                <p>{{ __('Password Update Successfully') }}</p>
        </div>
    @endif
</section>
<script>
    // semua inputan password
    const passwordUpdatedCurrent = document.getElementById('update_password_current_password');
    const passwordUpdatedNew = document.getElementById('update_password_password');
    const passwordUpdatedConfirm = document.getElementById('update_password_password_confirmation');

    // semua show icon password
    const showPasswordUpdatedCurrent = document.getElementById('show_updated_current_password');
    const showPasswordUpdatedNew = document.getElementById('show_updated_new_password');
    const showPasswordUpdatedConfirm = document.getElementById('show_updated_confirm_new_password');

    // semua hide icon password
    const hidePasswordUpdatedCurrent = document.getElementById('hide_updated_current_password');
    const hidePasswordUpdatedNew = document.getElementById('hide_updated_new_password');
    const hidePasswordUpdatedConfirm = document.getElementById('hide_updated_confirm_new_password');


    // show password current
    showPasswordUpdatedCurrent.addEventListener('click', () => {
        passwordUpdatedCurrent.setAttribute('type', 'text');
        showPasswordUpdatedCurrent.classList.add('hidden');
        hidePasswordUpdatedCurrent.classList.remove('hidden');
    });

    // hide password current
    hidePasswordUpdatedCurrent.addEventListener('click', () => {
        passwordUpdatedCurrent.setAttribute('type', 'password');
        showPasswordUpdatedCurrent.classList.remove('hidden');
        hidePasswordUpdatedCurrent.classList.add('hidden');
    });


    // show password new
    showPasswordUpdatedNew.addEventListener('click', () => {
        passwordUpdatedNew.setAttribute('type', 'text');
        showPasswordUpdatedNew.classList.add('hidden');
        hidePasswordUpdatedNew.classList.remove('hidden');
    });

    // hide password new
    hidePasswordUpdatedNew.addEventListener('click', () => {
        passwordUpdatedNew.setAttribute('type', 'password');
        showPasswordUpdatedNew.classList.remove('hidden');
        hidePasswordUpdatedNew.classList.add('hidden');
    });

    // show password confirm
    showPasswordUpdatedConfirm.addEventListener('click', () => {
        passwordUpdatedConfirm.setAttribute('type', 'text');
        showPasswordUpdatedConfirm.classList.add('hidden');
        hidePasswordUpdatedConfirm.classList.remove('hidden');
    });

    // hide password confirm
    hidePasswordUpdatedConfirm.addEventListener('click', () => {
        passwordUpdatedConfirm.setAttribute('type', 'password');
        showPasswordUpdatedConfirm.classList.remove('hidden');
        hidePasswordUpdatedConfirm.classList.add('hidden');
    });
</script>
