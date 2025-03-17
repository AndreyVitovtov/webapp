<style>
    .text-right {
        text-align: end!important;
    }
</style>

<table class="table table-hover table-responsive table-striped">
    <thead>
    <tr>
        <th><?= __('username') ?></th>
        <th><?= __('chat id') ?></th>
        <th><?= __('active') ?></th>
        <th><?= __('referrals') ?></th>
        <th><?= __('added') ?></th>
        <th class="text-right"><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users ?? [] as $user):
        $userName = $user->username;
    ?>
        <tr class="table-users" data-id="<?= $user->id ?>">
            <td><?= (empty($userName) ? ($user->first_name . ' ' . $user->last_name) : $user->username) ?></td>
            <td><?= $user->chat_id ?></td>
            <td><?= ($user->active ? '<i class="icon-check-1"></i>' : '<i class="icon-cancel"></i>') ?></td>
            <td><?= $user->referrals ?></td>
            <td><?= $user->added ?></td>
            <td class="table-actions text-right">
                <button form="delete-user-<?= $user->id ?>" class="btn">
                    <i class="icon-trash"></i>
                    <span class="desk"><?= __('delete') ?></span>
                </button>
                <form action="/users/delete" method="POST"
                      class="form-confirm"
                      id="delete-user-<?= $user->id ?>"
                      data-title="<?= __('deletion confirmation') ?>"
                      data-body="<?= __('are you sure you want to remove the user') ?>"
                      data-id="delete-user-<?= $user->id ?>"
                >
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>