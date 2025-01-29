<x-app-layout>
    {{-- title --}}
    <x-slot name="title">
        {{ __('Profile') }}
    </x-slot>
    {{-- akhir title --}}
    <x-layout-content class="w-full sm:w-[80%] rounded-lg p-4 xl:p-6 mx-4 sm:mx-0">
        <div class="flex justify-between gap-5 sm:gap-10">
            {{-- foto user --}}
            <div class="w-[30%]">
                <img class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 xl:w-40 xl:h-40 rounded-full object-cover" src="{{ $user->image ? $user->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
                <div class="mt-1 sm:hidden w-full">
                    <p class="font-bold text-sm">{{ $user->username }}</p>
                    <p class="text-xs">{{ $user->description }}</p>
                </div>
            </div>

            {{-- user, follow, follower, berapa postingan --}}
            <div class="w-[70%]">
                {{-- informasi follow follwers dan jumlah postingan --}}
                <div class="flex justify-between items-center mb-5">

                    <!-- Follower -->
                    <div x-data="{ showFollowers: false }" class="text-center">
                        <p class="font-bold text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl">Followers</p>
                        <button @click="showFollowers = true" id="show-followers" class="text-xs sm:text-sm lg:text-base xl:text-lg hover:underline hover:text-blue-600">{{ $user->followers->count() }}</button>

                        {{-- menu untuk menampilkan semua followers --}}
                        <div x-show="showFollowers"
                             x-transition:enter="transition ease-in-out duration-300"
                             x-transition:enter-start="opacity-0 scale-90"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in-out duration-200"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-90"
                             class="fixed top-0 left-0 w-full h-full flex justify-center items-center z-50" style="display: none;">
                            <div class="w-[70%] h-[55%] sm:h-[50%] md:w-[60%] md:h-[60%] lg:w-1/2 xl:w-[40%] dark:bg-gray-700 rounded-lg p-2 sm:p-4 xl:p-6 relative">
                                    {{-- tombol untuk menutup menu menampilkan semua followers --}}
                                    <button @click="showFollowers = false" id="hide-followers" class="absolute top-2 right-2 lg:right-3">
                                        <svg class="w-5 h-5 xl:w-6 xl:h-6 bg-white rounded-full p-1" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.40994 8.00019L15.7099 1.71019C15.8982 1.52188 16.004 1.26649 16.004 1.00019C16.004 0.733884 15.8982 0.478489 15.7099 0.290185C15.5216 0.101882 15.2662 -0.00390625 14.9999 -0.00390625C14.7336 -0.00390625 14.4782 0.101882 14.2899 0.290185L7.99994 6.59019L1.70994 0.290185C1.52164 0.101882 1.26624 -0.00390601 0.999939 -0.00390601C0.733637 -0.00390601 0.478243 0.101882 0.289939 0.290185C0.101635 0.478489 -0.00415253 0.733884 -0.00415254 1.00019C-0.00415254 1.26649 0.101635 1.52188 0.289939 1.71019L6.58994 8.00019L0.289939 14.2902C0.196211 14.3831 0.121816 14.4937 0.0710478 14.6156C0.0202791 14.7375 -0.00585938 14.8682 -0.00585938 15.0002C-0.00585938 15.1322 0.0202791 15.2629 0.0710478 15.3848C0.121816 15.5066 0.196211 15.6172 0.289939 15.7102C0.382902 15.8039 0.493503 15.8783 0.615362 15.9291C0.737221 15.9798 0.867927 16.006 0.999939 16.006C1.13195 16.006 1.26266 15.9798 1.38452 15.9291C1.50638 15.8783 1.61698 15.8039 1.70994 15.7102L7.99994 9.41018L14.2899 15.7102C14.3829 15.8039 14.4935 15.8783 14.6154 15.9291C14.7372 15.9798 14.8679 16.006 14.9999 16.006C15.132 16.006 15.2627 15.9798 15.3845 15.9291C15.5064 15.8783 15.617 15.8039 15.7099 15.7102C15.8037 15.6172 15.8781 15.5066 15.9288 15.3848C15.9796 15.2629 16.0057 15.1322 16.0057 15.0002C16.0057 14.8682 15.9796 14.7375 15.9288 14.6156C15.8781 14.4937 15.8037 14.3831 15.7099 14.2902L9.40994 8.00019Z" fill="black"/>
                                        </svg>
                                    </button>
                                    <p class="font-bold text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl">Follower</p>

                                    {{-- garis bawah --}}
                                    <div class="w-full h-[1px] bg-gray-100 my-2"></div>

                                    {{-- untuk menampilkan nama nama followers --}}
                                    <div class="space-y-[6px] h-[90%] {{ $followers->count() >= 8 ? 'overflow-y-scroll' : '' }} scrollbar-thumb-gray-400 scrollbar-track-transparent scrollbar-thin" x-data="{ showFollowers: false }">
                                        {{-- pengecekan bila followers belum ada --}}
                                        @if($followers->count() === 0)
                                            <p class="text-xs sm:text-sm lg:text-base xl:text-lg">{{ Auth::check() && $user->username === Auth::user()->username ? 'You don\'t have any followers' : $user->username . ' doesn\'t have any followers' }}</p>
                                        @else
                                            @foreach ($followers as $follower)
                                                <div class="flex justify-between items-center {{ $followers->count() >= 8 ? 'mr-2 lg:mr-4' : '' }}">
                                                    <div class="flex gap-2 xl:gap-4 items-center">
                                                        <img class="w-6 h-6 md:w-8 md:h-8 rounded-full object-cover" src="{{ $follower->image ? $follower->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
                                                        <a href="{{ route('profile.show', $follower->username) }}" class="hover:underline hover:text-blue-600 text-xs sm:text-sm md:text-base">{{ $follower->username }}</a>
                                                    </div>

                                                    {{-- pengecekan bila user yang saat ini login belum follow user yang berada di daftar followers user saat ini --}}
                                                    @if (Auth::check() && Auth::user()->isFollowing($follower->id))
                                                        <form action="{{ route('unfollows', $follower) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 duration-300 ease-in-out text-white px-2 md:px-3 py-1 rounded sm:rounded-lg text-sm md:text-lg xl:text-xl">Unfollow</button>
                                                        </form>

                                                    @else
                                                        @if (Auth::check() && $follower->id !== Auth::user()->id)
                                                        <form action="{{ route('follows', $follower) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 duration-300 ease-in-out text-white px-2 md:px-3 py-1 rounded sm:rounded-lg text-sm md:text-lg xl:text-xl">{{ Auth::check() && Auth::user()->isFollowedBy($follower->id) && !Auth::user()->isFollowing($follower->id) ? 'Follow Back' : 'Follow' }}</button>
                                                        </form>
                                                        @elseif (Auth::guest())
                                                        <form action="{{ route('follows', $follower) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 duration-300 ease-in-out text-white px-2 md:px-3 py-1 rounded text-sm sm:rounded-lg md:text-lg xl:text-xl">Follow</button>
                                                        </form>
                                                        @endif

                                                    @endif
                                                </div>
                                                @if (!$loop->last)
                                                    <div class="w-full h-[1px] bg-gray-100 mt-1"></div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>

                            </div>
                        </div>

                    </div>

                    <!-- Following -->
                    <div x-data="{ showFollowing: false }" class="text-center">
                        <p class="font-bold text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl">Following</p>
                        <button @click="showFollowing = true" class="text-xs sm:text-sm lg:text-base xl:text-lg hover:underline hover:text-blue-600">{{ $user->following->count() }}</button>

                        {{-- menu untuk menampilkan semua followers --}}
                        <div x-show="showFollowing"
                        x-transition:enter="transition ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in-out duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-90"
                        class="fixed top-0 left-0 w-full h-full flex justify-center items-center z-50" style="display: none;">
                                <div class="w-[70%] h-[55%] sm:h-[50%] md:w-[60%] md:h-[60%] lg:w-1/2 xl:w-[40%] dark:bg-gray-700 rounded-lg p-2 sm:p-4 lg:p-6 relative">
                                        {{-- tombol untuk menutup menu menampilkan semua followers --}}
                                        <button @click="showFollowing = false" id="hide-followers" class="absolute top-2 right-2 xl:right-3">
                                            <svg class="w-5 h-5 xl:w-6 xl:h-6 bg-white rounded-full p-1" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.40994 8.00019L15.7099 1.71019C15.8982 1.52188 16.004 1.26649 16.004 1.00019C16.004 0.733884 15.8982 0.478489 15.7099 0.290185C15.5216 0.101882 15.2662 -0.00390625 14.9999 -0.00390625C14.7336 -0.00390625 14.4782 0.101882 14.2899 0.290185L7.99994 6.59019L1.70994 0.290185C1.52164 0.101882 1.26624 -0.00390601 0.999939 -0.00390601C0.733637 -0.00390601 0.478243 0.101882 0.289939 0.290185C0.101635 0.478489 -0.00415253 0.733884 -0.00415254 1.00019C-0.00415254 1.26649 0.101635 1.52188 0.289939 1.71019L6.58994 8.00019L0.289939 14.2902C0.196211 14.3831 0.121816 14.4937 0.0710478 14.6156C0.0202791 14.7375 -0.00585938 14.8682 -0.00585938 15.0002C-0.00585938 15.1322 0.0202791 15.2629 0.0710478 15.3848C0.121816 15.5066 0.196211 15.6172 0.289939 15.7102C0.382902 15.8039 0.493503 15.8783 0.615362 15.9291C0.737221 15.9798 0.867927 16.006 0.999939 16.006C1.13195 16.006 1.26266 15.9798 1.38452 15.9291C1.50638 15.8783 1.61698 15.8039 1.70994 15.7102L7.99994 9.41018L14.2899 15.7102C14.3829 15.8039 14.4935 15.8783 14.6154 15.9291C14.7372 15.9798 14.8679 16.006 14.9999 16.006C15.132 16.006 15.2627 15.9798 15.3845 15.9291C15.5064 15.8783 15.617 15.8039 15.7099 15.7102C15.8037 15.6172 15.8781 15.5066 15.9288 15.3848C15.9796 15.2629 16.0057 15.1322 16.0057 15.0002C16.0057 14.8682 15.9796 14.7375 15.9288 14.6156C15.8781 14.4937 15.8037 14.3831 15.7099 14.2902L9.40994 8.00019Z" fill="black"/>
                                            </svg>
                                        </button>
                                        <p class="font-bold text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl">Following</p>

                                        {{-- garis bawah --}}
                                        <div class="w-full h-[1px] bg-gray-100 my-2"></div>

                                        {{-- untuk menampilkan nama nama followers --}}
                                        <div class="space-y-2 h-[90%] {{ $followings->count() >= 8 ? 'overflow-y-scroll' : '' }} scrollbar-thumb-gray-400 scrollbar-track-transparent scrollbar-thin">
                                            {{-- pengecekan bila followers belum ada --}}
                                            @if($followings->count() === 0)
                                                <p class="text-xs sm:text-sm lg:text-base xl:text-lg">{{Auth::check() && $user->username === Auth::user()->username ? 'You don\'t have any following' : $user->username . ' doesn\'t have any following' }}</p>
                                            @else
                                                @foreach ($followings as $following)
                                                    <div class="flex justify-between items-center {{ $followings->count() >= 8 ? 'mr-2 lg:mr-4' : '' }}">
                                                        <div class="flex gap-2 xl:gap-4 items-center">
                                                            <img class="w-6 h-6 md::w-8 md::h-8 rounded-full object-cover" src="{{ $following->image ? $following->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
                                                            <a href="{{ route('profile.show', $following->username) }}" class="text-xs sm:text-sm md:text-base hover:underline hover:text-blue-600">{{ $following->username }}</a>
                                                        </div>

                                                        {{-- pengecekan bila user yang saat ini login belum follow user yang berada di daftar followers user saat ini --}}
                                                        @if (Auth::check() && Auth::user()->isFollowing($following->id))
                                                            <form action="{{ route('unfollows', $following) }}" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="bg-gray-500 hover:bg-gray-600 duration-300 ease-in-out text-white px-2 md:px-3 py-1 rounded sm:rounded-lg text-sm md:text-lg xl:text-xl">Unfollow</button>
                                                            </form>
                                                        @else
                                                            @if (Auth::check() && $following->id !== Auth::user()->id)
                                                            <form action="{{ route('follows', $following) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 duration-300 ease-in-out text-white px-2 md:px-3 py-1 rounded sm:rounded-lg text-sm md:text-lg xl:text-xl">{{ Auth::check() && Auth::user()->isFollowedBy($following->id) && !Auth::user()->isFollowing($following->id) ? 'Follow Back' : 'Follow' }}</button>
                                                            </form>
                                                            {{-- pengecekan bila user tidak login --}}
                                                            @elseif (Auth::guest())
                                                            <form action="{{ route('follows', $following) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 duration-300 ease-in-out text-white
                                                                px-2 md:px-3 py-1 rounded sm:rounded-lg text-sm md:text-lg xl:text-xl">Follow</button>
                                                            </form>
                                                            @endif


                                                        @endif
                                                    </div>
                                                    @if (!$loop->last)
                                                        <div class="w-full h-[1px] bg-gray-100 mt-1"></div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                </div>
                        </div>
                    </div>

                    <!-- SpillPost -->
                    <div class="text-center">
                        <p class="font-bold text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl">SpillPost</p>
                        <button class="text-xs sm:text-sm lg:text-base xl:text-lg hover:cursor-default">{{ $user->posts->count() }}</button>
                    </div>
                </div>

                {{-- di cek jika user login tampilkan menu edit profile --}}
                @if(Auth::check() && Auth::user()->id === $user->id)
                <div class="flex justify-center">
                    <a class="bg-gray-600 hover:bg-gray-700 duration-300 ease-in-out  text-white px-3 py-1 rounded-lg text-base md:text-lg xl:text-xl" href="{{ route('profile.edit') }}">Edit Profile</a>
                </div>

                @else
                <div class="flex gap-5 sm:gap-10 justify-center">
                    <form action="{{ route('follows', $user) }}" method="POST">
                        @csrf
                        @if (Auth::check() && Auth::user()->isFollowing($user->id))
                            <p class="bg-blue-600 text-white px-3 py-1 rounded-lg md:text-lg xl:text-xl cursor-default">Followed</p>
                        @else
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 duration-300 ease-in-out text-white px-3 py-1 rounded-lg md:text-lg xl:text-xl">{{ Auth::check() && Auth::user()->isFollowedBy($user->id) && !Auth::user()->isFollowing($user->id) ? 'Follow Back' : 'Follow' }}</button>
                        @endif
                    </form>
                    @if (Auth::check() && Auth::user()->isFollowing($user->id))
                        <form action="{{ route('unfollows', $user) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="bg-gray-600 hover:bg-gray-700 duration-300 ease-in-out text-white px-3 py-1 rounded-lg md:text-lg xl:text-xl">Unfollow</button>
                        </form>
                    @endif
                </div>
                @endif

                {{-- deskripsi user --}}
                <div class="sm:mt-5 xl:mt-10 hidden sm:block">
                    <p class="sm:text-sm md:text-base lg:text-xl">{{ $user->username }}</p>
                    <p class="sm:text-xs md:text-sm sm:w-3/4 lg:w-8/12">{{ $user->description }}</p>
                </div>
            </div>
        </div>

        {{-- postingan user dan bookmarks --}}
        <div class="mt-5">
            <div class="flex justify-center gap-5 sm:gap-10">
                <x-nav-link class="rounded-lg" href="{{ route('profile.show', $user) }}" :active="request()->is('profile/' . $user->username)">SpillPost</x-nav-link>
                @auth
                    @if ($user->id === Auth::user()->id)
                        <x-nav-link class="rounded-lg" href="{{ route('profile.bookmarks', $user) }}" :active="request()->is('profile/' . Auth::user()->username . '/bookmarks')" class="rounded-lg">Bookmarks</x-nav-link>
                    @endif
                @endauth
            </div>
            <div class="bg-white h-[1px] w-full"></div>

            <div class="space-y-6 mt-10">
                @if (request()->is('profile/' . $user->username))
                    @if ($user->posts->count() === 0)
                        <p class="text-center text-lg">No SpillPost yet</p>
                    @else
                            @foreach ($posts as $post)
                                <x-post-template :post="$post" :userLikesPost="$post->likedByUsers()->orderBy('post_like_user.created_at', 'desc')->get()" />
                                @if (!$loop->last)
                                <div class="bg-white h-[1px] w-full"></div>
                                @endif
                            @endforeach
                            <div>{{ $posts->links() }}</div>
                    @endif

                @elseif (request()->is('profile/' . Auth::user()->username . '/bookmarks'))
                    @if ($user->bookmarksByUsers->count() === 0)
                        <p class="text-center text-lg">No Bookmarks yet</p>
                    @else
                        @foreach ($bookmarks as $bookmark)
                            <x-bookmark-template :bookmark="$bookmark" :userLikesPost="$bookmark->post->likedByUsers()->orderBy('post_like_user.created_at', 'desc')->get()" />
                            @if (!$loop->last)
                                <div class="bg-white h-[1px] w-full"></div>
                            @endif
                        @endforeach
                        <div>{{ $bookmarks->links() }}</div>
                    @endif
                @endif


            </div>
        </div>
    </x-layout-content>
</x-app-layout>



