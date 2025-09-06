const openModal = document.getElementById('open-modal');
const modal = document.getElementById('modal');


openModal.addEventListener('click', () => {
modal.removeAttribute('hidden');
});


modal.addEventListener('click', (e) => {
if (e.target.dataset.close !== undefined || e.target.closest('[data-close]')) {
modal.setAttribute('hidden', 'true');
}
});
