document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        $('.table').DataTable();
    });

    document.querySelectorAll('.table-users').forEach(el => {
        el.addEventListener('click', (e) => {
            if (!e.target.closest('.btn')) {
                console.log(el);
                let id = el.dataset.id;
                location.href = '/users/details/' + id;
            }
        });
    });
});