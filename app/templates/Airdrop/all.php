<table class="table table-hover table-striped table-responsive">
    <thead>
    <tr>
        <th><?= __('title') ?></th>
        <th><?= __('date') ?></th>
        <th><?= __('status') ?></th>
        <th><?= __('active') ?></th>
        <th class="table-actions"><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($airdrops ?? [] as $airdrop): ?>
        <tr>
            <td><?= $airdrop->title ?></td>
            <td><?= $airdrop->date ?></td>
            <td><?= __($airdrop->status) ?></td>
	        <td><?= ($airdrop->active ? '<i class="icon-check-1"></i>' : '<i class="icon-cancel"></i>') ?></td>
	        <td class="table-actions text-right">
		        <a href="/airdrop/edit/<?= $airdrop->id ?>" class="btn">
			        <i class="icon-edit"></i>
			        <span class="desk"><?= __('edit') ?></span>
		        </a>
		        <button form="delete-airdrop-<?= $airdrop->id ?>" class="btn">
			        <i class="icon-trash"></i>
			        <span class="desk"><?= __('delete') ?></span>
		        </button>
		        <form action="/airdrop/delete" method="POST"
		              class="form-confirm"
		              id="delete-airdrop-<?= $airdrop->id ?>"
		              data-title="<?= __('deletion confirmation') ?>"
		              data-body="<?= __('are you sure you want to remove the airdrop') ?>"
		              data-id="delete-airdrop-<?= $airdrop->id ?>"
		        >
			        <input type="hidden" name="id" value="<?= $airdrop->id ?>">
		        </form>
	        </td>
        </tr>
	<?php endforeach ?>
    </tbody>
</table>