@props(['user' => null])

<div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
    <div class="flex gap-1 sm:gap-2 items-center">
        {{-- foto dari user --}}
        <div class="w-6 h-6 lg:w-8 lg:h-8">
            <img class="w-full h-full rounded-full object-cover" src="{{ $user->image ? $user->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
        </div>

        {{-- nama dan username --}}
        <div>
            <p class="text-[10px] sm:text-[11px] xl:text-sm">{{ $user->name }}</p>
            <a href="{{ route('profile.show', $user ) }}" class="block text-[8px] sm:text-[9px] lg:text-[10px] xl:text-xs hover:underline hover:text-blue-600 duration-300 ease-in-out line-clamp-1">{{ $user->username }}</a>
        </div>
    </div>

    <div>
        <form action="{{ route('follows', $user) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 duration-300 font-bold px-5 lg:px-2 lg:py-1 rounded xl:rounded-lg text-xs xl:text-sm">{{ Auth::check() && $user->isFollowing(Auth::user()->id) ? 'FollBack' : 'Follow' }}</button>
        </form>
    </div>
</div>
