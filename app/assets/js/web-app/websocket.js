const WEB_SOCKET_URL = 'wss://web-app.vytovtov.pro:2346';

function webSocketSendMessage(data) {
    if (webSocket && webSocket.readyState === WebSocket.OPEN) {
        if (userToken) data.token = userToken;
        webSocket.send(JSON.stringify(data));
    } else {
        console.log('WebSocket is not open.');
    }
}

function webSocketInit(onOpenCallback = () => {
    console.log('WebSocket connection opened');
}, onMessageCallback = (data) => {
    console.log(data);
}) {
    webSocket = new WebSocket(WEB_SOCKET_URL);

    webSocket.onopen = function () {
        onOpenCallback();
    };

    webSocket.onclose = function () {
        console.log('WebSocket connection closed.');
        sessionStorage.setItem('websocketStatus', 'closed');

        setTimeout(() => {
            console.log('Reconnecting WebSocket...');
            webSocketInit(onOpenCallback, onMessageCallback);
        }, 1000);
    };

    webSocket.onerror = function (error) {
        if (!(error.isTrusted ?? false)) {
            Telegram.showConfirm(ERROR_GET_CONTENT, (res) => {
                if (res) window.location.reload();
            });
        }
        console.error('WebSocket error: ' + JSON.stringify(error));
    };

    webSocket.onmessage = function (event) {
        let data = JSON.parse(event.data);
        onMessageCallback(data);
    };

    return webSocket;
}

function auth() {
    webSocketSendMessage({
        type: 'auth',
        data: {
            initData: INIT_DATA,
            user: User
        },
        params: WebAppInitData['start_param'] ?? null
    });
}

function requestHandler(data) {
    if (data.sc) {
        if (data.type === 'auth') {
            let startParams = parseParams(WebAppInitData['start_param'] ?? '');
            userToken = data.token;
            setTimeout(() => {
                webSocketSendMessage({
                    'type': 'getPage',
                    'page': startParams.page ?? 'index',
                    'params': WebAppInitData['start_param'] ?? null
                });
            }, 1000);
        } else {
            switch (data.type) {
                case 'page':
                    page(data);
                    break;
            }
        }
    } else {
        console.error(data);
        Telegram.showConfirm(ERROR_GET_CONTENT, (res) => {
            if (res) window.location.reload();
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    webSocketInit(() => {
        auth();
    }, (data) => {
        requestHandler(data);
    });
});
