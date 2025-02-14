<style>
    .content {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: auto;
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
</style>

<div>
    <div class="content">
        <?= $content ?? 'no content' ?>
    </div>
    <div class="app-menu">
        <div class="app-menu-item" data-page="index">Item 1</div>
        <div class="app-menu-item" data-page="index2">Item 2</div>
        <div class="app-menu-item" data-page="index3">Item 3</div>
    </div>
</div>
