<div class="mb-3 text-danger">
    <b><?= __('bot admin') ?></b>
</div>
<form action="/channels/editSave" method="POST">
    <input type="hidden" name="id" value="<?= $channel->id ?? 0 ?>">
    <div class="mb-3">
        <label for="draw" class="form-label">* <?= __('draw') ?>:</label>
        <select name="draw" id="type" class="form-select">
			<?php foreach ($draws ?? [] as $draw): ?>
                <option value="<?= $draw->id ?>" <?= (($channel->draw_id ?? '') == $draw->id ? 'selected' : '') ?>><?= $draw->title->{getCurrentLang()} ?></option>
			<?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">* <?= __('title') ?>:</label>
        <input type="text" name="title" value="<?= $channel->title ?? '' ?>" class="form-control" id="title" required>
    </div>
    <div class="mb-3">
        <label for="url" class="form-label">* <?= __('url') ?>:</label>
        <input type="text" name="url" value="<?= $channel->url ?? '' ?>" class="form-control" id="url" required
               placeholder="https://t.me/...">
    </div>
    <div class="mb-3">
        <label for="chat_id" class="form-label">* <?= __('chat id') ?>:
            <a href="https://t.me/username_to_id_bot" target="_blank" class="link-primary">
                <i class="icon-info-circled"></i></a></label>
        <input type="text" name="chat_id" value="<?= $channel->chat_id ?? '' ?>" class="form-control" id="chat_id"
               required>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">* <?= __('type') ?>:</label>
        <select name="type" class="form-select" id="type" required>
            <option value="channel" <?= $channel->type == 'channel' ? 'selected' : '' ?>><?= __('channel') ?></option>
            <option value="group" <?= $channel->type == 'group' ? 'selected' : '' ?>><?= __('group') ?></option>
        </select>
    </div>
    <div class="mb-3">
        <label for="language" class="form-label"><?= __('language') ?>:</label>
        <select name="language" id="language" class="form-select">
			<?php foreach (LANGUAGES as $abbr => $language): ?>
                <option value="<?= $language['abbr'] ?>" <?= ($abbr === $channel->language ?? '') ? 'selected' : '' ?>><?= $language['title'] ?></option>
			<?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>