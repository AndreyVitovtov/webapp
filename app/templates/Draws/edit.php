<form action="/draws/editSave" method="POST">
    <input type="hidden" name="id" value="<?= $draw->id ?? 0 ?>">
	<?php foreach (LANGUAGES as $abbr => $language): ?>
        <div class="mb-3">
            <label for="title-<?= $abbr ?>" class="form-label">* <?= __('title') ?> (<?= $language['title'] ?>):</label>
            <input type="text" name="title[<?= $abbr ?>]" value="<?= $draw->title->{$abbr} ?? '' ?>"
                   class="form-control" id="title-<?= $abbr ?>"
                   required>
        </div>
        <div class="mb-3">
            <label for="description-<?= $abbr ?>" class="form-label">* <?= __('description') ?>
                (<?= $language['title'] ?>):</label>
            <textarea name="description[<?= $abbr ?>]" id="description-<?= $abbr ?>" class="form-control"
                      required><?= $draw->description->{$abbr} ?? '' ?></textarea>
        </div>
	<?php endforeach; ?>
    <div class="mb-3">
        <label for="date" class="form-label">* <?= __('date') ?>:</label>
        <input type="datetime-local" class="form-control" name="date" value="<?= $draw->date ?? '' ?>" id="date"
               required>
    </div>
    <div class="mb-3">
        <label for="active" class="form-check-label"><?= __('active') ?>:</label>
        <input type="checkbox" name="active" value="1" id="active"
               class="form-check-input" <?= (($draw->active ?? 0) ? 'checked' : '') ?>>
    </div>
    <div class="mb-3">
        <label for="prize" class="form-label">* <?= __('prize') ?></label>
        <input type="number" name="prize" value="<?= $draw->prize ?? '' ?>" class="form-control" id="prize" required>
    </div>
    <div class="mb-3">
        <label for="winners" class="form-label"><?= __('number of winners') ?>:</label>
        <input type="number" value="<?= $draw->winners ?? 1 ?>" step="1" class="form-control" name="winners"
               id="winners">
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>