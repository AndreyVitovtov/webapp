function index(data) {
    if (typeof data.draw.date !== 'undefined') {
        const targetDate = new Date(data.draw.date).getTime();
        startCountdown(targetDate, 'timer');
        console.log(data);
    }
    Telegram.MainButton.setText(data.mainButton.text);
    Telegram.MainButton.show();
    Telegram.MainButton.onClick(function () {
        Telegram.openTelegramLink(data.mainButton.url);
    });
    Telegram.setBottomBarColor('#ffffff');
}

async function profile(data) {
    if (typeof window.tonConnect === 'undefined') {
        window.tonConnect = new TonConnectSDK.TonConnect({
            manifestUrl : 'https://web-app.vytovtov.pro/tonconnect-manifest.json'
        });
        const walletsList = await window.tonConnect.getWallets();
        console.log(walletsList);

        const walletConnectionSource = {
            universalLink: 'https://t.me/wallet?attach=wallet',
            bridgeUrl: 'https://walletbot.me/tonconnect-bridge/bridge',
            returnStrategy: 'back'
        }

        const universalLink = window.tonConnect.connect(walletConnectionSource);
        console.log(universalLink);

        Telegram.openTelegramLink(universalLink);

    } else {
        window.tonConnect.restoreConnection();
    }

    window.tonConnect.onStatusChange(walletInfo => {
        console.log("Кошелек подключен:", walletInfo);
        Telegram.openTelegramLink(Telegram.initDataUnsafe.start_param);
    });
}

function referrals(data) {

}

function updateContent(data, direction = 'left') {
    let content = document.querySelector('div.content');
    let activeItem = document.querySelector('.app-menu-item.active');
    let newActiveItem = document.querySelector(`.app-menu-item[data-page="${data.page}"]`);

    const activeItemRect = activeItem.getBoundingClientRect();
    const newActiveItemRect = newActiveItem.getBoundingClientRect();

    if (newActiveItemRect.left < activeItemRect.left) {
        direction = 'right';
    } else {
        direction = 'left';
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