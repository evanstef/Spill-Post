@props(['notification' => null,
        'message' => '' ])

<div class="flex items-center justify-between">
    <div class="flex items-center gap-1 text-[11px] sm:text-sm lg:text-base">
        <div class="flex items-center gap-1">
            <img class="w-6 h-6 rounded-full object-cover" src="{{ $notification->actionBy->image ? $notification->actionBy->image : asset('images-profil/gambar-foto-profil-7.jpg') }}" alt="">
            <a href="{{ route('profile.show', $notification->actionBy->username) }}" class="hover:underline hover:text-blue-600">{{ $notification->actionBy->username }}</a>
        </div>
        <p>{{ $message }}</p>
        @if ($notification->type !== 'follow')
            <a href="{{ route('post.show', $notification->post->id ) }}" class="hover:underline hover:text-blue-600">SpillPost</a>
        @endif
    </div>

    <div>
        <p class="text-[9px] sm:text-xs">{{ $notification->created_at->gt(now()->subDays(7)) ?  $notification->created_at->diffForHumans() : $notification->created_at->toFormattedDateString() }}</p>
    </div>
</div>
