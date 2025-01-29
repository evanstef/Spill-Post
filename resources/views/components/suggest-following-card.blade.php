@props(['user' => null])


    <div class="w-full h-40 sm:w-36 sm:h-52 md:w-[118px] lg:w-[163px] lg:h-52 xl:w-48 xl:h-60 rounded-lg overflow-hidden bg-black/50 flex items-center justify-center">
        <div class="flex flex-col justify-center items-center gap-1">
            <img class="w-12 h-12 md:w-15 md:h-15 xl:w-20 xl:h-20 rounded-full object-cover" src="{{ $user->image ? $user->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
            <p class="text-white text-sm xl:text-base">{{ $user->username }}</p>
            <form action="{{ route('follows', $user) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 duration-300 ease-in-out text-white px-3 py-1 rounded-lg text-sm xl:text-base">{{ Auth::check() && Auth::user()->isFollowedBy($user->id) && !Auth::user()->isFollowing($user->id) ? 'Follow Back' : 'Follow' }}</button>
            </form>
        </div>
    </div>

