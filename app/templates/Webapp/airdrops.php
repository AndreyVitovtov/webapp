<style>
    .app-content {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        height: auto;
        background-color: #0A0A0C;
    }

    .crypto-coins {
        height: 100px;
        width: 100%;
    }

    .airdrops-title {
        margin-top: 20px;
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        color: #fff;
    }

    .airdrops {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 25px;
        margin-bottom: 85px;
    }

    .airdrop {
        background-color: #141417;
        width: 100%;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 15px;
        margin-bottom: 10px;
    }

    .airdrop-image img {
        height: 70px;
        width: 70px;
        border-radius: 50%;
    }

    .airdrop-image {
        margin-right: 10px;
        height: 70px;
        width: 70px;
        border-radius: 50%;
        background: #4a4a4a;
    }

    .airdrop-head {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: left;
    }

    .airdrop-title {
        color: #fff;
        font-size: 16px;
    }

    .airdrop-drop {
        font-family: 'Zen Dots', sans-serif;
        color: #D47000;
        font-size: 12px;
        font-optical-sizing: auto;
        font-style: normal;
        font-variation-settings: "wdth" 100;
    }

    .airdrop-info {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .airdrop-info > div {
        margin-bottom: 5px;
    }

    .airdrop-info-bottom {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: left;
    }

    .airdrop-status, .airdrop-lottery {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 12px;
    }

    .airdrop-status {
        background-color: #363636;
        color: #fff;
    }

    .airdrop-lottery {
        background-color: #3E255180;
        color: #E18DFF;
        margin-left: 10px;
    }

    .airdrop-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin-top: 15px;
        background: #1B1B1E;
        padding: 5px;
        border-radius: 10px;
    }

    .airdrop-foot-label {
        font-size: 12px;
        color: #FFFFFF66
    }

    .airdrop-foot > div {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        width: calc(100% / 3);
    }

    .airdrop-foot > div:not(:last-child) {
        border-right: 1px solid #FFFFFF0D;;
    }

    .airdrop-foot-value {
        color: #fff;
        font-size: 16px;
        font-weight: 600;
    }
</style>

<div class="crypto-coins"></div>
<div class="airdrops-title"><?= __('airdrops', [], DEFAULT_LANG) ?></div>
<div class="airdrops">
	<?php foreach ($airdrops as $airdrop) : ?>
        <div class="airdrop" data-id="<?= $airdrop['id'] ?>">
            <div class="airdrop-head">
                <div class="airdrop-image">
                    <img src="<?= assets('images/airdrops/' . $airdrop['logo']) ?>" alt="airdrop-image">
                </div>
                <div class="airdrop-info">
                    <div class="airdrop-title"><?= $airdrop['title'] ?></div>
                    <div class="airdrop-drop">DROP</div>
                    <div class="airdrop-info-bottom">
                        <div class="airdrop-status"><?= __($airdrop['status'], [], DEFAULT_LANG) ?></div>
                        <div class="airdrop-lottery"><?= __('lottery', [], DEFAULT_LANG) ?></div>
                    </div>
                </div>
            </div>
            <div class="airdrop-foot">
                <div class="airdrop-total">
                    <div class="airdrop-foot-label"><?= __('total', [], DEFAULT_LANG) ?></div>
                    <div class="airdrop-foot-value">
                        <?= $airdrop['total'] ?>
                    </div>
                </div>
                <div class="airdrop-per-user">
                    <div class="airdrop-foot-label"><?= __('per user', [], DEFAULT_LANG) ?></div>
                    <div class="airdrop-foot-value">
                        <?= $airdrop['per_user'] ?>
                    </div>
                </div>
                <div class="airdrop-max-winners">
                    <div class="airdrop-foot-label"><?= __('max winners', [], DEFAULT_LANG) ?></div>
                    <div class="airdrop-foot-value">
                        <?= $airdrop['max_winners'] ?>
                    </div>
                </div>
            </div>
        </div>
	<?php endforeach; ?>
</div>