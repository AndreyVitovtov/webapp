document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        $('.table').DataTable();
    });

    document.querySelector('.form-select-draw').addEventListener('submit', (e) => {
        e.preventDefault();
        let select = document.querySelector('.select-draw');
        let value = select.value;
        if (value !== '0') location.href = '/winners/draw/' + select.value;
        else location.href = '/winners';

    });
});