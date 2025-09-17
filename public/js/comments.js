document.querySelectorAll('.add-comment').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let entryId = this.dataset.entryId;
        let formData = new FormData(this);

        fetch(`/comments/${entryId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            let commentsList = this.closest('.modal-comments').querySelector('.comments-list');
            let article = document.createElement('article');
            article.classList.add('comment');

            let avatar = data.user.profile?.avatar ? '/storage/' + data.user.profile.avatar : 'https://t4.ftcdn.net/jpg/01/86/29/31/360_F_186293166_P4yk3uXQBDapbDFlR17ivpM6B1ux0fHG.jpg';
            let name = data.user.name ?? '...';
            let comment = data.comment;
            let time = new Date(data.created_at).toLocaleString(); // ou "agora mesmo" se quiseres simplificar

            article.innerHTML = `
                <img src="${avatar}" alt="Avatar" />
                <div>
                    <strong>${name}</strong>
                    <p>${comment}</p>
                    <time datetime="${data.created_at}">0s</time>
                </div>
            `;

            commentsList.appendChild(article);
            this.reset();
        });
    });
});
