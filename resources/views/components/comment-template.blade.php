@props(['comment' => null ])

<div>
    <div class="flex items-center justify-between">
        {{-- foto user dan username --}}
        <div class="flex items-center gap-2">
            <img class="w-6 h-6 lg:w-8 lg:h-8 object-cover rounded-full" src="{{ $comment->user->image ? $comment->user->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
            <a href="{{ route('profile.show', $comment->user) }}" class="text-[10px] sm:text-xs lg:text-base hover:underline hover:text-blue-600 duration-300 ease-in-out">{{ $comment->user->username }}</a>
        </div>

        {{-- waktu komentar --}}
        <div>
            <p class="text-[10px] sm:text-xs md:text-base">{{ $comment->created_at->diffForHumans() }}</p>
        </div>
    </div>

    {{-- isi komentar --}}
    <div class="flex items-start justify-between mt-2">
        <div class="w-full md:w-3/4 lg:w-1/2">
           <p class="text-[9px] sm:text-xs lg:text-base">{{ $comment->body }}</p>
           <button type="button" @click="openReply = true; commentId = {{ $comment->id }}; username = '{{ $comment->user->username }}'" class="text-[9px] ml-3 sm:text-[10px] md:text-xs hover:cursor-pointer text-blue-500 hover:text-blue-700 hover:underline duration-300">Reply</button>

           @if ($comment->replyComments->count() > 0)
                <button type="button" class="text-[8px] ml-4 block sm:text-xs xl:text-sm text-white duration-300">---- Replies Comments ({{ $comment->replyComments->count() }})</button>
                <div class="pl-4 space-y-2 md:space-y-4">
                @foreach ($comment->replyComments()->orderBy('created_at', 'desc')->get() as $replyComment)
                <div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-1">
                                <img class="w-3 h-3 sm:w-4 sm:h-4 xl:w-5 xl:h-5 rounded-full object-cover" src="{{ $replyComment->user->image ? $replyComment->user->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
                                <a href="{{ route('profile.show', $replyComment->user) }}" class="text-[8px] hover:underline sm:text-[10px] xl:text-xs hover:text-blue-600 duration-300 ease-in-out">{{ $replyComment->user->username }}</a>
                        </div>
                        <div>
                            <p class="text-[8px] sm:text-[10px] xl:text-xs">{{ $replyComment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[8px] sm:text-[10px] xl:text-xs">{{ $replyComment->body }}</p>
                    </div>
                </div>
               @endforeach
                </div>
           @endif
        </div>


        {{-- like komentar --}}
        <form action="{{ Auth::check() && $comment->likedByUsers->contains(Auth::user()->id) ? route('post.comment.unlike', $comment) : route('post.comment.like', $comment) }}" class="flex flex-col items-center" method="POST">
            @method(Auth::check() && $comment->likedByUsers->contains(Auth::user()->id) ? 'DELETE' : 'POST')
            @csrf
            <button type="submit">
                <svg class="w-3 h-3 md:w-4 md:h-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="{{ Auth::check() && $comment->likedByUsers->contains(Auth::user()->id) ? 'fill-red-600' : 'fill-white' }}" d="M19.3 8.08004C19.019 7.74269 18.6674 7.47113 18.27 7.28452C17.8726 7.0979 17.439 7.0008 17 7.00004H12.44L13 5.57004C13.2329 4.94393 13.3105 4.27065 13.2261 3.60797C13.1416 2.94528 12.8977 2.31297 12.5152 1.76527C12.1327 1.21758 11.623 0.770841 11.0299 0.463388C10.4369 0.155934 9.77804 -0.00305943 9.11 4.45912e-05C8.91764 0.000445953 8.72948 0.0563198 8.56807 0.160967C8.40666 0.265615 8.27887 0.414594 8.2 0.590044L5.35 7.00004H3C2.20435 7.00004 1.44129 7.31611 0.87868 7.87872C0.316071 8.44133 0 9.2044 0 10V17C0 17.7957 0.316071 18.5588 0.87868 19.1214C1.44129 19.684 2.20435 20 3 20H15.73C16.4318 19.9998 17.1113 19.7535 17.6503 19.3041C18.1893 18.8546 18.5537 18.2304 18.68 17.54L19.95 10.54C20.0286 10.1074 20.011 9.66283 19.8987 9.23772C19.7864 8.81262 19.582 8.4174 19.3 8.08004ZM5 18H3C2.73478 18 2.48043 17.8947 2.29289 17.7072C2.10536 17.5196 2 17.2653 2 17V10C2 9.73483 2.10536 9.48047 2.29289 9.29294C2.48043 9.1054 2.73478 9.00004 3 9.00004H5V18ZM18 10.18L16.73 17.18C16.6874 17.413 16.5635 17.6233 16.3804 17.7734C16.1973 17.9236 15.9668 18.0039 15.73 18H7V8.21004L9.72 2.09004C9.99998 2.17167 10.26 2.31045 10.4837 2.49763C10.7073 2.6848 10.8897 2.91631 11.0194 3.17754C11.1491 3.43876 11.2232 3.72404 11.2371 4.01535C11.2509 4.30666 11.2043 4.59768 11.1 4.87004L10.57 6.30005C10.4571 6.6023 10.4189 6.92739 10.4589 7.24758C10.4988 7.56776 10.6156 7.87353 10.7993 8.13878C10.983 8.40404 11.2282 8.62091 11.5139 8.77088C11.7996 8.92086 12.1173 8.99948 12.44 9.00004H17C17.1469 8.99981 17.2921 9.03194 17.4252 9.09416C17.5582 9.15638 17.676 9.24716 17.77 9.36004C17.8663 9.47137 17.9369 9.60259 17.9767 9.74434C18.0164 9.88608 18.0244 10.0349 18 10.18Z" fill="black"/>
                </svg>
            </button>
            @if ($comment->likedByUsers->count() !== 0)
               <p class="text-[8px] md:text-sm">{{ $comment->likedByUsers->count() }}</p>
            @endif
        </form>
    </div>

</div>
