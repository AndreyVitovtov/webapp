document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-link').forEach(element => {
        element.addEventListener('click', (event) => {
            element = event.target.closest('.copy-link');
            navigator.clipboard.writeText(element.dataset.address).then(() => {
                showMessage(element.dataset.message);
            });
        })
    });

    $('.table').DataTable();

    document.querySelectorAll('.btn-actions').forEach(element => {
        element.addEventListener('click', (event) => {
            let id = event.target.dataset.id;
            let status = event.target.dataset.status;
            $.post('/withdrawals/update', {id, status}, function (response) {
                response = JSON.parse(response);
                showMessage(response.message);
                let tr = event.target.closest('tr');
                tr.remove();
                let menuNumber = document.querySelector('.menu-number');
                if (response['numberNewWithdrawals'] === 0) {
                    if (menuNumber) menuNumber.remove();
                } else {
                    if (menuNumber) menuNumber.innerHTML = response['numberNewWithdrawals'];
                }
            });
        });

    });
});