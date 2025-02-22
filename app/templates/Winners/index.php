<form action="/winners" method="POST" class="mb-5">
    <div class="mb-3">
        <select name="draw-id" id="draw-id" class="form-select">
            <option value=""><?= __('select a draw') ?></option>
            <?php foreach ($draws as $draw): ?>
                <option value="<?= $draw->id ?>" <?= ($draw->id == ($drawId ?? 0) ? 'selected' : '') ?>><?= $draw->title->{getCurrentLang()} ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('Ok') ?>" class="btn">
    </div>
</form>
<?php if (!empty($winners)): ?>
    <table class="table table-striped table-responsive table-hover">
        <thead>
        <tr>
            <th><?= __('username') ?></th>
            <th><?= __('prize') ?></th>
            <th><?= __('referrer') ?></th>
            <th><?= __('paid out') ?></th>
            <th><?= __('date') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($winners as $winner): ?>
            <tr>
                <td><a href="/users/details/<?= $winner['userId'] ?>"><?= $winner['username'] ?></a></td>
                <td><?= $winner['prize'] ?> <?= (!empty($winner['referrerId']) ? ' (-' . settings('percentage_referrer') . '%)' : '') ?></td>
                <td><?= (!empty($winner['referrerUsername']) ? '<a href="/users/details/' . $winner['referrerId'] . '">' . $winner['referrerUsername'] . '</a>' : null) ?? '-' ?></td>
                <td><?= ($winner['paid_out'] ? '<i class="icon-check-1"></i>' : '<i class="icon-cancel"></i>') ?></td>
                <td><?= $winner['updated'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>