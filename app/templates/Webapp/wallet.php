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
        justify-content: start;
        margin-top: 100px;
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

    .link-admin {
        color: #3258FF;
        text-decoration: none;
    }

    .link-wallet, .balance-withdraw.active {
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
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: fixed;
        bottom: 105px;
        width: 100%;
        left: 0;
        right: 0;
        padding: 0 20px;
    }

    .wallet-connected-wrapper > div:nth-child(2) {
        margin-top: 10px;
    }

    .wallet-connected, .balance-withdraw {
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

    .balance-block {
        min-width: 60%;
        border-radius: 10px;
        border: solid 1px #00D4FF;
        text-align: center;
        padding: 15px 10px;
    }

    .wallet-balance {
        color: #fff;
        font-size: 14px;
    }

    .balance-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .balance-wrapper img {
        width: 36px;
        height: 36px;
    }

    .balance {
        font-size: 32px;
        color: #fff;
        margin-right: 10px;
    }
</style>

<div class="wallet">
    <div class="balance-block">
        <span class="wallet-balance">
            <?= __('balance', [], DEFAULT_LANG) ?>
        </span>
        <div class="balance-wrapper">
            <div class="balance">
				<?= number_format($balance ?? 0, 2, ',', ' '); ?>
            </div>
            <img src="<?= assets('images/wallet/usdt.svg') ?>" alt="usdt">
        </div>
    </div>

	<?php $walletAddress = ($wallet->address ?? null);
	if (empty($walletAddress)): ?>
        <div class="app-body">
            <h3><?= __('connect your wallet', [], DEFAULT_LANG) ?></h3>
<!--            <div class="app-wallet-attention">-->
<!--				--><?php //= __('wallet-attention', [], DEFAULT_LANG) ?>
<!--            </div>-->
            <div class="app-wallet-attention">
				<?= __('payout via admin', [
                    'admin' => '<a href="' . settings('link_admin') . '" target="_blank" class="link-admin">' . __('admin', [], DEFAULT_LANG) . '</a>'
                ], DEFAULT_LANG) ?>
            </div>
        </div>
	<?php endif; ?>
</div>

<div class="wallet-connected-wrapper">
	<?php $walletAddress = ($wallet->address ?? null);
	if (!empty($walletAddress)): ?>
        <div class="balance-withdraw <?= (($balance ?? 0) > 0 ? 'active' : '') ?>">
            <div><?= __('withdraw', [], DEFAULT_LANG) ?></div>
        </div>
        <div class="wallet-connected wallet-disconnect">
            <div><?= __('wallet disconnect', [], DEFAULT_LANG) ?></div>
        </div>
	<?php else: ?>
        <div class="link-wallet">
            <img src="<?= assets('images/wallet/link-wallet.svg') ?>" alt="wallet">
            <div><?= __('link wallet', [], DEFAULT_LANG) ?></div>
        </div>
	<?php endif; ?>
</div>