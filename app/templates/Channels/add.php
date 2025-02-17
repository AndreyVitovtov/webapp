<form action="/channels/addSave" method="POST">
    <div class="mb-3">
        <label for="draw" class="form-label">* <?= __('draw') ?>:</label>
        <select name="draw" id="type" class="form-select">
            <?php foreach ($draws ?? [] as $draw): ?>
                <option value="<?= $draw->id ?>"><?= $draw->title->{getCurrentLang()} ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">* <?= __('title') ?>:</label>
        <input type="text" name="title" class="form-control" id="title" required>
    </div>
    <div class="mb-3">
        <label for="url" class="form-label">* <?= __('url') ?>:</label>
        <input type="text" name="url" class="form-control" id="url" required placeholder="https://t.me/...">
    </div>
    <div class="mb-3">
        <label for="chat_id" class="form-label">* <?= __('chat id') ?>:
            <a href="https://t.me/username_to_id_bot" target="_blank" class="link-primary">
                <i class="icon-info-circled"></i></a></label>
        <input type="text" name="chat_id" class="form-control" id="chat_id" required>
    </div>
    <div class="mb-3">
        <label for="language" class="form-label"><?= __('language') ?>:</label>
        <select name="language" id="language" class="form-select">
            <?php foreach (LANGUAGES as $language): ?>
                <option value="<?= $language['abbr'] ?>"><?= $language['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('add') ?>" class="btn">
    </div>
</form>