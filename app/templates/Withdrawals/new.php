<style>
    .wallet-address {
        display: flex;
        align-items: center;
        justify-content: start;
    }

    .wallet-address > div {
        margin-left: 10px;
    }

    .withdrawals-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    td {
	    vertical-align: middle;
    }
</style>

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th><?= __('username') ?></th>
        <th><?= __('amount') ?></th>
        <th><?= __('wallet') ?></th>
        <th class="text-center"><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($newWithdrawals ?? [] as $newWithdrawal):
		$username = $newWithdrawal->user->username;
		if (empty($username)) $username = $newWithdrawal->user->first_name . ' ' . $newWithdrawal->user->last_name;
		?>
        <tr>
            <td><a href="/users/details/<?= $newWithdrawal->user->id ?>"><?= $username ?></a></td>
            <td><?= $newWithdrawal->balance ?></td>
            <td>
                <div class="wallet-address">
					<?= $newWithdrawal->wallet ?>
                    <div class="btn copy-link" data-address="<?= $newWithdrawal->wallet ?>"
                         data-message="<?= __('copied') ?>"><i class="icon-docs"></i>
                    </div>
                </div>
            </td>
            <td>
                <div class="withdrawals-actions">
                    <div class="withdrawals-paid btn btn-actions" data-id="<?= $newWithdrawal->id ?>"
                         data-status="PAID"><?= __('paid') ?></div>
                    <div class="withdrawals-paid btn btn-danger btn-actions" data-id="<?= $newWithdrawal->id ?>"
                         data-status="<?= __('CANCELED') ?>"><?= __('cancel') ?></div>
                </div>
            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>