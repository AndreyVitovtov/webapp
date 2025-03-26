<style>
    td {
        vertical-align: middle;
    }

    .table-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        width: auto;
    }
</style>

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th><?= __('username') ?></th>
        <th><?= __('amount') ?></th>
        <th><?= __('wallet') ?></th>
        <th><?= __('status') ?></th>
        <th>
            <div class="table-actions">
				<?= __('actions') ?>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($withdrawals ?? [] as $withdrawal):
		$username = $withdrawal->user->username;
		if (empty($username)) $username = $withdrawal->user->first_name . ' ' . $withdrawal->user->last_name;
		?>

        <tr>
            <td><?= $username ?></td>
            <td><?= $withdrawal->balance ?></td>
            <td><?= $withdrawal->wallet ?></td>
            <td><?= __($withdrawal->status) ?></td>
            <td>
                <div class="table-actions">
                    <button form="delete-withdrawals-<?= $withdrawal->id ?>" class="btn">
                        <i class="icon-trash"></i>
                        <span class="desk"><?= __('delete') ?></span>
                    </button>
                    <form action="/withdrawals/delete" method="POST"
                          class="form-confirm"
                          id="delete-withdrawals-<?= $withdrawal->id ?>"
                          data-title="<?= __('deletion confirmation') ?>"
                          data-body="<?= __('are you sure you want to remove the withdrawal') ?>"
                          data-id="delete-withdrawals-<?= $withdrawal->id ?>"
                    >
                        <input type="hidden" name="id" value="<?= $withdrawal->id ?>">
                    </form>
                </div>
            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>