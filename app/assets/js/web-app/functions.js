function index(data) {
    if (typeof data.draw.date !== 'undefined') {
        const targetDate = new Date(data.draw.date).getTime();
        startCountdown(targetDate, 'timer', (data) => {
            alert('Countdown ended');
        });
    }

    const menu = document.querySelector('.app-menu');
    if (window.getComputedStyle(menu).display === 'none') {
        menu.style.display = 'flex';
    }

    let elementInviteUsers = document.querySelector('#invite-users');
    if (elementInviteUsers) {
        elementInviteUsers.addEventListener('click', () => {
            Telegram.openTelegramLink(data.mainButton.url);
        });
    }

    let elementCheckSubscribe = document.querySelector('#check-subscribe');
    if (elementCheckSubscribe) {
        elementCheckSubscribe.addEventListener('click', () => {
            webSocketSendMessage(
                {
                    'type': 'indexCheckSubscribe',
                    'drawId': data.draw.id
                })
        });
    }

    let elementsSubscribeTo = document.querySelectorAll('.subscribe-to');
    if (elementsSubscribeTo) {
        elementsSubscribeTo.forEach(element => {
            element.addEventListener('click', () => {
                let url = element.dataset.channel;
                Telegram.openTelegramLink(url);
            });
        });
    }
}

function share(data) {
    document.querySelector('.invite-users').addEventListener('click', () => {
        Telegram.openTelegramLink(data.mainButton.url);
    });

    document.querySelector('.copy-link').addEventListener('click', (event) => {
        navigator.clipboard.writeText(data.url).then(() => {
            Telegram.showPopup({
                'message': data.popupText
            });
        }).catch(err => {
            alert('Failed to copy');
        });
    });
}

async function profile(data) {
    if (typeof window.tonConnect === 'undefined') {
        window.tonConnect = new TonConnectSDK.TonConnect({
            manifestUrl: TON_CONNECT_MANIFEST
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
        let url = APP_URL + '?startapp=' + Telegram.initDataUnsafe.start_param;
        setTimeout(() => {
            Telegram.openTelegramLink(url);
        }, 500);
    });
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

function parseParams(str) {
    const result = {};
    const regex = /([a-zA-Z]+)-([^_]+)|([a-zA-Z]+)-(.+)/g;
    let match;

    while ((match = regex.exec(str)) !== null) {
        const key = match[1] || match[3];
        result[key] = match[2] || match[4];
    }
    return result;
}

function indexCheckSubscribe(data) {
    let images = document.querySelectorAll('.subscribe-to-image');
    if (images) {
        images.forEach(image => {
            let id = image.dataset.id;
            if (data['subscribe']['subscribeChannels'][id]) image.src = image.src.replace('check-cancel', 'check-ok');
            else image.src = image.src.replace('check-ok', 'check-cancel');
        });
    }
    if (data.subscribe.subscribe) {
        let element = document.querySelector('#check-subscribe');
        if (element) {
            element.id = 'invite-users';
            element.innerText = data.subscribe.text;
            let elementInviteUsers = document.querySelector('#invite-users');
            if (elementInviteUsers) {
                elementInviteUsers.addEventListener('click', () => {
                    Telegram.openTelegramLink(data['subscribe']['mainButton']['url']);
                });
            }
        }
    }
}