<form action="/mailing/addSave" method="POST" enctype="multipart/form-data">
	<div class="mb-3">
	    <label for="language" class="form-label">* <?= __('language') ?>:</label>
	    <select name="language" id="language" class="form-select">
		    <?php foreach(LANGUAGES as $language): ?>
			    <option value="<?= $language['abbr'] ?>"><?= $language['title'] ?></option>
		    <?php endforeach; ?>
	    </select>
    </div>
	<div class="mb-3">
        <label for="text" class="form-label">* <?= __('text message') ?>:</label>
        <textarea name="text" id="text" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label"><?= __('image') ?>:</label>
        <input type="file" name="image" class="form-control" id="image">
    </div>
    <div class="mb-3">
        <label for="image-url"><?= __('or') ?></label>
        <input type="text" name="imageUrl" class="form-control" id="image-url"
               placeholder="<?= __('image url') ?>">
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('add') ?>" class="btn add">
    </div>
</form>