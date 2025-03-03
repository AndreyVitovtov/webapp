function page(data) {
    if (data.sc) {
        localStorage.setItem('page', data.page);
        let appMenuItems = document.querySelectorAll('.app-menu-item');
        if (appMenuItems) {
            appMenuItems.forEach(item => {
                let img = item.querySelector('img');
                img.src = img.src.replace('-active', '');
            });
            if (data.page === 'airdrop') data.page = data.page.replace('airdrop', 'airdrops');
            let menuImg = document.querySelector(`.app-menu-item[data-page="${data.page}"] img`);
            if (menuImg) {
                let src = menuImg.src;
                menuImg.src = src.replace('.svg', '-active.svg');
            }
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

