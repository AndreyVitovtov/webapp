<form id="textForm">
    <input type="hidden" name="lang" value="<?= $lang ?>">
	<?php foreach ($texts as $key => $value): ?>
        <div class="mb-3">
            <label for="" class="form-label"><?= $key ?>:</label>
            <textarea name="<?= $key ?>" id="" class="form-control"><?= $value ?></textarea>
<!--            <input type="text" name="--><?php //= $key ?><!--" class="form-control" value="--><?php //= $value ?><!--">-->
        </div>
	<?php endforeach; ?>
    <input type="submit" value="Save" class="btn">
</form>