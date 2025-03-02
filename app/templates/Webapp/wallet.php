<style>
    .app-content {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        height: auto;
        background-color: #141417;
    }

    .app-content::before {
        content: "";
        position: absolute;
        top: -50px;
        left: 50%;
        width: 300px;
        height: 150px;
        background: rgba(48, 181, 253, 0.2);
        filter: blur(130px);
        transform: translateX(-50%);
        z-index: 0;
    }

    .wallet {
        height: 93vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .app-header {
        height: 70%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .app-body {
        height: 30%;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: space-around;
        margin-bottom: 140px;
    }

    .app-body h3 {
        color: #fff;
        font-size: 24px;
    }

    .app-wallet-attention {
        color: #fff;
        font-size: 14px;
        text-align: center;
        margin-bottom: 25px;
    }

    .link-wallet {
        width: 100%;
        background: linear-gradient(to right, #30B5FD 0%, #3258FF 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        padding: 10px;
        font-size: 16px;
        text-decoration: none;
        cursor: pointer;
    }

    .link-wallet img, .wallet-connected img {
        margin-right: 10px;
    }

    .wallet-connected-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        bottom: 105px;
        width: 100%;
        left: 0;
        right: 0;
        padding: 0 20px;
    }

    .wallet-connected {
        width: 100%;
        background: #1A1A20;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #A1A1A1;
        padding: 10px;
        font-size: 16px;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div class="wallet">
    <div class="app-header">
        <div class="image-ton">
            <img src="<?= assets('images/wallet/ton.svg') ?>" alt="ton">
            <div class="image-ton-shadow"></div>
        </div>
    </div>

    <div class="app-body">
        <h3><?= __('connect your wallet', [], $user->language_code) ?></h3>
        <div class="app-wallet-attention">
			<?= __('wallet-attention', [], $user->language_code) ?>
        </div>
    </div>
</div>

<div class="wallet-connected-wrapper">
	<?php $walletAddress = $wallet->address;
	if (!empty($walletAddress)): ?>
        <div class="wallet-connected">
            <img src="<?= assets('images/wallet/check.svg') ?>" alt="wallet">
            <div><?= __('wallet connected', [], $user->language_code) ?></div>
        </div>
	<?php else: ?>
        <div class="link-wallet">
            <img src="<?= assets('images/wallet/link-wallet.svg') ?>" alt="wallet">
            <div><?= __('link wallet', [], $user->language_code) ?></div>
        </div>
	<?php endif; ?>
</div>