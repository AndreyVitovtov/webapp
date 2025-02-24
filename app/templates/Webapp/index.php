<style>
    .app-header {
        height: 49vh;
        background-color: #262626;
    }

    .timer {
        height: 100%;
        display: flex;
        font-size: 1.3rem;
        gap: 3px;
        align-items: end;
        color: #fff;
        justify-content: center;
        padding-bottom: 50px;
    }

    .timer .block-group {
        display: flex;
        gap: 3px;
    }

    .timer .block {
        background: #222023;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 45px;
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

    html, body {
        height: 100vh;
        margin: 0;
        padding: 0;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none; /* Для Firefox */
    }

    .app-body {
        padding: 20px;
    }

    ::-webkit-scrollbar {
        display: none; /* Для Chrome, Safari */
    }


</style>
<?php
//    $startParam = explode('_', $startParam ?? '');
?>
<?php //= $startParam[1] ?? 'no param' ?>
<?php if (!empty($winners)):
    foreach ($winners as $winner): ?>
        <?= $winner['username'] ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="app-header">
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
    </div>

    <div class="app-body">

    </div>
<?php endif; ?>