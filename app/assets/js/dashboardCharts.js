document.addEventListener('DOMContentLoaded', () => {
    let ctxNumberNewUsers = document.getElementById('number-new-users').getContext('2d');
    let numberNewUsers = chart(ctxNumberNewUsers, 'bar', [window.numberRegistrations], [window.titles.number_registration], {
        background: ['rgba(98,91,203,0.2)'],
        border: ['#2c2874'],
        backgroundHover: ['#827de7'],
        borderHover: ['#2c2874']
    });

    let ctxNumberActiveUsers = document.getElementById('number-active-users').getContext('2d');
    let numberActiveUsers = chart(ctxNumberActiveUsers, 'bar', window.activeUsers, [window.titles.number_active], {
        background: ['rgba(98,91,203,0.2)', 'rgb(213,64,96, 0.2)'],
        border: ['#2c2874', '#ff7e7e'],
        backgroundHover: ['#827de7', '#ea5252'],
        borderHover: ['#2c2874', '#e20808']
    }, 'y');


    function chart(ctx, type, dataset, title, colors, indexAxis = 'x') {
        let labels, datasets = [];
        if (Array.isArray(dataset)) {
            labels = Object.keys(dataset[0]);
            dataset.forEach((data, i) => {
                datasets.push({
                    label: '',
                    data: Object.values(data),
                    backgroundColor: colors.background[i] ?? 'rgba(98,91,203,0.2)',
                    borderColor: colors.border[i] ?? '#2c2874',
                    borderWidth: 1,
                    hoverBackgroundColor: (colors.backgroundHover[i] ?? colors.background[i]),
                    hoverBorderColor: (colors.borderHover[i] ?? colors.border[i]),
                    hoverBorderWidth: 1,
                    pointBackgroundColor: '#827de7',
                    tension: 0.3
                });
            });
        } else {
            labels = Object.keys(dataset);
            datasets.push({
                label: '',
                data: Object.values(dataset),
                backgroundColor: colors.background ?? 'rgba(98,91,203,0.2)',
                borderColor: colors.border ?? '#2c2874',
                borderWidth: 1,
                hoverBackgroundColor: (colors.backgroundHover ?? colors.background),
                hoverBorderColor: (colors.borderHover ?? colors.border),
                hoverBorderWidth: 1,
                pointBackgroundColor: '#827de7',
                tension: 0.3
            });
        }
        Object.keys(Array.isArray(dataset) ? dataset[0] : dataset)

        return new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                indexAxis: indexAxis, // Горизонтальная ориентация
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: title
                    },
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});