let timerInterval;

function startCountdown(targetDate) {
    function updateTimer() {
        if (document.getElementById("days-container") === null) return;

        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance <= 0) {
            clearInterval(timerInterval);
            document.getElementById("days-container").classList.add("hidden");
            document.getElementById("days-separator").classList.add("hidden");
            ["hours-tens", "hours-units", "minutes-tens", "minutes-units", "seconds-tens", "seconds-units"].forEach(id => {
                document.getElementById(id).textContent = "0";
            });
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
        const minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
        const seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');

        if (days > 0) {
            document.getElementById("days-container").classList.remove("hidden");
            document.getElementById("days-separator").classList.remove("hidden");
            document.getElementById("days-tens").textContent = days >= 10 ? String(days)[0] : "0";
            document.getElementById("days-units").textContent = String(days).slice(-1);
        } else {
            document.getElementById("days-container").classList.add("hidden");
            document.getElementById("days-separator").classList.add("hidden");
        }

        document.getElementById("hours-tens").textContent = hours[0];
        document.getElementById("hours-units").textContent = hours[1];
        document.getElementById("minutes-tens").textContent = minutes[0];
        document.getElementById("minutes-units").textContent = minutes[1];
        document.getElementById("seconds-tens").textContent = seconds[0];
        document.getElementById("seconds-units").textContent = seconds[1];
    }

    updateTimer();
    timerInterval = setInterval(updateTimer, 1000);
}