function index(data) {
    if (typeof data.draw !== 'undefined' && typeof data.draw.date !== 'undefined') {
        const targetDate = new Date(data.draw.date).getTime();
        if (typeof data.winners === 'undefined') {
            startCountdown(targetDate, 'timer', (data) => {
                ['.subscribe-to-wrapper', '.invite-users-wrapper', '.timer'].forEach(el => {
                    let element = document.querySelector(el);
                    if (element) element.remove();
                });
                let appBody = document.querySelector('div.app-body');
                if (appBody) {
                    appBody.innerHTML = '';

                    let dice = document.createElement('div');
                    dice.classList.add('dice');
                    let text = document.createElement('div');
                    text.innerHTML = data['weChooseWinnersText'];
                    text.classList.add('draw-text');

                    appBody.appendChild(dice);
                    appBody.appendChild(text);

                    lottie.loadAnimation({
                        container: document.querySelector('.dice'),
                        renderer: 'canvas',
                        loop: true,
                        autoplay: true,
                        animationData: window.diceLottie,
                        prerender: true,
                        rendererSettings: {
                            progressiveLoad: true
                        }
                    });

                    let interval = setInterval(() => {
                        if (document.querySelector('.dice')) {
                            webSocketSendMessage({
                                'type': 'checkDrawCompleted',
                                'drawId': data['draw']['id']
                            });
                        } else clearInterval(interval);
                    }, 10000);
                }
            }, data);
        } else {
            confetti();
        }
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

    let elementSponsor = document.querySelector('.sponsor');
    if (elementSponsor) {
        elementSponsor.addEventListener('click', () => {
            webSocketSendMessage({
                'type': 'getPage',
                'page': 'airdrops'
            });
        });
    }
}

function confetti() {
    let body = document.querySelector('body');
    let confetti = document.createElement('div');
    confetti.classList.add('confetti');
    body.appendChild(confetti);
    let animation = lottie.loadAnimation({
        container: document.querySelector('.confetti'),
        renderer: 'canvas',
        loop: false,
        autoplay: true,
        animationData: window.trophyLottie,
        prerender: true,
        rendererSettings: {
            progressiveLoad: true
        }
    });

    animation.addEventListener('complete', function () {
        document.querySelector('.confetti')?.remove();
    });
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

function wallet(data) {
    let linkWallet = document.querySelector('.link-wallet');

    if (window.walletController) {
        window.walletController.abort();
    }

    window.walletController = new AbortController();
    let {signal} = window.walletController;

    if (linkWallet) {
        linkWallet.addEventListener('click', async (event) => {
            if (event.target.closest('.link-wallet')) {
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
                Telegram.openTelegramLink(universalLink);

                window.tonConnect.onStatusChange(walletInfo => {
                    webSocketSendMessage({
                        'type': 'linkWallet',
                        'wallet': walletInfo
                    });
                });
            }
        }, {signal});
    }

    document.body.addEventListener('click', (event) => {
        if (event.target.closest('.wallet-disconnect')) {
            Telegram.showConfirm(data['warningDisconnectWallet'], (ok) => {
                if (ok) {
                    webSocketSendMessage({
                        'type': 'disconnectWallet'
                    });
                }
            });
        } else if (event.target.closest('.balance-withdraw.active')) {
            webSocketSendMessage({
                'type': 'withdrawBalance'
            });
        }
    }, {signal});
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
        console.log("Wallet connected:", walletInfo);
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

function linkWallet(data) {
    webSocketSendMessage({
        'type': 'getPage',
        'page': 'wallet'
    });
}

function withdrawBalance(data) {
    if (data.status) {
        Telegram.showAlert(data.message);
        webSocketSendMessage({
            'type': 'getPage',
            'page': 'wallet'
        });
    } else {
        Telegram.showAlert(data.message);
    }
}

function airdrops(data) {
    lottie.loadAnimation({
        container: document.querySelector('.crypto-coins'),
        renderer: 'canvas',
        loop: true,
        autoplay: true,
        animationData: window.cryptoCoinsLottie,
        prerender: true,
        rendererSettings: {
            progressiveLoad: true
        }
    });

    let airdrops = document.querySelectorAll('.airdrop');
    if (airdrops) {
        airdrops.forEach(airdrop => {
            airdrop.addEventListener('click', (event) => {
                let element = event.target.closest('.airdrop');
                if (element) {
                    let id = element.dataset.id;
                    webSocketSendMessage({
                        'type': 'getPage',
                        'page': 'airdrop',
                        'id': id
                    });
                }

                Telegram.BackButton.show();
                Telegram.BackButton.onClick(async function () {
                    HapticFeedback.impactOccurred('medium');
                    Telegram.BackButton.hide();

                    webSocketSendMessage({
                        'type': 'getPage',
                        'page': 'airdrops'
                    });
                });
            });
        });
    }

    const targetDate = new Date(data.date).getTime();
    startCountdown(targetDate, 'timer');

    if (typeof (data.mainButton) !== 'undefined' && typeof (data.mainButton.url) !== 'undefined') {
        document.querySelector('.airdrop-invite-participants').addEventListener('click', () => {
            Telegram.openTelegramLink(data.mainButton.url);
        });
    }
}

function dice(data) {
    lottie.loadAnimation({
        container: document.querySelector('.dice'),
        renderer: 'canvas',
        loop: true,
        autoplay: true,
        animationData: window.diceLottie,
        prerender: true,
        rendererSettings: {
            progressiveLoad: true
        }
    });
}

function drawCompleted(data) {
    let appBody = document.querySelector('div.app-body');
    let dice = document.querySelector('.dice');
    if (appBody && dice) {
        appBody.innerHTML = data.html;
        confetti();
    }
}