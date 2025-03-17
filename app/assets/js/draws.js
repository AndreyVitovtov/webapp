document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-link').forEach(element => {
        element.addEventListener('click', (event) => {
            element = event.target.closest('.copy-link');
            navigator.clipboard.writeText(element.dataset.link).then(() => {
                showMessage(element.dataset.message);
            });
        })
    });

    let table = $('.table-winners').DataTable({
        order: [[1, 'asc']]
    });

    let selectedUsers = {};

    document.addEventListener("change", function (event) {
        let checkbox = event.target;
        if (checkbox.matches("input[name='userIds[]']")) {
            let userId = checkbox.dataset.id;
            let userName = checkbox.dataset.name;

            if (checkbox.checked) {
                selectedUsers[userId] = userName;
            } else {
                delete selectedUsers[userId];
            }
        }
    });

    table.on('draw', function () {
        document.querySelectorAll("input[name='userIds[]']").forEach(checkbox => {
            if (selectedUsers[checkbox.dataset.id]) {
                checkbox.checked = true;
            }
        });
    });

    document.querySelector("#selectWinnersModal .btn-secondary:last-child").addEventListener("click", function () {
        let winnersBlock = document.querySelector(".winners");
        winnersBlock.innerHTML = "";

        if (Object.keys(selectedUsers).length > 0) {
            let table = document.createElement("table");
            table.classList.add("table", "table-responsive", "table-hover", "table-striped");

            let thead = document.createElement("thead");
            thead.innerHTML = `<tr><th></th><th>${window.username}</th></tr>`;
            table.appendChild(thead);

            let tbody = document.createElement("tbody");

            Object.entries(selectedUsers).forEach(([id, name]) => {
                let row = document.createElement("tr");
                row.innerHTML = `<td><input type="checkbox" name="selected-winners[]" value="${id}" checked></td><td>${name}</td>`;
                tbody.appendChild(row);
            });

            table.appendChild(tbody);
            winnersBlock.appendChild(table);
        } else {
            winnersBlock.innerHTML = "";
        }

        let modal = bootstrap.Modal.getInstance(document.getElementById('selectWinnersModal'));
        modal.hide();
    });
});

