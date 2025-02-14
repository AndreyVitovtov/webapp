const DEV = false;
const DESKTOP_FORBIDDEN = true;
const HEADER_COLOR = '#000000';
const BG_COLOR = '#000000';


let Telegram, HapticFeedback, WebAppInitData, User, INIT_DATA, userToken = null;

document.addEventListener('DOMContentLoaded', () => {
    Telegram = window.Telegram.WebApp;
    HapticFeedback = Telegram.HapticFeedback;
    WebAppInitData = Telegram.initDataUnsafe;
    User = WebAppInitData.user;
    INIT_DATA = Telegram.initData;

    Telegram.disableVerticalSwipes();
    Telegram.setBackgroundColor(BG_COLOR);
    Telegram.setHeaderColor(HEADER_COLOR);

    Telegram.SettingsButton.isVisible = true;

    // Telegram.onEvent('settingsButtonClicked', async () => {
    //     Telegram.BackButton.show();
    // })


    document.body.addEventListener('click', (event) => {
        let element = event.target;
        if (element.className === 'app-menu-item') {
            let page = event.target.getAttribute('data-page');
            webSocketSendMessage({
                'type': 'getPage',
                'page': page
            });
        }
    });


});