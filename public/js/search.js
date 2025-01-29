// mengambil input user



// menampilkan data user yang dicari
async function searchUser() {
    const searchInput = document.getElementById('searchInput').value;
    const searchResult = document.getElementById('search-result');

    try {

        // melakukan fetch ke backend
        const response = await fetch(`/users/search?search=${searchInput}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        // pengecekan bila ada kesalahan dalam pengambilan data
        if (!response.ok) {
            const error = await response.json();
            console.log(error.message);
            return;
        }

        // data semua users
        const users = await response.json();


        // menampilkan data user yang dicari

        // pengeceka bila value input lebih dari tiga karakter
        if (searchInput.length >= 1) {
            searchResult.classList.remove('hidden');
            // dilakukan pengecekan bila users tidak ada
            if (users.length === 0) {
                searchResult.classList.add('h-auto');
                searchResult.classList.remove('h-[270px]');
                searchResult.classList.remove('overflow-y-scroll');
                searchResult.innerHTML = `<h1 class="text-center font-bold">No user found</h1>`;
            } else if(users.length >= 1 && users.length <= 4) {
                searchResult.classList.add('h-auto');
                searchResult.classList.remove('h-[270px]');
                searchResult.classList.remove('overflow-y-scroll');
                searchResult.innerHTML = users.map(user => {
                    return `<a href="/profile/${user.username}" class="w-full px-2 md:px-3 py-1 hover:bg-gray-600 duration-300 ease-in-out rounded lg:rounded-lg flex items-center gap-2">
                                <img class="w-6 h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 xl:w-11 xl:h-11 rounded-full object-cover" src="${user.image ?  user.image : '/images-profil/gambar-foto-profil-7.jpg'}" alt="">
                                <div>
                                    <p class="text-xs md:text-sm lg:text-base">${user.name}</p>
                                    <p class="text-[10px] md:text-xs lg:text-sm">${user.username}</p>
                                </div>
                            </a>`;
                }).join('');
            } else {
                searchResult.classList.remove('h-auto');
                searchResult.classList.add('h-[270px]');
                searchResult.classList.add('overflow-y-scroll');
                searchResult.innerHTML = users.map(user => {
                    return `<a href="/profile/${user.username}" class="w-full px-2 md:px-3 py-1 hover:bg-gray-600 duration-300 ease-in-out rounded lg:rounded-lg flex items-center gap-2">
                                <img class="w-6 h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 xl:w-11 xl:h-11 rounded-full object-cover" src="${user.image ? user.image : '/images-profil/gambar-foto-profil-7.jpg'}" alt="">
                                <div>
                                    <p class="text-xs md:text-sm lg:text-base">${user.name}</p>
                                    <p class="text-[10px] md:text-xs lg:text-sm">${user.username}</p>
                                </div>
                            </a>`;
                }).join('');
            }
        } else {
            searchResult.classList.add('hidden');
        }
    } catch (error) {
        console.log(error);
    }

}


