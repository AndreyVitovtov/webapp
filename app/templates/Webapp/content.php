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
        flex-direction: column;
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

    .hello {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        background-image: url("<?= assets('images/index/image_loading_web_app.jpg') ?>");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
    }
</style>

<div>
    <div class="app-content">
        <div class="hello">
            <div class="dice"></div>
            <div>
				<?= $content ?? 'no content' ?>
            </div>
        </div>
    </div>
    <div class="app-menu">
        <div class="app-menu-item" data-page="index">
            <img src="<?= assets('images/menu/draw.svg') ?>" alt="draw">
			<?= __('draw', [], DEFAULT_LANG) ?>
        </div>
        <div class="app-menu-item" data-page="share">
            <img src="<?= assets('images/menu/share.svg') ?>" alt="referrals">
			<?= __('share', [], DEFAULT_LANG) ?>
        </div>
        <div class="app-menu-item" data-page="airdrops">
            <img src="<?= assets('images/menu/airdrop.svg') ?>" alt="profile">
			<?= __('air drop', [], DEFAULT_LANG) ?>
        </div>
        <div class="app-menu-item" data-page="wallet">
            <img src="<?= assets('images/menu/wallet.svg') ?>" alt="profile">
			<?= __('wallet', [], DEFAULT_LANG) ?>
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
</script>
