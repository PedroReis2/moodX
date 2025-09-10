document.querySelectorAll('.add-comment').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let entryId = this.dataset.entryId;
        let formData = new FormData(this);

        fetch(`/comments/${entryId}`, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            let commentsList = this.closest('.modal-comments').querySelector('.comments-list');
            let article = document.createElement('article');
            article.classList.add('comment');
            article.innerHTML = `
                <img src="${data.user.profile?.avatar ?? 'https://i.pravatar.cc/64'}" alt="Avatar" />
                <div>
                    <strong>${data.user.name ?? 'Anon'}</strong>
                    <p>${data.comment}</p>
                    <time datetime="${data.created_at}">agora mesmo</time>
                </div>
            `;
            commentsList.appendChild(article);
            this.reset();
        });
    });
});
