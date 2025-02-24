let timerIntervals = {};

function startCountdown(targetDate, containerId) {
    function updateTimer() {
        const container = document.getElementById(containerId);
        if (!container) return;

        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance <= 0) {
            clearInterval(timerIntervals[containerId]);
            container.querySelector(".days-container").classList.add("hidden");
            container.querySelector(".days-separator").classList.add("hidden");
            ["hours-tens", "hours-units", "minutes-tens", "minutes-units", "seconds-tens", "seconds-units"].forEach(className => {
                container.querySelector(`.${className}`).textContent = "0";
            });
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
        const minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
        const seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');

        if (days > 0) {
            container.querySelector(".days-container").classList.remove("hidden");
            container.querySelector(".days-separator").classList.remove("hidden");
            container.querySelector(".days-tens").textContent = days >= 10 ? String(days)[0] : "0";
            container.querySelector(".days-units").textContent = String(days).slice(-1);
        } else {
            container.querySelector(".days-container").classList.add("hidden");
            container.querySelector(".days-separator").classList.add("hidden");
        }

        container.querySelector(".hours-tens").textContent = hours[0];
        container.querySelector(".hours-units").textContent = hours[1];
        container.querySelector(".minutes-tens").textContent = minutes[0];
        container.querySelector(".minutes-units").textContent = minutes[1];
        container.querySelector(".seconds-tens").textContent = seconds[0];
        container.querySelector(".seconds-units").textContent = seconds[1];
    }

    if (timerIntervals[containerId]) {
        clearInterval(timerIntervals[containerId]);
    }

    updateTimer();
    timerIntervals[containerId] = setInterval(updateTimer, 1000);
}
