<form action="/participants" method="GET" class="mb-5">
    <div class="mb-3">
        <select name="draw-id" class="form-select">
            <option value="0"><?= __('select draw') ?></option>
			<?php foreach ($draws ?? [] as $draw): ?>
                <option value="<?= $draw->id ?>" <?= ($drawId == $draw->id ? 'selected' : '') ?>><?= $draw->title->{getCurrentLang()} ?></option>
			<?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('Ok') ?>" class="btn">
    </div>
</form>


<?php if (!empty($participants)): ?>
    <table class="table table-striped table-hover table-responsive">
        <thead>
        <tr>
            <th><?= __('username') ?></th>
            <th><?= __('active') ?></th>
            <th><?= __('added') ?></th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ($participants as $participant):
            $username = $participant['username'];
            if(empty($username)) $username = $participant['first_name'] . ' ' . $participant['last_name'];
        ?>
            <tr>
                <td>
                    <a href="/users/details/<?= $participant['id'] ?>"><?= $username ?></a>
                </td>
                <td data-order="<?= $participant['active'] ? 1 : 0 ?>">
                    <i class="<?= ($participant['active'] ? 'icon-check-1' : 'icon-cancel') ?>">
                </td>
                <td>
                    <?= $participant['date'] ?>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>