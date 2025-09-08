
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.dataset.url;
            const modalEl = document.getElementById('universalModal');
            const modalTitle = modalEl.querySelector('#universalModalLabel');
            const modalBody = modalEl.querySelector('.modal-body');

            modalTitle.textContent = this.dataset.title || 'Modal';
            modalBody.innerHTML = 'Loading...';

            fetch(url)
                .then(res => res.text())
                .then(html => modalBody.innerHTML = html)
                .catch(() => modalBody.innerHTML = 'Failed to load content.');

            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });
    });
});
