document.addEventListener('DOMContentLoaded', () => {
    document.getElementById("textForm").addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const jsonData = JSON.stringify(Object.fromEntries(formData));

        const response = await fetch("/texts/save", {
            method: "POST",
            body: jsonData,
            headers: {"Content-Type": "application/json"}
        });

        if (!response.ok) {
            throw new Error(`Error: ${response.status}`);
        }

        const result = await response.json();
        window.scrollTo({ top: 0, behavior: "smooth" });
        showMessage(result['message'])
    });
});