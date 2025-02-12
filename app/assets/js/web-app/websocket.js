const WEB_SOCKET_URL = 'wss://web-app.vytovtov.pro:2346';

document.addEventListener( 'DOMContentLoaded', function () {

    webSocketInit(() => {
        auth();
    }, (data) => {
        requestHandler(data);
    });

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

    function webSocketSendMessage(data) {
        if (webSocket && webSocket.readyState === WebSocket.OPEN) {
            if(userToken) data.token = userToken;
            webSocket.send(JSON.stringify(data));
        } else {
            console.log('WebSocket is not open.');
        }
    }

    function auth() {
        webSocketSendMessage({
            type: 'auth',
            data: {
                initData: INIT_DATA,
                user: User
            }
        });
    }

    function requestHandler(data) {
        if(data.sc) {
            if(data.type === 'auth') {
                userToken = data.token;
                webSocketSendMessage({
                    'type': 'getPage',
                    'page': 'index'
                });
            } else {
                switch (data.type) {
                    case 'page':
                        page(data);
                        break;
                }
            }
        } else {
            console.error(data);
        }
    }
});
