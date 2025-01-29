<div>
    <input type="text" name="search" id="searchInput" class="w-40 sm:w-72 xl:w-96 bg-gray-700 rounded-lg text-white text-xs sm:text-sm xl:text-base px-2 py-1 sm:px-4 sm:py-1" placeholder="Search..." oninput="searchUser()" autocomplete="off">
    {{-- untuk menampilkan data user yang dicari --}}
    <div id="search-result" class="w-auto h-[270px] hidden absolute top-14 bg-gray-700 rounded-lg z-50 p-2 space-y-4 scrollbar-thumb-gray-400 scrollbar-track-transparent scrollbar-thin">

    </div>
</div>
<script src="{{ asset('js/search.js') }}"></script>
