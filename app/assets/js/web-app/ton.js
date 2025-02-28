document.addEventListener("DOMContentLoaded", () => {
    const tonConnectUI = new TON_CONNECT_UI.TonConnectUI({
        manifestUrl: 'https://web-app.vytovtov.pro/app/data/tonconnect-manifest.json',
        buttonRootId: 'ton-connect',
        twaReturnUrl: 'https://t.me/YOUR_APP_NAME'
    });
});