function previewPostImages(event) {
    const previewPostContainer = document.getElementById('preview_post_image');
    const files = event.target.files;

    previewPostContainer.innerHtml = '';

    if (files.length > 0) {
    previewPostContainer.classList.remove('hidden');
    previewPostContainer.classList.add('grid'); // Tampilkan kontainer gambar jika ada gambar yang diunggah

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function(e) {
            // Membuat elemen kontainer untuk setiap gambar dan tombol hapus
            const imageWrapper = document.createElement('div');
            imageWrapper.classList.add('relative', 'w-18', 'h-16', 'sm:w-24', 'sm:h-[70px]', 'md:w-28', 'md:h-20' ,'lg:w-36', 'lg:h-24', 'xl:w-[120px]', 'xl:h-[90px]');

            // Membuat elemen img untuk menampilkan gambar
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('w-full', 'h-full', 'object-cover', 'rounded', 'xl:rounded-lg');

            // Membuat tombol hapus untuk setiap gambar
            const cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.classList.add('absolute', 'top-[2px]', 'md:top-1', 'right-[2px]' ,'md:right-1', 'rounded-full');
            cancelButton.innerHTML = `
                <svg class="w-4 h-4 md:w-5 md:h-5 p-1 bg-white rounded-full" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-black" d="M9.40994 8.00019L15.7099 1.71019C15.8982 1.52188 16.004 1.26649 16.004 1.00019C16.004 0.733884 15.8982 0.478489 15.7099 0.290185C15.5216 0.101882 15.2662 -0.00390625 14.9999 -0.00390625C14.7336 -0.00390625 14.4782 0.101882 14.2899 0.290185L7.99994 6.59019L1.70994 0.290185C1.52164 0.101882 1.26624 -0.00390601 0.999939 -0.00390601C0.733637 -0.00390601 0.478243 0.101882 0.289939 0.290185C0.101635 0.478489 -0.00415253 0.733884 -0.00415254 1.00019C-0.00415254 1.26649 0.101635 1.52188 0.289939 1.71019L6.58994 8.00019L0.289939 14.2902C0.196211 14.3831 0.121816 14.4937 0.0710478 14.6156C0.0202791 14.7375 -0.00585938 14.8682 -0.00585938 15.0002C-0.00585938 15.1322 0.0202791 15.2629 0.0710478 15.3848C0.121816 15.5066 0.196211 15.6172 0.289939 15.7102C0.382902 15.8039 0.493503 15.8783 0.615362 15.9291C0.737221 15.9798 0.867927 16.006 0.999939 16.006C1.13195 16.006 1.26266 15.9798 1.38452 15.9291C1.50638 15.8783 1.61698 15.8039 1.70994 15.7102L7.99994 9.41018L14.2899 15.7102C14.3829 15.8039 14.4935 15.8783 14.6154 15.9291C14.7372 15.9798 14.8679 16.006 14.9999 16.006C15.132 16.006 15.2627 15.9798 15.3845 15.9291C15.5064 15.8783 15.617 15.8039 15.7099 15.7102C15.8037 15.6172 15.8781 15.5066 15.9288 15.3848C15.9796 15.2629 16.0057 15.1322 16.0057 15.0002C16.0057 14.8682 15.9796 14.7375 15.9288 14.6156C15.8781 14.4937 15.8037 14.3831 15.7099 14.2902L9.40994 8.00019Z" fill="black"/>
                </svg>
            `;

            // Fungsi untuk menghapus gambar tertentu saat tombol hapus diklik
            cancelButton.onclick = function() {
                imageWrapper.remove();
                if (previewPostContainer.children.length === 0) {
                    previewPostContainer.classList.add('hidden'); // Sembunyikan kontainer jika semua gambar dihapus
                }
            };

            // Menambahkan gambar dan tombol hapus ke dalam kontainer gambar
            imageWrapper.appendChild(img);
            imageWrapper.appendChild(cancelButton);
            previewPostContainer.appendChild(imageWrapper);
        };

        reader.readAsDataURL(file);
    }
  }

}

// function untuk menampilkan hashtag pada saat user
async function showHashtag() {
    const content = document.getElementById('content').value;
    const hashtagContainer = document.getElementById('hashtag-container');

    // Regex untuk mendeteksi hashtag yang valid tanpa spasi atau enter setelahnya
    const hashtagMatch = content.match(/(^|\s)#\w+$/g);

    // Jika hashtag ada di akhir kalimat dan tidak diikuti spasi atau enter
    if (hashtagMatch && !content.endsWith(' ') && !content.endsWith('\n')) {

        hashtagContainer.classList.remove('hidden'); // Tampilkan container jika ada

        // untuk mengambil hashtag terbaru yang diinput oleh user
        const hashtag = hashtagMatch[0].trim();

        // Memuat data hashtag dari API
        try {
            const response = await fetch(`/search/hashtag?content_hashtag=${encodeURIComponent(hashtag)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const hashtags = await response.json();

            console.log(hashtags);

            // pengecekan bila hashtags tidak ada
            if(hashtags.length === 0) {
                hashtagContainer.innerHTML = '<div class="text-[10px] sm:text-[12px] text-center">No Hashtag Available Create New One</div>';
            } else {
                // melooping semua data hashtags yang ada
                hashtagContainer.innerHTML = hashtags.map((item) => {
                return `
                    <div onclick="selectHashtag('${item.name}')" class="text-[10px] sm:text-[12px] rounded px-2 py-1 lg:py-2  hover:cursor-pointer hover:bg-gray-700 duration-200 ease-in-out line-clamp-1">
                        ${item.name}
                    </div>
                `
                }).join('');
            }



        } catch (error) {
          console.log(error.message);
        }

    } else {
        hashtagContainer.classList.add('hidden'); // Sembunyikan container
    }
}

// function untuk memilih hashtag yang diinput oleh user
function selectHashtag(hashtag) {
    const content = document.getElementById('content');
    const currentText = content.value;

    // Menyisipkan hashtag yang diklik
    const newText = currentText.replace(/#\w+$/, hashtag + ' ');
    content.value = newText;
}
