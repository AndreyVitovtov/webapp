let timerIntervals = {};

function startCountdown(targetDate, containerId, onEnd = () => {
    console.log('Countdown ended');
}) {
    function updateTimer() {
        const container = document.getElementById(containerId);
        if (!container) return;

        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance <= 0) {
            clearInterval(timerIntervals[containerId]);
            delete timerIntervals[containerId];

            const daysContainer = container.querySelector(".days-container");
            const daysSeparator = container.querySelector(".days-separator");

            if (daysContainer) daysContainer.classList.add("hidden");
            if (daysSeparator) daysSeparator.classList.add("hidden");

            ["hours-tens", "hours-units", "minutes-tens", "minutes-units", "seconds-tens", "seconds-units"].forEach(className => {
                const el = container.querySelector(`.${className}`);
                if (el) el.textContent = "0";
            });

            // Вызываем onEnd() только при фактическом окончании отсчёта
            if (typeof onEnd === "function" && !container.dataset.ended) {
                container.dataset.ended = "true"; // Помечаем, что таймер завершился
                onEnd();
            }
            return;
        }

        container.dataset.ended = "";

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
        const minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
        const seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');

        const daysContainer = container.querySelector(".days-container");
        const daysSeparator = container.querySelector(".days-separator");

        if (days > 0) {
            if (daysContainer) daysContainer.classList.remove("hidden");
            if (daysSeparator) daysSeparator.classList.remove("hidden");

            const daysTens = container.querySelector(".days-tens");
            const daysUnits = container.querySelector(".days-units");

            if (daysTens) daysTens.textContent = days >= 10 ? String(days)[0] : "0";
            if (daysUnits) daysUnits.textContent = String(days).slice(-1);
        } else {
            if (daysContainer) daysContainer.classList.add("hidden");
            if (daysSeparator) daysSeparator.classList.add("hidden");
        }

        const timeElements = {
            "hours-tens": hours[0],
            "hours-units": hours[1],
            "minutes-tens": minutes[0],
            "minutes-units": minutes[1],
            "seconds-tens": seconds[0],
            "seconds-units": seconds[1]
        };

        for (const [className, value] of Object.entries(timeElements)) {
            const el = container.querySelector(`.${className}`);
            if (el) el.textContent = value;
        }
    }

    if (timerIntervals[containerId]) {
        clearInterval(timerIntervals[containerId]);
        delete timerIntervals[containerId];
    }

    updateTimer();
    timerIntervals[containerId] = setInterval(updateTimer, 1000);
}
