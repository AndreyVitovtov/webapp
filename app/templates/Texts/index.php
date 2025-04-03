<div class="mb-3 text-dark">
    <b>\n - <?= __('line break') ?></b>
</div>
<form id="textForm">
    <input type="hidden" name="lang" value="<?= $lang ?>">
	<?php foreach ($texts as $key => $value): ?>
        <div class="mb-3">
            <label for="" class="form-label"><?= $key ?>:</label>
            <input type="text" name="<?= $key ?>" class="form-control" value="<?= $value ?>">
        </div>
	<?php endforeach; ?>
    <input type="submit" value="Save" class="btn">
</form>