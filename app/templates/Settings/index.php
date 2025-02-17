<form action="/settings/save" method="POST">
	<?php foreach ($settings ?? [] as $setting): ?>
        <div class="mb-3">
            <label for="<?= $setting->key ?>" class="form-label"><?= __($setting->key) ?>:</label>
			<?php if ($setting->type === 'textarea'): ?>
                <textarea class="form-control" id="<?= $setting->key ?>"
                          name="<?= $setting->key ?>"><?= $setting->value ?></textarea>
			<?php else: ?>
                <input type="<?= $setting->type ?>" name="<?= $setting->key ?>" value="<?= $setting->value ?>"
                       class="form-control" id="<?= $setting->key ?>">
			<?php endif; ?>
        </div>
	<?php endforeach; ?>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>