<table class="table table-hover table-striped table-responsive">
    <thead>
    <tr>
        <th><?= __('language') ?></th>
        <th><?= __('text') ?></th>
        <th><?= __('image') ?></th>
        <th><?= __('added') ?></th>
        <th><?= __('start') ?></th>
        <th><?= __('completed') ?></th>
        <th><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($mailing ?? [] as $mail): ?>
        <tr>
            <td><?= LANGUAGES[$mail['language']]['title'] ?></td>
            <td><?= nl2br($mail['text']) ?></td>
            <td>
				<?= !empty($mail['image']) ? '<a href="' . $mail['image'] . '" target="_blank" class="btn"><i class="icon-picture"></i></a>' : '' ?>
            </td>
            <td><?= $mail['added'] ?></td>
            <td><?= $mail['start'] ?></td>
            <td><?= $mail['completed'] ?></td>
            <td class="table-actions">
                <a href="/mailing/log/<?= $mail['id'] ?>" class="btn">
                    <i class="icon-doc-text"></i>
                    <span class="desk"><?= __('log') ?></span>
                </a>
                <button form="delete-mailing-<?= $mail['id'] ?>" class="btn">
                    <i class="icon-trash"></i>
                    <span class="desk"><?= __('delete') ?></span>
                </button>
                <form action="/mailing/delete" method="POST"
                      class="form-confirm"
                      id="delete-mailing-<?= $mail['id'] ?>"
                      data-title="<?= __('deletion confirmation') ?>"
                      data-body="<?= __('are you sure you want to remove the mailing') ?>"
                      data-id="delete-mailing-<?= $mail['id'] ?>"
                >
                    <input type="hidden" name="id" value="<?= $mail['id'] ?>">
                </form>


            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>