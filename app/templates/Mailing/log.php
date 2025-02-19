<?php
if (!isset($log)) echo "<h6 class='text-center'>" . __('Log not found') . "</h6>";
else { ?>
    <table class="table table-responsive table-striped table-hover">
        <thead>
        <tr>
            <th><?= __('user id') ?></th>
            <th><?= __('result') ?></th>
            <th><?= __('description') ?></th>
        </tr>
        </thead>
		<?php foreach ($log ?? [] as $id => $l): ?>
            <tr>
	            <td>
		            <a href="/users/details/<?= $id ?>"><?= $l['result']['chat']['username'] ?? $id ?></a>
	            </td>
	            <td>
		            <?= $l['ok'] ? '<i class="icon-check-1"></i>' : '<i class="icon-cancel"></i>' ?>
	            </td>
	            <td>
		            <?= $l['description'] ?? '' ?>
	            </td>
            </tr>
		<?php endforeach; ?>
    </table>
<?php } ?>

<script>
	$('table').dataTable({
        pageLength: 100
	});
</script>
