<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Profile Image') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __("Update your image profile") }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update-user-image') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-6">
            <img class="w-24 h-24 sm:w-28 sm:h-28 xl:w-32 xl:h-32 rounded-full object-cover" src="{{ Auth::user()->image ? Auth::user()->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
            <div class="flex flex-col items-start">
                <label for="user_image" class="block text-sm md:text-base hover:cursor-pointer bg-gray-600 hover:bg-gray-700 px-3 py-1 sm:py-2 sm:px-4 rounded-lg font-medium text-gray-200">Choose Image</label>
                {{-- input user image --}}
                <input type="file" id="user_image" name="image" class="hidden" onchange="previewImage(event)">
                @error('image')
                    <p class="text-red-500 mt-1">{{ $message }}</p>
                @enderror

                {{-- preview user image --}}
                <div id="preview_user_image" class="mt-4 w-28 h-28 xl:w-32 xl:h-32 hidden relative">
                    <img id="preview_image" class="w-full h-full hidden object-cover rounded-lg" alt="Preview">
                    <button type="button" id="remove_user_image" onclick="cancelImage()" class="absolute hidden top-1 right-1">
                        <svg class="w-6 h-6 sm:w-5 sm:h-5 p-1 bg-white rounded-full" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-black" d="M9.40994 8.00019L15.7099 1.71019C15.8982 1.52188 16.004 1.26649 16.004 1.00019C16.004 0.733884 15.8982 0.478489 15.7099 0.290185C15.5216 0.101882 15.2662 -0.00390625 14.9999 -0.00390625C14.7336 -0.00390625 14.4782 0.101882 14.2899 0.290185L7.99994 6.59019L1.70994 0.290185C1.52164 0.101882 1.26624 -0.00390601 0.999939 -0.00390601C0.733637 -0.00390601 0.478243 0.101882 0.289939 0.290185C0.101635 0.478489 -0.00415253 0.733884 -0.00415254 1.00019C-0.00415254 1.26649 0.101635 1.52188 0.289939 1.71019L6.58994 8.00019L0.289939 14.2902C0.196211 14.3831 0.121816 14.4937 0.0710478 14.6156C0.0202791 14.7375 -0.00585938 14.8682 -0.00585938 15.0002C-0.00585938 15.1322 0.0202791 15.2629 0.0710478 15.3848C0.121816 15.5066 0.196211 15.6172 0.289939 15.7102C0.382902 15.8039 0.493503 15.8783 0.615362 15.9291C0.737221 15.9798 0.867927 16.006 0.999939 16.006C1.13195 16.006 1.26266 15.9798 1.38452 15.9291C1.50638 15.8783 1.61698 15.8039 1.70994 15.7102L7.99994 9.41018L14.2899 15.7102C14.3829 15.8039 14.4935 15.8783 14.6154 15.9291C14.7372 15.9798 14.8679 16.006 14.9999 16.006C15.132 16.006 15.2627 15.9798 15.3845 15.9291C15.5064 15.8783 15.617 15.8039 15.7099 15.7102C15.8037 15.6172 15.8781 15.5066 15.9288 15.3848C15.9796 15.2629 16.0057 15.1322 16.0057 15.0002C16.0057 14.8682 15.9796 14.7375 15.9288 14.6156C15.8781 14.4937 15.8037 14.3831 15.7099 14.2902L9.40994 8.00019Z" fill="black"/>
                        </svg>
                    </button>

                </div>
            </div>
        </div>
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </form>

    {{-- flash message --}}
    @if (session('status') === 'image-updated')
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
                <p>{{ __('Image Update Successfully') }}</p>
        </div>
    @endif
</section>
<script>
    function previewImage(event) {
        const previewContainer = document.getElementById('preview_user_image');
        const previewImage = document.getElementById('preview_image');
        const cancelButton = document.getElementById('remove_user_image');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                cancelButton.classList.remove('hidden');
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function cancelImage() {
        const fileInput = document.getElementById('user_image');
        const previewContainer = document.getElementById('preview_user_image');
        const previewImage = document.getElementById('preview_image');
        const cancelButton = document.getElementById('remove_user_image');

        fileInput.value = ''; // Reset file input
        previewImage.src = ''; // Clear image source
        previewImage.classList.add('hidden'); // Hide the image
        cancelButton.classList.add('hidden'); // Hide the cancel button
        previewContainer.classList.add('hidden');
    }
</script>
