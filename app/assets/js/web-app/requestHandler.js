function page(data) {
    if (data.sc) {
        console.log(data);
        Telegram.setHeaderColor(HEADER_COLOR);
        let content = document.querySelector('div.app-content');
        content.innerHTML = data.html;

        if(data.page === 'index') {
            // const targetDate = new Date(window.dateTime).getTime();
            const targetDate = new Date("2025-02-18T00:00:00").getTime();
            startCountdown(targetDate);

            Telegram.MainButton.setText("Invite");
            Telegram.MainButton.show();
            Telegram.WebApp.openLink("https://t.me/");
        }




        // updateContent(data);

        function updateContent(data, direction = 'left') {
            let content = document.querySelector('div.content');
            let activeItem = document.querySelector('.app-menu-item.active');
            let newActiveItem = document.querySelector(`.app-menu-item[data-page="${data.page}"]`);

            // Сравниваем позиции текущего и нового активного пунктов меню
            const activeItemRect = activeItem.getBoundingClientRect();
            const newActiveItemRect = newActiveItem.getBoundingClientRect();

            // Определяем направление
            if (newActiveItemRect.left < activeItemRect.left) {
                direction = 'right';  // Если новый пункт слева, движение влево
            } else {
                direction = 'left'; // Если новый пункт справа, движение вправо
            }

            let oldContent = document.createElement('div');
            oldContent.classList.add('old-content');
            oldContent.innerHTML = content.innerHTML;

            let newContent = document.createElement('div');
            newContent.classList.add('new-content');
            newContent.innerHTML = data.html;

            let wrapper = document.createElement('div');
            wrapper.classList.add('content-wrapper');
            wrapper.appendChild(oldContent);
            wrapper.appendChild(newContent);

            content.innerHTML = '';
            content.appendChild(wrapper);

            // Двигаем контент в зависимости от направления
            if (direction === 'left') {
                wrapper.style.transform = 'translateX(0%)';
                setTimeout(() => {
                    wrapper.style.transform = 'translateX(-50%)';
                }, 10);
            } else {
                wrapper.style.transform = 'translateX(-50%)';
                wrapper.style.flexDirection = 'row-reverse';
                setTimeout(() => {
                    wrapper.style.transform = 'translateX(0%)';
                }, 10);
            }

            setTimeout(() => {
                content.innerHTML = newContent.innerHTML;
            }, 500);
        }
    }
}
