document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-link').forEach(element => {
        element.addEventListener('click', (event) => {
            element = event.target.closest('.copy-link');
            navigator.clipboard.writeText(element.dataset.link).then(() => {
                showMessage(element.dataset.message);
            });
        })
    });
});

