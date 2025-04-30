const DEV = false;
const DESKTOP_FORBIDDEN = true;
const HEADER_COLOR = '#141417';
const BG_COLOR = '#1E1E1E';
const APP_URL = 'https://t.me/WebAppFBot/app';
const TON_CONNECT_MANIFEST = 'https://web-app.vytovtov.pro/tonconnect-manifest.json';
const ERROR_GET_CONTENT = 'There were problems loading content. Check your connection, restart the app and try again \n\nRestart now?';


let Telegram, HapticFeedback, WebAppInitData, User, INIT_DATA, userToken = null;

document.addEventListener('DOMContentLoaded', () => {
    Telegram = window.Telegram.WebApp;
    HapticFeedback = Telegram.HapticFeedback;
    WebAppInitData = Telegram.initDataUnsafe;
    User = WebAppInitData.user;
    INIT_DATA = Telegram.initData;

    if(!Telegram.isExpanded) Telegram.expand();
    Telegram.disableVerticalSwipes();
    Telegram.setBackgroundColor(BG_COLOR);

    // Telegram.setHeaderColor(HEADER_COLOR);
    // Telegram.SettingsButton.isVisible = true;
    // console.log(Telegram.initDataUnsafe);

    Telegram.setHeaderColor(HEADER_COLOR);

    document.body.addEventListener('click', (event) => {
        let element = event.target.closest('.app-menu-item');
        if (element) {
            let page = element.getAttribute('data-page');
            if(page !== 'airdrop') Telegram.BackButton.hide();
            webSocketSendMessage({
                'type': 'getPage',
                'page': page
            });
        }
    });
});