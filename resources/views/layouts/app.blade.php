<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SpillPost {{ isset($title) ? ' | ' . $title : '' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body x-data="{ open: {{ $errors->has('content_coba') || $errors->has('image_posts.*') ? 'true' : 'false' }}, isSubmitSpill : false,isSubmitReply : false ,openReply: {{ $errors->has('reply_comment') ? 'true' : 'false' }}, commentId: null, username: '' }" :class="{ 'overflow-hidden': open || openReply }" class="font-sans antialiased text-white">

                {{-- form untuk membuat postingan --}}
                <div x-show="open"
                     x-init="$nextTick(() => { if ({{ $errors->has('content_coba') || $errors->has('image_posts.*') ? 'true' : 'false' }}) open = true })"
                     class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50"
                     @keydown.escape.window="open = false" style="display: {{ $errors->has('content_coba') || $errors->has('image_posts.*') ? 'block' : 'none' }};">

                    {{-- Modal Content --}}
                    <div class="z-50 bg-gray-800 w-11/12 sm:w-3/4 lg:w-[70%] xl:w-[40%] rounded-lg p-6 sm:p-4 lg:p-6 relative" @click.outside="open = false">

                        {{-- Form Content --}}
                        <h2 class="lg:text-xl font-bold mb-4">What Do You Want To Spill Today ?</h2>
                        <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data" @submit.prevent="isSubmitSpill = true; $el.submit();">

                            @csrf
                            <div class="mb-4 relative">
                                <textarea name="content_coba" id="content" rows="6" cols="10"
                                    class="mt-1 text-sm lg:text-base block w-full border-none bg-transparent focus:ring-0 focus:border-none" placeholder="What's on your mind ?" oninput="showHashtag()"></textarea>

                                {{-- menampilkan hashtag yang tersedia tergantung dari kata kunci yang user ketik --}}
                                <div id="hashtag-container" class="absolute hidden w-36 lg:w-44 h-auto bg-gray-800 rounded shadow-lg border border-gray-700 top-36 left-7 lg:top-40 xl:top-44 sm:left-10 p-1 lg:p-2 space-y-2">
                                </div>
                                {{-- akhir dari container hashtag --}}
                                @error('content_coba')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Image Upload --}}
                            <div class="mt-4">
                                <label class="hover:cursor-pointer" for="post_input_image">
                                    <svg width="24" height="24" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path class="fill-black dark:fill-white" d="M17 0H3C2.20435 0 1.44129 0.316071 0.87868 0.87868C0.316071 1.44129 0 2.20435 0 3V17C0 17.7956 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20H17C17.1645 19.9977 17.3284 19.981 17.49 19.95L17.79 19.88H17.86H17.91L18.28 19.74L18.41 19.67C18.51 19.61 18.62 19.56 18.72 19.49C18.8535 19.3918 18.9805 19.2849 19.1 19.17L19.17 19.08C19.2682 18.9805 19.3585 18.8735 19.44 18.76L19.53 18.63C19.5998 18.5187 19.6601 18.4016 19.71 18.28C19.7374 18.232 19.7609 18.1818 19.78 18.13C19.83 18.01 19.86 17.88 19.9 17.75V17.6C19.9567 17.4046 19.9903 17.2032 20 17V3C20 2.20435 19.6839 1.44129 19.1213 0.87868C18.5587 0.316071 17.7956 0 17 0ZM3 18C2.73478 18 2.48043 17.8946 2.29289 17.7071C2.10536 17.5196 2 17.2652 2 17V12.69L5.29 9.39C5.38296 9.29627 5.49356 9.22188 5.61542 9.17111C5.73728 9.12034 5.86799 9.0942 6 9.0942C6.13201 9.0942 6.26272 9.12034 6.38458 9.17111C6.50644 9.22188 6.61704 9.29627 6.71 9.39L15.31 18H3ZM18 17C17.9991 17.1233 17.9753 17.2453 17.93 17.36C17.9071 17.4087 17.8804 17.4556 17.85 17.5C17.8232 17.5423 17.7931 17.5825 17.76 17.62L12.41 12.27L13.29 11.39C13.383 11.2963 13.4936 11.2219 13.6154 11.1711C13.7373 11.1203 13.868 11.0942 14 11.0942C14.132 11.0942 14.2627 11.1203 14.3846 11.1711C14.5064 11.2219 14.617 11.2963 14.71 11.39L18 14.69V17ZM18 11.86L16.12 10C15.5477 9.45699 14.7889 9.15428 14 9.15428C13.2111 9.15428 12.4523 9.45699 11.88 10L11 10.88L8.12 8C7.54772 7.45699 6.7889 7.15428 6 7.15428C5.2111 7.15428 4.45228 7.45699 3.88 8L2 9.86V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2H17C17.2652 2 17.5196 2.10536 17.7071 2.29289C17.8946 2.48043 18 2.73478 18 3V11.86ZM11.5 4C11.2033 4 10.9133 4.08797 10.6666 4.2528C10.42 4.41762 10.2277 4.65189 10.1142 4.92597C10.0006 5.20006 9.97094 5.50166 10.0288 5.79264C10.0867 6.08361 10.2296 6.35088 10.4393 6.56066C10.6491 6.77044 10.9164 6.9133 11.2074 6.97118C11.4983 7.02906 11.7999 6.99935 12.074 6.88582C12.3481 6.77229 12.5824 6.58003 12.7472 6.33335C12.912 6.08668 13 5.79667 13 5.5C13 5.10218 12.842 4.72064 12.5607 4.43934C12.2794 4.15804 11.8978 4 11.5 4Z" fill="black"/>
                                    </svg>
                                </label>
                                <input type="file" name="image_posts[]" accept="image/*" id="post_input_image" class="hidden" multiple onchange="previewPostImages(event)">

                                {{-- preview post image --}}
                                <div id="preview_post_image" class="my-4 py-2 grid-cols-3 sm:grid-cols-4 gap-3 lg:gap-4 h-24 sm:h-44 md:h-48 lg:h-52 xl:h-[190px] hidden overflow-y-scroll scrollbar-thumb-gray-400 scrollbar-track-transparent scrollbar-thin"></div>

                               @error('image_posts.*')
                                   <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                               @enderror
                            </div>

                            <div class="flex justify-end">
                                <button @click="open = false" type="button" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                                <button type="submit"
                                        :disabled = "isSubmitSpill"
                                        :class="isSubmitSpill ? 'bg-blue-700 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                                        class="px-4 py-2 text-white rounded-lg">
                                        <span x-text="isSubmitSpill ? 'Loading...' : 'Spill'"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                {{-- akhir dari spill form --}}

                {{-- Form untuk reply comment --}}
                <div x-show="openReply"
                x-init="$nextTick(() => { if ({{ $errors->has('reply_comment') ? 'true' : 'false' }}) openReply = true })"
                class="fixed inset-0 flex bg-gray-900 bg-opacity-75 items-center justify-center z-50"
                @keydown.escape.window="openReply = false"
                style="display: {{ $errors->has('reply_comment') ? 'block' : 'none' }};">

                    {{-- Modal Content --}}
                    <div class="bg-white dark:bg-gray-800 w-11/12 sm:w-3/4 lg:w-[70%] xl:w-[40%] rounded-lg relative p-6 sm:p-4 lg:p-6">
                        {{-- Form Content --}}
                        <h2 class="lg:text-xl font-bold mb-4">Reply Comment from <span x-text="username"></span></h2>
                        <form :action="`/comment/${commentId}/reply`" method="POST" @submit.prevent="isSubmitReply = true; $el.submit();">
                            @csrf

                            <div class="mb-4">
                                <x-text-input name="reply_comment" class="w-full block" type="text" placeholder="Reply a comment..." autocomplete="off"></x-text-input>
                                <x-input-error :messages="$errors->get('reply_comment')" class="mt-2" />
                            </div>

                            <div class="flex justify-end">
                                <button @click="openReply = false" type="button" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                                <button type="submit"
                                        :disabled = "isSubmitReply"
                                        :class="isSubmitReply ? 'bg-blue-700 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                                        class="px-4 py-2 text-white rounded-lg">
                                    <span x-text="isSubmitReply ? 'Loading...' : 'Reply'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- akhir dari reply comment form --}}




        {{-- main content semua --}}
        <div class="min-h-screen bg-gray-900">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto sm:px-6 lg:px-7 flex items-start justify-between mt-10 gap-5 lg:gap-6 xl:gap-10 pb-28 sm:pb-10">
                <x-sidebar />
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

<script>
    function previewPostImages(event) {
        const previewPostContainer = document.getElementById('preview_post_image');
        const files = event.target.files;

        previewPostContainer.innerHtml = '';

        if (files.length > 0) {
        previewPostContainer.classList.remove('hidden');
        previewPostContainer.classList.add('grid'); // Tampilkan kontainer gambar jika ada gambar yang diunggah

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                // Membuat elemen kontainer untuk setiap gambar dan tombol hapus
                const imageWrapper = document.createElement('div');
                imageWrapper.classList.add('relative', 'w-18', 'h-16', 'sm:w-24', 'sm:h-[70px]', 'md:w-28', 'md:h-20' ,'lg:w-36', 'lg:h-24', 'xl:w-[120px]', 'xl:h-[90px]');

                // Membuat elemen img untuk menampilkan gambar
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-full', 'h-full', 'object-cover', 'rounded', 'xl:rounded-lg');

                // Membuat tombol hapus untuk setiap gambar
                const cancelButton = document.createElement('button');
                cancelButton.type = 'button';
                cancelButton.classList.add('absolute', 'top-[2px]', 'md:top-1', 'right-[2px]' ,'md:right-1', 'rounded-full');
                cancelButton.innerHTML = `
                    <svg class="w-4 h-4 md:w-5 md:h-5 p-1 bg-white rounded-full" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-black" d="M9.40994 8.00019L15.7099 1.71019C15.8982 1.52188 16.004 1.26649 16.004 1.00019C16.004 0.733884 15.8982 0.478489 15.7099 0.290185C15.5216 0.101882 15.2662 -0.00390625 14.9999 -0.00390625C14.7336 -0.00390625 14.4782 0.101882 14.2899 0.290185L7.99994 6.59019L1.70994 0.290185C1.52164 0.101882 1.26624 -0.00390601 0.999939 -0.00390601C0.733637 -0.00390601 0.478243 0.101882 0.289939 0.290185C0.101635 0.478489 -0.00415253 0.733884 -0.00415254 1.00019C-0.00415254 1.26649 0.101635 1.52188 0.289939 1.71019L6.58994 8.00019L0.289939 14.2902C0.196211 14.3831 0.121816 14.4937 0.0710478 14.6156C0.0202791 14.7375 -0.00585938 14.8682 -0.00585938 15.0002C-0.00585938 15.1322 0.0202791 15.2629 0.0710478 15.3848C0.121816 15.5066 0.196211 15.6172 0.289939 15.7102C0.382902 15.8039 0.493503 15.8783 0.615362 15.9291C0.737221 15.9798 0.867927 16.006 0.999939 16.006C1.13195 16.006 1.26266 15.9798 1.38452 15.9291C1.50638 15.8783 1.61698 15.8039 1.70994 15.7102L7.99994 9.41018L14.2899 15.7102C14.3829 15.8039 14.4935 15.8783 14.6154 15.9291C14.7372 15.9798 14.8679 16.006 14.9999 16.006C15.132 16.006 15.2627 15.9798 15.3845 15.9291C15.5064 15.8783 15.617 15.8039 15.7099 15.7102C15.8037 15.6172 15.8781 15.5066 15.9288 15.3848C15.9796 15.2629 16.0057 15.1322 16.0057 15.0002C16.0057 14.8682 15.9796 14.7375 15.9288 14.6156C15.8781 14.4937 15.8037 14.3831 15.7099 14.2902L9.40994 8.00019Z" fill="black"/>
                    </svg>
                `;

                // Fungsi untuk menghapus gambar tertentu saat tombol hapus diklik
                cancelButton.onclick = function() {
                    imageWrapper.remove();
                    if (previewPostContainer.children.length === 0) {
                        previewPostContainer.classList.add('hidden'); // Sembunyikan kontainer jika semua gambar dihapus
                    }
                };

                // Menambahkan gambar dan tombol hapus ke dalam kontainer gambar
                imageWrapper.appendChild(img);
                imageWrapper.appendChild(cancelButton);
                previewPostContainer.appendChild(imageWrapper);
            };

            reader.readAsDataURL(file);
        }
      }

    }

    // function untuk menampilkan hashtag pada saat user
    async function showHashtag() {
        const content = document.getElementById('content').value;
        const hashtagContainer = document.getElementById('hashtag-container');

        // Regex untuk mendeteksi hashtag yang valid tanpa spasi atau enter setelahnya
        const hashtagMatch = content.match(/(^|\s)#\w+$/g);

        // Jika hashtag ada di akhir kalimat dan tidak diikuti spasi atau enter
        if (hashtagMatch && !content.endsWith(' ') && !content.endsWith('\n')) {

            hashtagContainer.classList.remove('hidden'); // Tampilkan container jika ada

            // untuk mengambil hashtag terbaru yang diinput oleh user
            const hashtag = hashtagMatch[0].trim();

            // Memuat data hashtag dari API
            try {
                const response = await fetch(`/api/hashtag?content_hashtag=${encodeURIComponent(hashtag)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const hashtags = await response.json();

                console.log(hashtags);

                // pengecekan bila hashtags tidak ada
                if(hashtags.length === 0) {
                    hashtagContainer.innerHTML = '<div class="text-[10px] sm:text-[12px] text-center">No Hashtag Available Create New One</div>';
                } else {
                    // melooping semua data hashtags yang ada
                    hashtagContainer.innerHTML = hashtags.map((item) => {
                    return `
                        <div onclick="selectHashtag('${item.name}')" class="text-[9px] sm:text-[10px] rounded px-2 py-1 lg:py-2 lg:text-sm hover:cursor-pointer hover:bg-gray-700 duration-200 ease-in-out line-clamp-1">
                            ${item.name}
                        </div>
                    `
                    }).join('');
                }



            } catch (error) {
              console.log(error.message);
            }

        } else {
            hashtagContainer.classList.add('hidden'); // Sembunyikan container
        }
    }

    // function untuk memilih hashtag yang diinput oleh user
    function selectHashtag(hashtag) {
        const content = document.getElementById('content');
        const currentText = content.value;

        // Menyisipkan hashtag yang diklik
        const newText = currentText.replace(/#\w+$/, hashtag + ' ');
        content.value = newText;
    }




</script>
