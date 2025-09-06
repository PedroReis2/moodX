document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', () => {
            const id = item.dataset.entryId;
            document.getElementById('modal-' + id).classList.add('active');
        });
    });

    document.querySelectorAll('#btn-close-modal').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const modal = e.target.closest('.modal-backdrop');
            if (modal) {
                modal.classList.remove('active');
            }
        });
    });
});
