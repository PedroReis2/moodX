document.addEventListener('DOMContentLoaded', () => {
    // Abrir modal
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', () => {
            const id = item.dataset.entryId;
            document.getElementById('modal-' + id).classList.add('active');
        });
    });

    // Fechar modal pelo botão
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const modal = e.target.closest('.modal-backdrop');
            if (modal) modal.classList.remove('active');
        });
    });

    // Fechar modal clicando fora do conteúdo
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.classList.remove('active');
            }
        });
    });
});
