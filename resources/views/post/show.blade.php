<x-app-layout>
    <x-layout-content class="w-[75%] sm:w-[60%] rounded-lg ml-4 sm:ml-0">

        {{-- Postingan detail --}}
        <div class="p-3 sm:p-6 space-y-4">
           <x-post-template :post="$post" :userLikesPost="$post->likedByUsers()->orderBy('post_like_user.created_at', 'desc')->get()" />
           {{-- Form Pengisian Comment --}}
           <form action="{{ route('post.comment', $post) }}" method="POST">
                @csrf
                <div class="flex items-start gap-2">
                    <div class="w-[80%]">
                      <x-text-input class="w-full py-1 md:py-2  text-[11px] md:text-base" name="comment" type="text" placeholder="Add a comment..." autocomplete="off"></x-text-input>
                        @error('comment')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-[9px] sm:text-[10px] md:text-base duration-300 ease-in-out text-white px-2 sm:px-3 py-2 rounded sm:rounded-lg w-[20%]">Submit</button>
                </div>
           </form>

           {{-- comment dari semua user yang comment --}}
           <div class="space-y-6">
                <h1 class="text-[10px] sm:text-lg font-bold">{{ $post->comments->count() }} Comments</h1>
                @if ($post->comments->count() === 0)
                    <h1 class="text-[10px] sm:text-lg text-center">No Comments yet</h1>
                @else
                    @foreach ($post->comments()->with('user')->orderBy('created_at', 'desc')->get() as $comment)
                        <x-comment-template :comment="$comment"/>
                    @endforeach

                @endif
           </div>
        </div>



    </x-layout-content>

    {{-- Suggesstion To Follow --}}
    <x-layout-content class="w-[25%] sm:w-[20%] p-3 sm:p-4 rounded-lg mr-4 sm:mr-0">
        {{-- User user yang baru daftar di web ini --}}
        <div class="space-y-4">
            <h1 class="text-[10px] sm:text-xs lg:text-base">Who To Follow</h1>
            {{-- user user yang baru daftar di web ini --}}
            @foreach ($users as $user)
                @if (Auth::check())
                    @if ($user->id !== Auth::user()->id)
                        <x-suggest-follow :user="$user" />
                    @endif
                @else
                    <x-suggest-follow :user="$user" />
                @endif
            @endforeach
        </div>
    </x-layout-content>
</x-app-layout>
