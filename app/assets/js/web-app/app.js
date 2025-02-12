const DEV = false;
const DESKTOP_FORBIDDEN = true;
const HEADER_COLOR = '#1B1412';
const BG_COLOR = '#261b18';


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
});