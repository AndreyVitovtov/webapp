<style>
    .winner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        color: #fff;
    }

    .winner:not(:last-child) {
        border-bottom: 2px solid #0E0E12;
    }

    .winner-img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-right: 10px;
    }

    .winner-wrapper {
        display: flex;
        align-items: center;
    }

    .subscribe-to-wrapper, .invite-users-wrapper, .timer {
        display: none;
    }

    .confetti {
        width: 100%;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
    }
</style>

<div class="winners">
    <div class="draft-text">
		<?= __('winners', [], $user->language_code) ?>
    </div>
	<?php foreach ($winners ?? [] as $winner):
		$winner = (object)$winner;
		?>
        <div class="winner">
            <div class="winner-wrapper">
                <div class="winner-img" style="background-image: url(<?= $winner->photo_url ?>)"></div>
                <div class="winner-username"><?= $winner->username ?></div>
            </div>
            <div class="winner-prize">+ <?= $winner->prize ?> <?= __('', [], $user->language_code) ?></div>
        </div>
	<?php endforeach; ?>
</div>