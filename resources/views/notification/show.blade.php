<x-app-layout>
    <x-layout-content class="w-full sm:w-[80%] rounded-lg mx-4 sm:mx-0">
        {{-- pengecekan bila belum ada notfikasi --}}
        @if ($notifications->count() === 0)
            <h1 class="text-[10px] sm:text-lg text-center p-3 sm:p-6">No Notifications Yet</h1>
        @else
            {{-- menampilkan notifikasi --}}
            <div class="flex items-center justify-between px-3 sm:px-6 py-4">
               <h1 class="text-lg sm:text-xl lg:text-2xl font-bold">All Notifications</h1>

                <div class="flex gap-2 items-center" x-data="{ openWarningDeleteNotif : false }">
                    {{-- untuk membuat semua notif di read jadi secara tidak langsung mengubah nilai is_read menjadi true --}}
                    <form action="{{ route('notification.mark-all-as-read') }}" method="POST">
                        @csrf
                        <x-primary-button type="submit">mark all as read</x-primary-button>
                    </form>

                    {{-- menghapus semua notif --}}
                    <x-danger-button type="button" @click="openWarningDeleteNotif = true" >Delete all</x-danger-button>

                    {{-- warning template untuk menghapus semua notif --}}
                    <div x-show="openWarningDeleteNotif" class="fixed top-0 left-0 w-full h-full bg-slate-950 bg-opacity-75 flex justify-center items-center z-50" style="display: none">
                        <div class="bg-white z-50 dark:bg-gray-800 w-11/12 sm:w-3/4 lg:w-[70%] xl:w-[40%] rounded-lg p-6 sm:p-4 relative" @click.outside="openWarningDeleteNotif = false">

                            {{-- Form Content --}}
                            <h2 class="lg:text-xl font-bold mb-4">Are You Sure Want To Delete All Notifications ?</h2>
                            <form action="{{ route('notification.delete-all') }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <h1 class="text-[10px] md:text-sm mb-4">All Notifications Will Be Deleted Permanently and Cant Be Undone</h1>
                                <div class="flex justify-end">
                                    <button @click="openWarningDeleteNotif = false" type="button" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg ">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>


            <div class="w-full h-[1px] bg-gray-100"></div>
            @foreach ($notifications as $notification)
            <div class="px-3 sm:px-6 py-2 sm:py-4">
                {{-- di cek bila type notif ini like --}}
                @if ($notification->type === 'like')
                    <x-notif-template :notification="$notification" message="has liked your" />
                @elseif ($notification->type === 'comment')
                    <x-notif-template :notification="$notification" message="has commented on your" />

                @elseif ($notification->type === 'follow')
                    <x-notif-template :notification="$notification" message="has started following you" />
                @endif
            </div>
            @if (!$loop->last)
                <div class="w-full h-[1px] bg-gray-100"></div>
            @endif

            @endforeach

            @if ($notifications->hasPages())
              <div class="px-3 py-2 sm:px-4">{{ $notifications->links() }}</div>
            @endif

        @endif

    </x-layout-content>
</x-app-layout>
