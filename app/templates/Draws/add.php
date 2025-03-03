<form action="/draws/addSave" method="POST">
	<?php foreach (LANGUAGES as $abbr => $language): ?>
        <div class="mb-3">
            <label for="title-<?= $abbr ?>" class="form-label">* <?= __('title') ?> (<?= $language['title'] ?>):</label>
            <input type="text" name="title[<?= $abbr ?>]" class="form-control" id="title-<?= $abbr ?>" required>
        </div>
        <div class="mb-3">
            <label for="description-<?= $abbr ?>" class="form-label">* <?= __('description') ?>
                (<?= $language['title'] ?>):</label>
            <textarea name="description[<?= $abbr ?>]" id="description-<?= $abbr ?>" class="form-control"
                      required></textarea>
        </div>
        <div class="mb-3">
            <label for="conditions-<?= $abbr ?>" class="form-label">* <?= __('conditions of the draw') ?> (<?= $language['title'] ?>
                ):</label>
            <textarea name="conditions[<?= $abbr ?>]" id="conditions-<?= $abbr ?>" class="form-control" required></textarea>
        </div>
	<?php endforeach; ?>
    <div class="mb-3">
        <label for="sponsor-title" class="form-label">* <?= __('sponsor title') ?>:</label>
        <input type="text" name="sponsor_title" class="form-control" id="sponsor-title" required>
    </div>
    <div class="mb-3">
        <label for="sponsor-url" class="form-label">* <?= __('sponsor url') ?>:</label>
        <input type="text" name="sponsor_url" class="form-control" id="sponsor-url" required>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">* <?= __('date') ?>:</label>
        <input type="datetime-local" class="form-control" name="date" id="date" required>
    </div>
    <div class="mb-3">
        <label for="active" class="form-check-label"><?= __('active') ?>:</label>
        <input type="checkbox" name="active" value="1" id="active" class="form-check-input">
    </div>
    <div class="mb-3">
        <label for="prize" class="form-label">* <?= __('prize') ?></label>
        <input type="number" name="prize" class="form-control" id="prize" required>
    </div>
    <div class="mb-3">
        <label for="winners" class="form-label">* <?= __('number of winners') ?>:</label>
        <input type="number" step="1" class="form-control" name="winners" id="winners" required>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('add') ?>" class="btn">
    </div>
</form>