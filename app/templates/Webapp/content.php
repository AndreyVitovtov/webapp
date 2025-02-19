<style>
    body {
        margin: 0;
        padding: 0;
    }

    .content {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 100vh;
        padding: 0;
    }

    .content-wrapper {
        display: flex;
        width: 200%;
        transition: transform 0.5s ease-in-out;
    }

    .old-content, .new-content {
        width: 50%;
        flex-shrink: 0;
    }

    .hidden {
        display: none;
    }

    .old-content, .new-content {
        width: 50%;
        flex-shrink: 0;
    }

    .app-menu {
        display: flex;
        align-items: center;
        justify-content: space-around;
        position: fixed;
        bottom: 20px;
        left: 0;
        right: 0;
    }

    .app-menu > div {
        padding: 5px;
        cursor: pointer;
    }




    /* Стили для меню */
    .app-menu {
        display: flex;
        justify-content: space-around;
        background-color: #333;
        padding: 10px 0;
        border-radius: 5px;
    }

    .app-menu-item {
        color: #fff;
        font-size: 16px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        border-radius: 5px;
    }

    /* Стиль для активного элемента */
    .app-menu-item.active {
        background-color: #4CAF50; /* зеленый для активного */
        color: #fff;
        font-weight: bold;
    }

    /* Эффект при наведении */
    .app-menu-item:hover {
        background-color: #575757;
    }


    .app-menu {
        /*display: none;*/
    }


    .hello {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
</style>

<div>
    <div class="app-content">
        <div class="hello">
            <?= $content ?? 'no content' ?>
        </div>
    </div>
    <div class="app-menu">
        <div class="app-menu-item" data-page="index"><?= __('draw') ?></div>
        <div class="app-menu-item" data-page="profile"><?= __('profile') ?></div>
        <div class="app-menu-item" data-page="referrals"><?= __('referrals') ?></div>
    </div>
</div>
