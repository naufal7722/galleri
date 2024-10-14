document.querySelectorAll('.like-icon').forEach(icon => {
    icon.addEventListener('click', function() {
        var fotoid = this.getAttribute('data-fotoid');
        var likeCountElement = this.querySelector('.like-count');
        var heartIcon = this.querySelector('i'); // Heart icon

        // AJAX request to like.php
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "like.php?fotoid=" + fotoid, true);
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);

                if (response.status === "liked") {
                    // Update like count and change icon to liked
                    likeCountElement.textContent = response.like_count;
                    heartIcon.classList.remove('far'); // Remove outline heart (unliked)
                    heartIcon.classList.add('fas');    // Add solid heart (liked)
                    heartIcon.style.color = 'black';   // Change color to black (liked)
                } else if (response.status === "unliked") {
                    // Update like count and change icon to unliked
                    likeCountElement.textContent = response.like_count;
                    heartIcon.classList.remove('fas'); // Remove solid heart (liked)
                    heartIcon.classList.add('far');    // Add outline heart (unliked)
                    heartIcon.style.color = 'white';   // Change color to white (unliked)
                } else {
                    alert("An error occurred. Please try again.");
                }
            }
        };
        xhr.send();
    });
});


 // JavaScript untuk mengirim komentar
// JavaScript untuk mengirim komentar
document.querySelectorAll('form[id^="commentForm"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        var fotoid = this.id.replace('commentForm', ''); // Mendapatkan fotoid dari id form
        var commentInput = document.getElementById('commentInput' + fotoid);
        var comment = commentInput.value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_comment.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);
                if (response.status === "success") {
                    // Menambahkan komentar baru ke daftar komentar
                    var commentsList = document.getElementById('commentsList' + fotoid);
                    
                    // Buat elemen komentar baru sesuai dengan format yang ada
                    var newComment = document.createElement('div');
                    newComment.className = 'card mb-2'; // Menggunakan class yang sama
                    newComment.innerHTML = `
                        <div class="card-body">
                            <h6 class="card-text comment-text">${response.username}</h6>
                            <p class="card-text comment-text">${comment}</p>
                            <p class="card-text comment-text"><small class="text-muted">${response.tanggalkomentar}</small></p>
                        </div>
                    `;

                    // Tambahkan komentar baru di bawah heading "Komentar:"
                    commentsList.appendChild(newComment); // Ganti insertAdjacentElement dengan appendChild
                    commentInput.value = ''; // Mengosongkan input komentar
                } else {
                    alert("Gagal menambahkan komentar.");
                }
            }
        };
        xhr.send("fotoid=" + fotoid + "&comment=" + encodeURIComponent(comment));
    });
});


document.getElementById('searchInput').addEventListener('input', function() {
    var searchQuery = this.value; // Ambil input pencarian

    // Lakukan request AJAX untuk memperbarui hasil pencarian
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "search_foto.php?search=" + encodeURIComponent(searchQuery), true);
    xhr.onload = function() {
        if (this.status === 200) {
            // Perbarui konten galeri berdasarkan hasil pencarian
            document.getElementById('galleryContainer').innerHTML = this.responseText;
        }
    };
    xhr.send();
});

