<table class="table table-hover table-responsive table-striped">
    <thead>
    <tr>
        <th><?= __('username') ?></th>
        <th><?= __('chat id') ?></th>
        <th><?= __('active') ?></th>
        <th><?= __('referrals') ?></th>
        <th><?= __('added') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users ?? [] as $user): ?>
        <tr class="table-users" data-id="<?= $user->id ?>">
            <td><?= $user->username ?></td>
            <td><?= $user->chat_id ?></td>
            <td><?= ($user->active ? '<i class="icon-check-1"></i>' : '<i class="icon-cancel"></i>') ?></td>
            <td><?= $user->referrals ?></td>
            <td><?= $user->added ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>