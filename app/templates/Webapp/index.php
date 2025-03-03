<style>
    .app-content {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        height: auto;
        background-color: #141417;
    }

    .app-body {
        margin-bottom: 190px;
    }

    .timer {
        display: flex;
        font-size: 15px;
        align-items: center;
        color: #fff;
        justify-content: center;
        padding-bottom: 15px;
        margin-top: -25px;
        position: relative;
    }

    .timer .block-group {
        display: flex;
        gap: 3px;
    }

    .timer .block {
        background: #222023;
        padding: 5px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 30px;
        /*height: 45px;*/
    }

    .timer .block:nth-child(1) {
        border-radius: 8px 2px 2px 8px;
    }

    .timer .block:nth-child(2) {
        border-radius: 2px 8px 8px 2px;
    }

    .timer .separator {
        padding: 10px 5px;
        font-weight: bold;
    }

    .timer .hidden {
        display: none;
    }

    .bg-header {
        margin-top: 15px;
        height: 160px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        z-index: 1;
    }

    .bg-header-circle {
        background: linear-gradient(to bottom, #006195 0%, #00D4FF 100%);
        height: 95px;
        width: 95px;
        border-radius: 50%;
        position: absolute;
        z-index: 2;
        top: 93px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 0 10px 8px rgba(0, 212, 255, 0.1), 0 0 70px 60px #0B0B0D;
    }

    .bg-header-cubes {
        height: 110px;
        width: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        position: absolute;
        z-index: 3;
        top: 89px;
        left: 50%;
        transform: translateX(-50%);
    }

    .prize-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .prize {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 24px;
        font-weight: 400;
        background-color: #1A1A20;
        color: #fff;
        padding: 5px 20px;
        border-radius: 25px;
        z-index: 4;
    }

    .prize::after {
        content: "";
        position: absolute;
        bottom: -19px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 10px;
        border-style: solid;
        border-color: #1A1A20 transparent transparent transparent;
    }

    .prize img {
        margin-left: 5px;
    }

    .participant {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        color: #fff;
    }

    .participant:not(:last-child) {
        border-bottom: 2px solid #0E0E12;
    }

    .participant-img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-right: 10px;
    }

    .participant-wrapper {
        display: flex;
        align-items: center;
    }

    .draw-title-wrapper, .draw-description-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .draw-title {
        max-width: 60%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 17px;
        font-weight: bold;
        color: #fff;
        padding: 10px 0;
        position: relative;
        top: -40px;
        text-align: center;
        z-index: 4;
    }

    .draw-description {
        max-width: 60%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
        font-weight: normal;
        color: #fff;
        position: relative;
        top: -40px;
        text-align: center;
        z-index: 4;
    }

    .conditions-draw {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: normal;
        color: #737373;
        text-align: center;
    }

    .sponsor-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sponsor {
        display: inline-block;
        font-size: 15px;
        font-weight: normal;
        padding: 5px 10px;
        border-radius: 10px;
        background: linear-gradient(to right, #CE6A00 0%, #FF9500 100%);
        color: #fff;
        margin-top: 10px;
    }

    .sponsor a {
        color: #fff;
        text-decoration: none;
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
    }

    .subscribe-to-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: fixed;
        bottom: 160px;
        width: 100%;
        left: 0;
        right: 0;
        padding: 0 20px;
        z-index: 4;
    }

    .subscribe-to {
        color: #fff;
        background-color: #1A1A20;
        display: flex;
        align-content: center;
        justify-content: center;
        padding: 10px;
        border-radius: 10px;
        width: calc(50% - 5px);
        font-size: 12px;
    }

    .subscribe-to img {
        margin-left: 10px;
    }

</style>
<div class="app-header">
    <div class="prize-wrapper">
        <div class="prize">
            <div>
				<?= str_replace(',', '.', number_format($draw['prize'] ?? 0)); ?>
            </div>
            <img src="<?= assets('images/index/ton.svg') ?>" alt="ton">
        </div>
    </div>
    <div class="bg-header" style="background-image: url(<?= assets('images/index/bg-header.svg') ?>);"></div>
    <div class="bg-header-circle"></div>
    <div class="bg-header-cubes" style="background-image: url(<?= assets('images/index/cubes.png') ?>);"></div>
    <div class="draw-title-wrapper">
        <div class="draw-title">
			<?= $draw['title'] ?>
        </div>
    </div>
    <div class="draw-description-wrapper">
        <div class="draw-description">
			<?= $draw['description'] ?>
        </div>
    </div>
    <div class="timer" id="timer">
        <div class="block-group days-container">
            <div class="block days-tens">0</div>
            <div class="block days-units">0</div>
        </div>
        <div class="separator days-separator">:</div>
        <div class="block-group">
            <div class="block hours-tens">0</div>
            <div class="block hours-units">0</div>
        </div>
        <div class="separator">:</div>
        <div class="block-group">
            <div class="block minutes-tens">0</div>
            <div class="block minutes-units">0</div>
        </div>
        <div class="separator">:</div>
        <div class="block-group">
            <div class="block seconds-tens">0</div>
            <div class="block seconds-units">0</div>
        </div>
    </div>

    <div class="conditions-draw">
		<?= $draw['conditions'] ?? 'Условия розыгрыша' ?>
    </div>
    <div class="sponsor-wrapper">
        <div class="sponsor">
            <a href="<?= $draw['sponsor_url'] ?>"
               target="_blank"><?= __('sponsor', [], $user->language_code) ?> <?= $draw['sponsor_title'] ?></a>
        </div>
    </div>
</div>

<div class="app-body">
	<?php foreach ($participants ?? [] as $participant): ?>
        <div class="participant">
            <div class="participant-wrapper">
                <div class="participant-img" style="background-image: url(<?= $participant->photo_url ?>)"></div>
                <div class="participant-username"><?= $participant->username ?></div>
            </div>
            <div class="participant-coefficient"><?= $participant->coefficient ?> <?= __('coeff', [], $user->language_code) ?></div>
        </div>
	<?php endforeach; ?>
</div>

<div class="subscribe-to-wrapper">
	<?php
	$subscribe = true;
	foreach ($channels ?? [] as $key => $channel):
		if (!$channel->subscribe) $subscribe = false;
		if ($key > 1) break;
		?>
        <div class="subscribe-to" data-channel="<?= $channel->url ?>">
			<?= __('subscribe to', [
				'type' => mb_strtolower($channel->type == 'channel' ? __('channel') : __('group_'))
			], $user->language_code) ?>
            <img src="<?= assets('images/index/' . ($channel->subscribe ? 'check-ok' : 'check-cancel') . '.svg') ?>"
                 class="subscribe-to-image" alt="subscribe" data-id="<?= $channel->id ?>">
        </div>
	<?php endforeach; ?>
</div>

<div class="invite-users-wrapper">
    <div class="invite-users" id="<?= $subscribe ? 'invite-users' : 'check-subscribe' ?>">
		<?= __($subscribe ? 'invite participants' : 'check subscribe app', [], $user->language_code) ?>
    </div>
</div>