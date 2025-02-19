function page(data) {
    if (data.sc) {
        Telegram.setHeaderColor(HEADER_COLOR);
        let content = document.querySelector('div.app-content');
        content.innerHTML = data.html;

        // updateContent(data);

        if (typeof window[data.page] === "function") {
            window[data.page](data);
        }
    }
}