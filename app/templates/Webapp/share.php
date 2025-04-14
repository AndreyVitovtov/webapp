<style>
    .app-content {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        height: auto;
        background-color: #141417;
    }

    .coefficient-earned {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .coefficient, .earned {
        width: calc(50% - 5px);
        border-radius: 10px;
        padding: 5px 10px;
        border: solid 1px;
    }

    .coefficient > div, .earned > div {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .earned > div > img {
        margin-left: 10px;
        width: 20px;
        height: 20px;
    }

    .coefficient div:nth-child(2), .earned div:nth-child(2) {
        color: #737373;
        font-size: 12px;
    }

    .coefficient {
        border-color: #FE9400;
        color: #FE9400;
    }

    .earned {
        border-color: #00D4FF;
        color: #00D4FF;
    }

    .title-share, .description-share, .share-attention {
        text-align: center;
        color: #fff;
    }

    .title-share {
        margin-top: 15px;
        font-size: 20px;
    }

    .description-share {
        font-size: 14px;
    }

    .share-attention {
        font-size: 12px;
        color: #737373;
        position: relative;
        margin-top: -15px;
    }

    .invite-users-wrapper {
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

    .invite-users {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to right, #CE6A00 0%, #FF9500 100%);
        color: #fff;
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
    }

    .copy-link {
        padding: 10px;
        background: #FF9500;
        border-radius: 10px;
        margin-left: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .referrals {
        padding: 10px 0;
        color: #fff;
        margin-top: 15px;
    }

    .referral:not(:last-child) {
        border-bottom: 2px solid #0E0E12;
    }

    .referral {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 10px 0;
    }

    .referral-img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-right: 10px;
    }

    .referral-wrapper {
        display: flex;
        align-items: center;
    }

    .referral-active-no-active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .referral-active, .referral-no-active {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        margin-left: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .referral-active {
        background-color: #00AD00;
    }

    .referral-no-active {
        background-color: #AD0E00;
    }
</style>

<div class="coefficient-earned">
    <div class="coefficient">
        <div><?= $coefficient ?></div>
        <div>
            <?= __('winning coefficient', [], $user->language_code) ?>
        </div>
    </div>
    <div class="earned">
        <div>
            <?= $earned ?>
            <img src="<?= assets('images/index/ton.svg') ?>" alt="ton">
        </div>
        <div>
            <?= __('earned from referrals', [], $user->language_code) ?>
        </div>
    </div>
</div>
<h3 class="title-share"><?= __('title share', [], $user->language_code) ?></h3>
<p class="description-share">
    <?= __('description share', [
        'percent' => settings('percentage_referrer', 50)
    ], $user->language_code) ?>
</p>
<div class="share-attention">
    <?= __('share-attention', [], $user->language_code) ?>
</div>

<div class="referrals">
    <?php foreach($referrals ?? [] as $referral): ?>
        <div class="referral">
            <div class="referral-wrapper">
                <div class="referral-img" style="background-image: url(<?= $referral->photo_url ?>)"></div>
                <div class="referral-username"><?= $referral->username ?></div>
            </div>
            <div class="referral-active-no-active">
                <?= ($referral->active == 1 ? __('active') : __('no active')) ?>
                <div class="referral-<?= ($referral->active == 1 ? 'active' : 'no-active') ?>"></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="invite-users-wrapper">
    <div class="invite-users">
        <?= __('invite participants', [], $user->language_code) ?>
    </div>
    <div class="copy-link">
        <img src="<?= assets('images/index/copy.svg') ?>" alt="copy">
    </div>
</div>