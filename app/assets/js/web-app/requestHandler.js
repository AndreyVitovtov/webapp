function page(data) {
    if (data.sc) {
        let appMenuItems = document.querySelectorAll('.app-menu-item');
        if (appMenuItems) {
            appMenuItems.forEach(item => {
                let img = item.querySelector('img');
                img.src = img.src.replace('-active', '');
            });
            let menuImg = document.querySelector(`.app-menu-item[data-page="${data.page}"] img`);
            let src = menuImg.src;
            menuImg.src = src.replace('.svg', '-active.svg');
        }

        Telegram.setHeaderColor(HEADER_COLOR);
        let content = document.querySelector('div.app-content');
        content.innerHTML = data.html;

        // updateContent(data);

        if (typeof window[data.page] === "function") {
            window[data.page](data);
        }
    }
}