<style>
    html, body {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none;
        font-family: SF Pro, sans-serif;
    }

    ::-webkit-scrollbar {
        display: none;
    }

    .app-content {
        padding: 20px;
    }

    .hello {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .app-menu {
        display: none;
        background-color: #1E1E1E;
        position: fixed;
        align-items: center;
        justify-content: space-between;
        bottom: 0;
        left: 0;
        width: 100%;
    }

    .app-menu-item {
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: 400;
        font-size: 12px;
        line-height: 14px;
        padding: 20px 20px 35px 20px;
        cursor: pointer;
    }

    .app-menu-item img {
        margin-bottom: 5px;
    }
</style>

<div>
    <div class="app-content">
        <div class="hello">
			<?= $content ?? 'no content' ?>
        </div>
    </div>
    <div class="app-menu">
        <div class="app-menu-item" data-page="index">
            <img src="<?= assets('images/menu/draw.svg') ?>" alt="draw">
			<?= __('draw', [], $languageCode ?? DEFAULT_LANG) ?>
        </div>
        <div class="app-menu-item" data-page="share">
            <img src="<?= assets('images/menu/share.svg') ?>" alt="referrals">
			<?= __('share', [], $languageCode ?? DEFAULT_LANG) ?>
        </div>
        <div class="app-menu-item" data-page="airdrops">
            <img src="<?= assets('images/menu/airdrop.svg') ?>" alt="profile">
			<?= __('air drop', [], $languageCode ?? DEFAULT_LANG) ?>
        </div>
        <div class="app-menu-item" data-page="wallet">
            <img src="<?= assets('images/menu/wallet.svg') ?>" alt="profile">
			<?= __('wallet', [], $languageCode ?? DEFAULT_LANG) ?>
        </div>
    </div>
</div>

<script>
    window.cryptoCoinsLottie = <?= file_get_contents(assets('lottie/crypto-coins.json')) ?>;
    window.starsLottie = <?= file_get_contents(assets('lottie/stars.json')) ?>;
    window.diceLottie = <?= file_get_contents(assets('lottie/dice.json')) ?>;
    //window.confettiLottie = <?php //= file_get_contents(assets('lottie/confetti.json')) ?>//;
    window.trophyLottie = <?= file_get_contents(assets('lottie/trophy.json')) ?>;
    localStorage.setItem('page', 'index');
</script>
