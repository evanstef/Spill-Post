<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    {{-- title --}}
    <x-slot name="title">
        {{ __('Following') }}
    </x-slot>
{{-- akhir title --}}
    {{-- Postingan Content --}}
    <x-layout-content class="w-[75%] sm:w-[60%] rounded-lg ml-4 sm:ml-0">
    {{-- loading component --}}
    <div id="loading-indicator-following" class="flex items-center justify-center flex-col absolute w-full top-0 left-0 h-full z-50" style="display: none">
        <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-blue-600"></div>
        <div class="text-center mt-3 xl:text-xl">Loading...</div>
    </div>
    @if($usersFollowing->count() === 0)
    <div class="p-3 sm:p-4 xl:p-6">
        <h1 class="text-sm sm:text-lg md:text-xl xl:text-2xl mb-4">Here Suggestion Following For You</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach ($allUsers as $user)
                @if ($user->id !== Auth::user()->id)
                    <x-suggest-following-card :user="$user" />
                @endif
            @endforeach
        </div>
        <div class="mt-5">
            {{ $allUsers->links('pagination::simple-tailwind') }}
        </div>
    </div>

    @else
        @if (Auth::check() && $posts->count() === 0)
            <div class="p-3 sm:p-4 xl:p-6">
                <h1 class="text-center text-sm sm:text-lg md:text-xl xl:text-2xl">You Following Users didn't post anything</h1>
            </div>
        @else
            {{-- untuk memilih sort by --}}
            <div class="px-3 sm:px-4 xl:px-6 mt-4">
                <form action="{{ route('post.following') }}" class="flex justify-end" method="GET">
                    <div class="flex items-center gap-2">
                    <label for="sortByFollowing">
                            <svg class="w-4 h-4 sm:w-6 sm:h-6 md:w-7 md:h-7 xl:w-8 xl:h-8" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="fill-white" d="M11 10H1C0.734784 10 0.48043 10.1054 0.292893 10.2929C0.105357 10.4804 0 10.7348 0 11C0 11.2652 0.105357 11.5196 0.292893 11.7071C0.48043 11.8946 0.734784 12 1 12H11C11.2652 12 11.5196 11.8946 11.7071 11.7071C11.8946 11.5196 12 11.2652 12 11C12 10.7348 11.8946 10.4804 11.7071 10.2929C11.5196 10.1054 11.2652 10 11 10ZM1 2H19C19.2652 2 19.5196 1.89464 19.7071 1.70711C19.8946 1.51957 20 1.26522 20 1C20 0.734784 19.8946 0.48043 19.7071 0.292893C19.5196 0.105357 19.2652 0 19 0H1C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1C0 1.26522 0.105357 1.51957 0.292893 1.70711C0.48043 1.89464 0.734784 2 1 2ZM19 5H1C0.734784 5 0.48043 5.10536 0.292893 5.29289C0.105357 5.48043 0 5.73478 0 6C0 6.26522 0.105357 6.51957 0.292893 6.70711C0.48043 6.89464 0.734784 7 1 7H19C19.2652 7 19.5196 6.89464 19.7071 6.70711C19.8946 6.51957 20 6.26522 20 6C20 5.73478 19.8946 5.48043 19.7071 5.29289C19.5196 5.10536 19.2652 5 19 5Z" fill="black"/>
                            </svg>
                        </label>
                        <select name="sort_page_following" id="sortByFollowing" class="bg-transparent rounded hover:cursor-pointer text-[10px] sm:text-xs md:text-sm xl:text-base py-1 sm:py-2" onchange="this.form.submit()">
                                <option class="bg-gray-800" {{ request('sort_page_following') === 'newest' ? 'selected' : '' }} value="newest">Newest</option>
                                <option class="bg-gray-800" {{ request('sort_page_following') === 'oldest' ? 'selected' : '' }} value="oldest">Oldest</option>
                                <option class="bg-gray-800" {{ request('sort_page_following') === 'mostLiked' ? 'selected' : '' }} value="mostLiked">Most Liked</option>
                                <option class="bg-gray-800" {{ request('sort_page_following') === 'mostComment' ? 'selected' : '' }} value="mostComment">Most Comment</option>
                        </select>
                    </div>
                </form>
            </div>
            {{-- Postingan Orang Orang yang diikuti oleh user yang saat ini login --}}
            @foreach ($posts as $post)
                <div class="p-3 sm:p-4 xl:p-6 space-y-4">
                    <x-post-template :post="$post" :userLikesPost="$post->likedByUsers()->orderBy('post_like_user.created_at', 'desc')->get()" />
                </div>
                @if (!$loop->last)
                    <div class="bg-white h-[1px] w-full"></div>
                @endif
            @endforeach
            @if ($posts->hasPages())
               <div class="p-3 sm:p-4">{{ $posts->links() }}</div>
            @endif

        @endif
    @endif

    </x-layout-content>

    {{-- Suggesstion To Follow --}}
    <x-layout-content class="w-[25%] sm:w-[20%] p-3 xl:p-4 rounded-lg mr-4 sm:mr-0">
        {{-- User user yang baru daftar di web ini --}}
        <div class="space-y-4">
            <h1 class="text-[10px] sm:text-xs lg:text-base">Who To Follow</h1>
            {{-- user user yang baru daftar di web ini --}}
            @foreach ($usersLimit as $user)
                @if (Auth::check())
                    @if ($user->id !== Auth::user()->id && !Auth::user()->isFollowing($user->id))
                        <x-suggest-follow :user="$user" />
                    @endif
                @else
                    <x-suggest-follow :user="$user" />
                @endif
            @endforeach
        </div>
    </x-layout-content>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadingIndicatorFollowing = document.getElementById('loading-indicator-following');

        // Tampilkan loader pada saat halaman mulai dimuat
        loadingIndicatorFollowing.style.display = 'flex';

        // Sembunyikan loader setelah data selesai dimuat
        window.onload = function () {
            loadingIndicatorFollowing.style.display = 'none';
        };
    });
</script>


