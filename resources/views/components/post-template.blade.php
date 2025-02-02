@props(['post'=> null,
        'userLikesPost' => null ])

<div class="space-y-4">
    {{-- user profile dan waktu post --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            {{-- image users --}}
            <div class="w-6 h-6 md:w-7 md:h-7 xl:w-8 xl:h-8">
                <img class="w-full h-full object-cover rounded-full" src="{{ $post->user->image ? $post->user->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
            </div>
            <a href="{{ route('profile.show', $post->user) }}" class="text-xs md:text-sm lg:text-base hover:underline hover:text-blue-600 duration-300 ease-in-out">{{ $post->user->username }}</a>
        </div>
        <div class="flex items-center gap-2">
            <p class="text-xs md:text-sm lg:text-base">
                {{-- pengkondisian waktu --}}
                {{ $post->created_at->gt(now()->subDays(7)) ? $post->created_at->diffForHumans() : $post->created_at->toFormattedDateString() }}
            </p>
            @if (Auth::check() && Auth::user()->id == $post->user->id && request()->routeIs('profile.show'))
                <div x-data="{ openWarningDeletePost : false , postId : null }">
                    <button class="bg-red-600 rounded-lg px-3 py-1 text-white hover:bg-red-700 duration-300 ease-in-out" type="button"
                    @click="openWarningDeletePost = true; postId = '{{ $post->id }}'">
                        Delete Post
                    </button>

                    {{-- Form Content buat menghapus post --}}
                    <div x-show="openWarningDeletePost" class="fixed top-0 left-0 w-full h-full bg-slate-950 bg-opacity-75 flex justify-center items-center z-50" style="display: none;">
                        <div class="bg-white z-50 dark:bg-gray-800 w-11/12 sm:w-3/4 lg:w-[70%] xl:w-[40%] rounded-lg p-6 sm:p-4  relative" @click.outside="openWarningDeletePost = false">
                                {{-- Form Content --}}
                                <h2 class="lg:text-xl font-bold mb-4">Are You Sure Want To Delete This Post ?</h2>
                                <form :action="`/post/${postId}`" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <h1 class="text-[10px] md:text-sm mb-4">This Post Will Be Deleted Permanently and Cant Be Undone</h1>
                                    <div class="flex justify-end">
                                        <button @click="openWarningDeletePost = false" type="button" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg ">Delete</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Post Content --}}
    <div>
        <p class="text-[11px] sm:text-xs md:text-sm lg:text-base post-content">{!! nl2br(e($post->body)) !!}</p>
    </div>

    {{-- Post Image --}}
    @if ($post->images->count() > 0)
        {{-- pengecekan bila gambar nya hanya satu --}}
        @if ($post->images->count() === 1)
            <div class="w-full h-40 sm:h-44 md:h-52 lg:h-[300px] xl:h-[400px]">
                <img src="{{ $post->images[0]->image_path }}" class="w-full h-full object-contain" alt="Image 1">
            </div>
        @else
        <div id="carousel-{{ $post->id }}" class="carousel w-full relative" data-post-id="{{ $post->id }}">
            @foreach ($post->images as $key => $image)
                <div class="carousel-item relative w-full transition-transform ease-in-out duration-700 {{ $key === 0 ? 'active' : 'hidden' }}" data-slide="{{ $key }}">
                    <div class="w-full h-40 sm:h-44 md:h-52 lg:h-[300px] xl:h-[400px]">
                        <img src="{{ $image->image_path }}" class="w-full h-full object-contain" alt="Image {{ $key + 1 }}">
                    </div>
                </div>
            @endforeach

            {{-- Arrow Controls --}}
            <button data-post-id="{{ $post->id }}" class="prevArrow absolute left-2 xl:left-5 top-1/2 transform -translate-y-1/2 cursor-pointer">
                <!-- SVG Icon untuk Panah Kiri -->
                <svg class="w-2 h-2 sm:w-4 sm:h-4 lg:w-5 lg:h-5" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-white" d="M11 5.00019H3.41002L6.71002 1.71019C6.89832 1.52188 7.00411 1.26649 7.00411 1.00019C7.00411 0.733884 6.89832 0.478489 6.71002 0.290185C6.52172 0.101882 6.26632 -0.00390625 6.00002 -0.00390625C5.73372 -0.00390625 5.47832 0.101882 5.29002 0.290185L0.290018 5.29019C0.198978 5.38529 0.127613 5.49743 0.0800184 5.62019C-0.0199996 5.86365 -0.0199996 6.13672 0.0800184 6.38019C0.127613 6.50294 0.198978 6.61508 0.290018 6.71019L5.29002 11.7102C5.38298 11.8039 5.49358 11.8783 5.61544 11.9291C5.7373 11.9798 5.86801 12.006 6.00002 12.006C6.13203 12.006 6.26274 11.9798 6.3846 11.9291C6.50645 11.8783 6.61706 11.8039 6.71002 11.7102C6.80375 11.6172 6.87814 11.5066 6.92891 11.3848C6.97968 11.2629 7.00582 11.1322 7.00582 11.0002C7.00582 10.8682 6.97968 10.7375 6.92891 10.6156C6.87814 10.4937 6.80375 10.3831 6.71002 10.2902L3.41002 7.00019H11C11.2652 7.00019 11.5196 6.89483 11.7071 6.70729C11.8947 6.51976 12 6.2654 12 6.00019C12 5.73497 11.8947 5.48062 11.7071 5.29308C11.5196 5.10554 11.2652 5.00019 11 5.00019Z" fill="black"/>
                </svg>

            </button>
            <button data-post-id="{{ $post->id }}" class="nextArrow absolute right-2 xl:right-5 top-1/2 transform -translate-y-1/2 cursor-pointer">
                <!-- SVG Icon untuk Panah Kanan -->
                <svg class="w-2 h-2 sm:w-4 sm:h-4 lg:w-5 lg:h-5 rotate-180" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-white" d="M11 5.00019H3.41002L6.71002 1.71019C6.89832 1.52188 7.00411 1.26649 7.00411 1.00019C7.00411 0.733884 6.89832 0.478489 6.71002 0.290185C6.52172 0.101882 6.26632 -0.00390625 6.00002 -0.00390625C5.73372 -0.00390625 5.47832 0.101882 5.29002 0.290185L0.290018 5.29019C0.198978 5.38529 0.127613 5.49743 0.0800184 5.62019C-0.0199996 5.86365 -0.0199996 6.13672 0.0800184 6.38019C0.127613 6.50294 0.198978 6.61508 0.290018 6.71019L5.29002 11.7102C5.38298 11.8039 5.49358 11.8783 5.61544 11.9291C5.7373 11.9798 5.86801 12.006 6.00002 12.006C6.13203 12.006 6.26274 11.9798 6.3846 11.9291C6.50645 11.8783 6.61706 11.8039 6.71002 11.7102C6.80375 11.6172 6.87814 11.5066 6.92891 11.3848C6.97968 11.2629 7.00582 11.1322 7.00582 11.0002C7.00582 10.8682 6.97968 10.7375 6.92891 10.6156C6.87814 10.4937 6.80375 10.3831 6.71002 10.2902L3.41002 7.00019H11C11.2652 7.00019 11.5196 6.89483 11.7071 6.70729C11.8947 6.51976 12 6.2654 12 6.00019C12 5.73497 11.8947 5.48062 11.7071 5.29308C11.5196 5.10554 11.2652 5.00019 11 5.00019Z" fill="black"/>
                </svg>
            </button>
        </div>

        {{-- Dots Indicator --}}
        <div id="dots-{{ $post->id }}" class="flex justify-center mt-1 gap-1" data-post-id="{{ $post->id }}">
            @foreach ($post->images as $key => $image)
                <div class="dot w-1 h-1 xl:w-2 xl:h-2 rounded-full {{ $key === 0 ? 'bg-gray-600' : 'bg-gray-400' }}" data-dot-index="{{ $key }}"></div>
            @endforeach
        </div>
        @endif
    @endif


    {{-- like,comment,book.share --}}
    <div class="flex justify-around items-start">
        {{-- like --}}
        <div>
            <form x-data="{ likedPost: {{ Auth::check() && $post->likedByUsers->contains(Auth::user()->id) ? 'true' : 'false' }},
                            likeCountPost: {{ $post->likedByUsers()->count() }},
                            userWhoLikesPost: {{ $post->likedByUsers()->orderBy('post_like_user.created_at', 'desc')->get() }}
                        }">
                @csrf
                <div x-data="{ showWhoLikesPost : false }" class="flex items-center gap-2">
                    <button x-data="{ loadingPost: false }"
                            type="button"
                            :disabled="loadingPost"
                            x-on:click="
                                if (!{{ Auth::check() ? 'true' : 'false' }}) {
                                    window.location.href = '{{ route('login') }}';
                                    return;
                                }
                                if (loadingPost) return;
                                loadingPost = true;
                                fetch(likedPost ? '{{ route('post.unlike', $post) }}' : '{{ route('post.like', $post) }}', {
                                    method: likedPost ? 'DELETE' : 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        likedPost = !likedPost;
                                        likeCountPost = data.likeCount; // Ambil jumlah like terbaru dari server
                                        userWhoLikesPost = data.userWhoLikesPost;
                                        $data.liked = likedPost; // Paksa Alpine.js update tampilan
                                        $data.likeCount = likeCountPost;
                                    }
                                    loadingPost = false;
                                })
                                .catch(error => {
                                    console.error(error);
                                    loadingPost = false;
                                });
                            ">
                        <svg class="w-5 h-5 sm:w-4 sm:h-4 lg:w-6 lg:h-6" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path :class="likedPost ? 'fill-red-600' : ''" d="M19.16 2.61C18.0983 1.54801 16.6907 0.902327 15.1932 0.790382C13.6957 0.678437 12.2078 1.10766 11 2C9.72766 1.05364 8.14399 0.624512 6.56792 0.799038C4.99185 0.973564 3.54044 1.73878 2.50597 2.94059C1.47151 4.14239 0.930823 5.69152 0.992802 7.27601C1.05478 8.86051 1.71482 10.3627 2.84 11.48L10.29 18.93C10.383 19.0237 10.4936 19.0981 10.6154 19.1489C10.7373 19.1997 10.868 19.2258 11 19.2258C11.132 19.2258 11.2627 19.1997 11.3846 19.1489C11.5064 19.0981 11.617 19.0237 11.71 18.93L19.16 11.48C19.7427 10.8977 20.2049 10.2063 20.5202 9.44537C20.8356 8.68439 20.9979 7.86873 20.9979 7.045C20.9979 6.22127 20.8356 5.40561 20.5202 4.64463C20.2049 3.88366 19.7427 3.19228 19.16 2.61ZM17.75 10.07L11 16.81L4.25 10.07C3.65518 9.4727 3.24998 8.71305 3.08523 7.88634C2.92049 7.05963 3.00353 6.20268 3.32395 5.42299C3.64437 4.6433 4.1879 3.97559 4.88635 3.50362C5.58479 3.03165 6.40706 2.77644 7.25 2.77C8.37611 2.77276 9.4551 3.22234 10.25 4.02C10.343 4.11373 10.4536 4.18812 10.5754 4.23889C10.6973 4.28966 10.828 4.3158 10.96 4.3158C11.092 4.3158 11.2227 4.28966 11.3446 4.23889C11.4664 4.18812 11.577 4.11373 11.67 4.02C12.4883 3.31088 13.5455 2.93915 14.6275 2.98003C15.7096 3.0209 16.7357 3.47135 17.4982 4.24019C18.2607 5.00903 18.7026 6.03884 18.7345 7.12119C18.7664 8.20354 18.3859 9.25759 17.67 10.07H17.75Z" fill="#FDF9F9"/>
                        </svg>
                    </button>
                    <p @click="showWhoLikesPost = true" class="text-[10px] hover:cursor-pointer hover:underline hover:text-blue-600 sm:text-xs md:text-sm lg:text-base" x-text="likeCountPost"></p>

                    {{-- menu untuk menampilkan siapa saja user yang like postingan ini --}}
                    <div x-show="showWhoLikesPost"
                        x-transition:enter="transition ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-90"
                        class="fixed w-full flex justify-center items-center h-full top-0 left-0 right-0 z-50 bg-gray-900/70"
                        style="display: none;">
                        <div class="w-[65%] sm:w-[60%] lg:w-[35%] xl:w-[25%] h-[55%] sm:h-[50%] md:h-[60%] dark:bg-gray-700 rounded-lg p-2 sm:p-4 xl:p-6 relative">
                            {{-- tombol untuk menutup menu menampilkan semua followers --}}
                            <button type="button" @click="showWhoLikesPost = false" id="hide-followers" class="absolute top-1 right-1">
                                <svg class="w-5 h-5 bg-white rounded-full p-1" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.40994 8.00019L15.7099 1.71019C15.8982 1.52188 16.004 1.26649 16.004 1.00019C16.004 0.733884 15.8982 0.478489 15.7099 0.290185C15.5216 0.101882 15.2662 -0.00390625 14.9999 -0.00390625C14.7336 -0.00390625 14.4782 0.101882 14.2899 0.290185L7.99994 6.59019L1.70994 0.290185C1.52164 0.101882 1.26624 -0.00390601 0.999939 -0.00390601C0.733637 -0.00390601 0.478243 0.101882 0.289939 0.290185C0.101635 0.478489 -0.00415253 0.733884 -0.00415254 1.00019C-0.00415254 1.26649 0.101635 1.52188 0.289939 1.71019L6.58994 8.00019L0.289939 14.2902C0.196211 14.3831 0.121816 14.4937 0.0710478 14.6156C0.0202791 14.7375 -0.00585938 14.8682 -0.00585938 15.0002C-0.00585938 15.1322 0.0202791 15.2629 0.0710478 15.3848C0.121816 15.5066 0.196211 15.6172 0.289939 15.7102C0.382902 15.8039 0.493503 15.8783 0.615362 15.9291C0.737221 15.9798 0.867927 16.006 0.999939 16.006C1.13195 16.006 1.26266 15.9798 1.38452 15.9291C1.50638 15.8783 1.61698 15.8039 1.70994 15.7102L7.99994 9.41018L14.2899 15.7102C14.3829 15.8039 14.4935 15.8783 14.6154 15.9291C14.7372 15.9798 14.8679 16.006 14.9999 16.006C15.132 16.006 15.2627 15.9798 15.3845 15.9291C15.5064 15.8783 15.617 15.8039 15.7099 15.7102C15.8037 15.6172 15.8781 15.5066 15.9288 15.3848C15.9796 15.2629 16.0057 15.1322 16.0057 15.0002C16.0057 14.8682 15.9796 14.7375 15.9288 14.6156C15.8781 14.4937 15.8037 14.3831 15.7099 14.2902L9.40994 8.00019Z" fill="black"/>
                                </svg>
                            </button>

                            {{-- list user yang like postingan ini --}}
                            <p class="font-bold text-sm sm:text-base md:text-lg text-center">Total Likes This Post <span x-text="likeCountPost"></span></p>
                            <div class="w-full h-0.5 my-4 bg-gray-200"></div>

                            {{-- menampilkan user yang like --}}
                            <div class="space-y-5 h-[85%] overflow-y-scroll scrollbar-thumb-gray-400 scrollbar-track-transparent scrollbar-thin">

                                <template x-if="userWhoLikesPost.length === 0">
                                    <p class="text-center text-sm sm:text-base md:text-lg">No Likes yet</p>
                                </template>
                                <template x-for="user in userWhoLikesPost" :key="user.id">
                                    <div class="flex items-center justify-between mr-2 sm:mr-4">
                                        <div class="flex items-center gap-2">
                                            <img :src="user.image ? user.image : '{{ asset('images-profil/gambar-foto-profil-7.jpg') }}'"
                                                class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 rounded-full object-cover" alt="">
                                            <a :href="'/profile/' + user.id" class="text-sm sm:text-base hover:underline hover:text-blue-600 duration-300 ease-in-out" x-text="user.username"></a>
                                        </div>
                                        <div>
                                            <p class="text-[8px] sm:text-[10px]" x-text="formatDatePost(user.pivot.created_at)"></p>
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        {{-- comment --}}
        <a class="flex items-center gap-2" href="{{ route('post.show', $post) }}">
            <svg class="w-5 h-5 sm:w-4 sm:h-4 lg:w-6 lg:h-6" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 0H3C2.20435 0 1.44129 0.316071 0.87868 0.87868C0.316071 1.44129 0 2.20435 0 3V13C0 13.7956 0.316071 14.5587 0.87868 15.1213C1.44129 15.6839 2.20435 16 3 16H14.59L18.29 19.71C18.3834 19.8027 18.4943 19.876 18.6161 19.9258C18.7379 19.9755 18.8684 20.0008 19 20C19.1312 20.0034 19.2613 19.976 19.38 19.92C19.5626 19.845 19.7189 19.7176 19.8293 19.5539C19.9396 19.3901 19.999 19.1974 20 19V3C20 2.20435 19.6839 1.44129 19.1213 0.87868C18.5587 0.316071 17.7956 0 17 0ZM18 16.59L15.71 14.29C15.6166 14.1973 15.5057 14.124 15.3839 14.0742C15.2621 14.0245 15.1316 13.9992 15 14H3C2.73478 14 2.48043 13.8946 2.29289 13.7071C2.10536 13.5196 2 13.2652 2 13V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2H17C17.2652 2 17.5196 2.10536 17.7071 2.29289C17.8946 2.48043 18 2.73478 18 3V16.59Z" fill="#FDF7F7"/>
            </svg>
            <p class="text-[10px] sm:text-xs md:text-sm lg:text-base">{{ $post->comments->count() }}</p>
        </a>

        {{-- bookmarks --}}
        <div>
            <form action="{{ Auth::check() && $post->bookmarksByUsers->contains(Auth::user()->id) ? route('post.unbookmark', $post) : route('post.bookmark', $post) }}" method="POST">
            @method(Auth::check() && $post->bookmarksByUsers->contains(Auth::user()->id) ? 'DELETE' : 'POST')
            @csrf
                <div class="flex items-center gap-2">
                    <button type="submit">
                        <svg class="w-5 h-5 sm:w-4 sm:h-4 lg:w-6 lg:h-6" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="{{ Auth::check() && $post->bookmarksByUsers->contains(Auth::user()->id) ? 'fill-yellow-600' : '' }}" d="M27.04 12.7262L15.4763 1.14874C15.3478 1.02131 15.1954 0.920483 15.0279 0.852057C14.8604 0.783631 14.681 0.748946 14.5 0.749992H2.12502C1.76035 0.749992 1.41061 0.894858 1.15275 1.15272C0.894889 1.41058 0.750023 1.76032 0.750023 2.12499V14.5C0.748977 14.681 0.783661 14.8603 0.852088 15.0279C0.920514 15.1954 1.02134 15.3478 1.14877 15.4762L12.7263 27.04C13.4997 27.8125 14.5481 28.2464 15.6413 28.2464C16.7344 28.2464 17.7828 27.8125 18.5563 27.04L27.04 18.625C27.8125 17.8516 28.2464 16.8031 28.2464 15.71C28.2464 14.6169 27.8125 13.5684 27.04 12.795V12.7262ZM25.1013 16.6037L16.6038 25.0875C16.3461 25.3436 15.9977 25.4873 15.6344 25.4873C15.2711 25.4873 14.9226 25.3436 14.665 25.0875L3.50002 13.9362V3.49999H13.9363L25.1013 14.665C25.2287 14.7935 25.3295 14.9458 25.398 15.1134C25.4664 15.2809 25.5011 15.4603 25.5 15.6412C25.4985 16.002 25.3553 16.3476 25.1013 16.6037Z" fill="#FFFDFD"/>
                        </svg>
                    </button>
                    <p class="text-[10px] sm:text-xs md:text-sm lg:text-base">{{ $post->bookmarksByUsers->count() }}</p>
                </div>

            </form>
        </div>

        {{-- share --}}
        <svg class="w-5 h-5 sm:w-4 sm:h-4 lg:w-6 lg:h-6" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.61 14C15.5556 13.8785 15.4813 13.7669 15.39 13.67L10.76 9C10.5687 8.83617 10.3226 8.75057 10.071 8.76029C9.81928 8.77001 9.58054 8.87434 9.40244 9.05244C9.22435 9.23053 9.12001 9.46927 9.11029 9.72095C9.10057 9.97262 9.18618 10.2187 9.35 10.41L12.27 13.33H5.27C4.47436 13.33 3.71129 13.0139 3.14868 12.4513C2.58607 11.8887 2.27 11.1256 2.27 10.33V1C2.27 0.734784 2.16465 0.48043 1.97711 0.292893C1.78957 0.105357 1.53522 0 1.27 0C1.00479 0 0.750434 0.105357 0.562898 0.292893C0.375361 0.48043 0.270004 0.734784 0.270004 1V10.37C0.270004 11.6961 0.796788 12.9679 1.73447 13.9055C2.67215 14.8432 3.94392 15.37 5.27 15.37H12.27L9.35 18.29C9.25628 18.383 9.18188 18.4936 9.13111 18.6154C9.08034 18.7373 9.05421 18.868 9.05421 19C9.05421 19.132 9.08034 19.2627 9.13111 19.3846C9.18188 19.5064 9.25628 19.617 9.35 19.71C9.44344 19.8027 9.55426 19.876 9.6761 19.9258C9.79794 19.9755 9.9284 20.0008 10.06 20C10.3223 19.9989 10.5737 19.8947 10.76 19.71L15.39 15.08C15.4846 14.9858 15.5594 14.8736 15.61 14.75C15.7073 14.5095 15.7073 14.2405 15.61 14Z" fill="#FFFBFB"/>
        </svg>
    </div>

</div>

<script>
    function formatDatePost(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    document.querySelectorAll('.carousel').forEach(carousel => {
    const postId = carousel.getAttribute('data-post-id');
    const carouselItems = carousel.querySelectorAll('.carousel-item');
    const prevArrow = carousel.querySelector('.prevArrow');
    const nextArrow = carousel.querySelector('.nextArrow');
    const dots = document.querySelectorAll(`#dots-${postId} .dot`);

    let currentIndex = 0;

    function updateDots(activeIndex) {
        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-gray-600', index === activeIndex);
            dot.classList.toggle('bg-gray-400', index !== activeIndex);
        });
    }

    function goToSlide(index) {
        carouselItems.forEach((item, i) => {
            item.classList.toggle('hidden', i !== index);
            item.classList.toggle('active', i === index);
        });
        currentIndex = index;
        updateDots(currentIndex);
    }

    prevArrow.addEventListener('click', () => {
        const newIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
        goToSlide(newIndex);
    });

    nextArrow.addEventListener('click', () => {
        const newIndex = (currentIndex + 1) % carouselItems.length;
        goToSlide(newIndex);
    });

    // Initialize the dots for the first slide
    updateDots(currentIndex);
});

 // membuat hashtag pada post body berwarna biru
 document.addEventListener("DOMContentLoaded", function() {
        const postContent = document.querySelectorAll('.post-content');

        postContent.forEach(content => {
        const updatedContent = content.innerHTML.replace(/(#\w+)/g, function(match) {
            return `<a href="/post/hashtag/${encodeURIComponent(match)}" class="text-blue-600 hover:underline hover:cursor-pointer">${match}</a>`;
        });
            content.innerHTML = updatedContent;
        });
});

</script>
