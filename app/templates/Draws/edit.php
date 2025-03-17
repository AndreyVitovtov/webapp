<style>
    .table {
        width: 100%;
    }

    label:hover {
        cursor: pointer;
    }
</style>
<script>
    window.username = '<?= __('username') ?>';
</script>

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
        <label for="select-winners-btn"><?= __('winners') ?>:</label>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#selectWinnersModal"
                id="select-winners-btn">
			<?= __('select') ?>
        </button>
        <br>
        <br>
        <div class="winners">
			<?php if (!empty($winnersDraw)): ?>
                <table class="table table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?= __('username') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ($winnersDraw as $winner): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected-winners[]" value="<?= $winner['id'] ?>" checked>
                            </td>
                            <td>
								<?= (empty($winner['username']) ? ($winner['first_name'] . ' ' . $winner['last_name']) : $winner['username']) ?>
                            </td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
			<?php endif; ?>
        </div>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>

<div class="modal fade" id="selectWinnersModal" tabindex="-1" aria-labelledby="selectWinnersModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectWinnersModalLabel"><?= __('select winners') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="<?= __('close') ?>"></button>
            </div>
            <div class="modal-body">
                <table class="table table-winners table-responsive table-hover table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?= __('username') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ($users ?? [] as $user):
						$userName = $user->username;
						?>
                        <tr>
                            <td>
                                <input type="checkbox" name="userIds[]" value="<?= $user->id ?>"
                                       id="user-<?= $user->id ?>" data-id="<?= $user->id ?>"
                                       data-name="<?= (empty($userName) ? ($user->first_name . ' ' . $user->last_name) : $user->username) ?>">
                            </td>
                            <td>
                                <label for="user-<?= $user->id ?>"><?= (empty($userName) ? ($user->first_name . ' ' . $user->last_name) : $user->username) ?></label>
                            </td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= __('close') ?></button>
                <button type="button" class="btn btn-secondary"><?= __('save') ?></button>
            </div>
        </div>
    </div>
</div>