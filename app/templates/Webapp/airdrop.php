<style>
    .app-content {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        height: auto;
        background-color: #0A0A0C;
    }

    .airdrop {
        margin-bottom: 100px;
    }

    .airdrop-head {
        display: flex;
        align-items: start;
        justify-content: space-between;
        padding: 10px;
    }

    .airdrop-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin-top: 15px;
        background: #1B1B1E;
        padding: 6px;
        border-radius: 12px;
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

    .airdrop-image img {
        width: 94px;
        height: 94px;
    }

    .airdrop-info {
        background-color: #1B1B1E;
        margin-top: 12px;
        border-radius: 12px;
        padding: 6px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .airdrop-symbol-net, .airdrop-distribution-invite {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 2px;
    }

    .airdrop-symbol, .airdrop-net, .airdrop-distribution, .airdrop-invite {
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: start;
        width: calc(50% - 5px);
        padding: 8px 10px;
        height: 100%;
        background: #262629;
        color: #FFFFFF66;
        font-size: 10px;
        border-radius: 11px;
        margin-bottom: 10px;
    }

    .airdrop-drop {
        font-family: 'Zen Dots', sans-serif;
        color: #D47000;
        font-size: 12px;
        font-optical-sizing: auto;
        font-style: normal;
        font-variation-settings: "wdth" 100;
    }

    .airdrop-ton {
        font-size: 14px;
        font-weight: 510;
        color: #fff;
    }

    .airdrop-spend-win {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: calc(100% - 5px);
        font-size: 10px;
        background: #262629;
        color: #FFFFFF66;
        border-radius: 11px;
        padding: 8px 10px;
        margin-bottom: 10px;
    }

    .airdrop-spend-win > div {
        width: calc(100% / 3);
    }

    .airdrop-spend-win > div:nth-child(2) {
        text-align: center;
    }

    .airdrop-spend-win > div > div:nth-child(2), .airdrop-distribution > div:nth-child(2), .airdrop-invite > div:nth-child(2) {
        font-size: 14px;
        color: #fff;
    }

    .airdrop-smart-contract-address {
        background: #262629;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: calc(100% - 5px);
        padding: 8px 10px;
        border-radius: 11px;
        margin-bottom: 2px;
    }

    .airdrop-smart-contract-address > div:nth-child(1) {
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: start;
        color: #FFFFFF66;
        font-size: 10px;
        width: calc(100% - 30px);
    }

    .airdrop-smart-contract-address > div:nth-child(1) > div:nth-child(2) {
        color: #fff;
        font-size: 14px;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .airdrop-channel-drop {
        background-color: #1B1B1E;
        margin-top: 12px;
        border-radius: 12px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .airdrop-channel-drop img {
        width: 24px;
        height: 24px;
    }

    .airdrop-tasks {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .airdrop-tasks > div:nth-child(1), .airdrop-description > div:nth-child(1) {
        width: 100%;
        color: #fff;
        font-size: 14px;
        text-align: left;
        margin-top: 15px;
    }

    .airdrop-task-button {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        background: #262629;
        color: #fff;
        font-size: 16px;
        margin-top: 10px;
    }

    .airdrop-task-button > div:nth-child(1), .airdrop-task-button > div:nth-child(3) {
        width: 30px;
    }

    .airdrop-task-button > div:nth-child(3) {
        text-align: right;
    }

    .airdrop-task-button > div:nth-child(2) {
        width: calc(100% - 60px);
        padding-left: 5px;
    }

    .airdrop-description > div:nth-child(2) {
        width: 100%;
        color: #fff;
        font-size: 14px;
        text-align: justify;
        padding: 10px;
    }

    .airdrop-invite-participants {
        width: 100%;
        text-align: center;
        color: #fff;
        font-size: 16px;
        margin-top: 15px;
        padding: 12px;
        border-radius: 10px;
        background: linear-gradient(#CE6A00 0%, #FF9500 100%);
    }
</style>

<div class="airdrop">
    <div class="airdrop-head">
        <div class="airdrop-status"><?= __('Закончен') ?></div>
        <div class="airdrop-image">
            <img src="<?= assets('images/airdrops/gallery.svg') ?>" alt="airdrop image">
        </div>
        <div class="airdrop-lottery"><?= __('Лотерея') ?></div>
    </div>
    <div class="text-center">
		<?= __('Airdrop') ?>
    </div>
    <div class="text-center">Airdrop</div>
    <div class="timer text-center">
        00:00:00
    </div>
    <div class="airdrop-foot">
        <div class="airdrop-total">
            <div class="airdrop-foot-label">Total</div>
            <div class="airdrop-foot-value">
                1 M DROP
            </div>
        </div>
        <div class="airdrop-per-user">
            <div class="airdrop-foot-label">Per user</div>
            <div class="airdrop-foot-value">
                50 DROP
            </div>
        </div>
        <div class="airdrop-max-winners">
            <div class="airdrop-foot-label">Max Winners</div>
            <div class="airdrop-foot-value">
                20000
            </div>
        </div>
    </div>
    <div class="airdrop-info">
        <div class="airdrop-symbol-net">
            <div class="airdrop-symbol">
                <div>
					<?= __('Символ') ?>
                </div>
                <div class="airdrop-drop">
                    DROP
                </div>
            </div>
            <div class="airdrop-net">
                <div>
					<?= __('Сеть') ?>
                </div>
                <div class="airdrop-ton">
                    TON
                </div>
            </div>
        </div>
        <div class="airdrop-spend-win">
            <div class="airdrop-spend">
                <div>Вы тратите</div>
                <div>15K Points</div>
            </div>
            <div>
                <img src="<?= assets('images/airdrops/arrows.svg') ?>" alt="">
            </div>
            <div class="airdrop-win">
                <div>Вы можете выиграть</div>
                <div>150 <span class="airdrop-drop">DROP</span></div>
            </div>
        </div>
        <div class="airdrop-distribution-invite">
            <div class="airdrop-distribution">
                <div>Общее распределение</div>
                <div>500 <span class="airdrop-drop">DROP</span></div>
            </div>
            <div class="airdrop-invite">
                <div>Пригласить друзей</div>
                <div>3</div>
            </div>
        </div>
        <div class="airdrop-smart-contract-address">
            <div>
                <div>
					<?= __('Smart contract Адрес') ?>
                </div>
                <div>
                    0x582d872alb094fc48f5de3ld3b73f2dlb094fc48f5de3l
                </div>
            </div>
            <div>
                <img src="<?= assets('images/airdrops/copy.svg') ?>" alt="copy">
            </div>
        </div>
    </div>
    <div class="airdrop-channel-drop">
        <img src="<?= assets('images/airdrops/telegram-logo.svg') ?>" alt="telegram logo">
    </div>
    <div class="airdrop-tasks">
        <div><?= __('Задания') ?></div>
        <div class="airdrop-task-button">
            <div>
                <img src="<?= assets('images/airdrops/telegram-logo.svg') ?>" alt="telegram logo">
            </div>
            <div><?= __('Подписка на канал спонсора') ?></div>
            <div>
                <i class="icon-right-open-big"></i>
            </div>
        </div>
        <div class="airdrop-task-button">
            <div>
                <img src="<?= assets('images/airdrops/telegram-logo.svg') ?>" alt="telegram logo">
            </div>
            <div><?= __('Подписка на группу спонсора') ?></div>
            <div>
                <i class="icon-right-open-big"></i>
            </div>
        </div>
    </div>
    <div class="airdrop-description">
        <div><?= __('Описание') ?></div>
        <div>
            <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A at cumque dolor doloribus ducimus error
                eveniet hic illo molestias nobis nostrum nulla quae quidem, quos repudiandae similique vitae! Quo,
                reprehenderit.
            </div>
            <div>Consectetur esse eum incidunt pariatur quam sunt tempora veritatis! Earum necessitatibus quae vel
                voluptatum. Culpa est officia similique totam unde! Harum odio, voluptatem. Ab doloribus laborum magni
                maxime provident ullam!
            </div>
            <div>Aliquam amet animi asperiores aspernatur, aut consequatur culpa deserunt ducimus error hic in iure
                laboriosam magni natus optio placeat possimus provident quaerat quasi quidem recusandae sapiente,
                tempora unde velit veniam!
            </div>
            <div>Alias aspernatur aut autem commodi cum dolorem dolorum eos, fugit illum in ipsam, nemo nesciunt nihil
                odio officiis, quo ratione repellendus saepe suscipit tempora tenetur ullam vel veniam voluptatibus
                voluptatum.
            </div>
            <div>Consequatur delectus distinctio dolore dolorum fuga fugiat harum illo ipsa itaque laudantium magnam
                neque nesciunt, nisi nostrum possimus qui quis repellendus repudiandae saepe sed similique tempora vero
                vitae voluptatem voluptatum?
            </div>
        </div>
    </div>
    <div class="airdrop-invite-participants">
        <?= __('invite participants') ?>...
    </div>
</div>