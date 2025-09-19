document.addEventListener('DOMContentLoaded', () => {
    // Abrir modal
    document.querySelectorAll('.project-card').forEach(card => {
        card.addEventListener('click', () => {
            const id = card.dataset.entryId;
            const modal = document.getElementById('modal-' + id);
            if (!modal) return;

            modal.classList.remove('hidden');

            // Atualiza a imagem do modal (lado esquerdo)
            const modalImage = modal.querySelector('.modal-image-section img');
            if (modalImage) modalImage.src = card.querySelector('img').src;
        });
    });

    // Fechar modal pelo botão
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', e => {
            const modal = e.target.closest('.modal');
            if (modal) modal.classList.add('hidden');
        });
    });

    // Fechar clicando fora do conteúdo
    document.querySelectorAll('.modal').forEach(backdrop => {
        backdrop.addEventListener('click', e => {
            if (e.target === backdrop) backdrop.classList.add('hidden');
        });
    });

    // Formulário de comentários via AJAX
    document.querySelectorAll('.add-comment').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const entryId = this.dataset.entryId;
            const formData = new FormData(this);

            fetch(`/comments/${entryId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                const commentsList = this.closest('.modal-comments').querySelector('.comments-list');

                const article = document.createElement('article');
                article.classList.add('comment');

                const avatar = data.user.profile?.avatar ? '/storage/' + data.user.profile.avatar : 'https://t4.ftcdn.net/jpg/01/86/29/31/360_F_186293166_P4yk3uXQBDapbDFlR17ivpM6B1ux0fHG.jpg';
                const name = data.user.name ?? '...';
                const comment = data.comment;

                article.innerHTML = `
                    <img src="${avatar}" class="comment-avatar" alt="avatar">
                    <div class="comment-content">
                        <div class="comment-username">${name}</div>
                        <div class="comment-text">${comment}</div>
                    </div>
                `;

                commentsList.appendChild(article);
                this.reset();
            });
        });
    });
});
