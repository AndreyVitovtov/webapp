<table class="table table-draws table-striped table-hover table-responsive">
    <thead>
    <tr>
        <th><?= __('title') ?></th>
        <th><?= __('date') ?></th>
        <th><?= __('active') ?></th>
        <th><?= __('prize') ?></th>
        <th><?= __('status') ?></th>
        <th><?= __('link') ?></th>
        <th><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($draws ?? [] as $draw): ?>
        <tr>
            <td><?= $draw->title->{getCurrentLang()} ?></td>
            <td><?= $draw->date ?></td>
            <td><?= ($draw->active ? '<i class="icon-check-1"></i>' : '<i class="icon-cancel"></i>') ?></td>
            <td><?= $draw->prize ?></td>
            <td><?= ($draw->active ? __($draw->status) : '') ?></td>
            <td>
                <div class="btn copy-link" data-link="<?= $draw->link ?>" data-message="<?= __('link for draw copied', [
                    'link' => $draw->link
                ]) ?>"><i class="icon-docs"></i></div>
            </td>
            <td class="table-actions">
                <a href="/draws/edit/<?= $draw->id ?>" class="btn">
                    <i class="icon-edit"></i>
                    <span class="desk"><?= __('edit') ?></span>
                </a>
                <button form="delete-draw-<?= $draw->id ?>" class="btn">
                    <i class="icon-trash"></i>
                    <span class="desk"><?= __('delete') ?></span>
                </button>
                <form action="/draws/delete" method="POST"
                      class="form-confirm"
                      id="delete-draw-<?= $draw->id ?>"
                      data-title="<?= __('deletion confirmation') ?>"
                      data-body="<?= __('are you sure you want to remove the draw') ?>"
                      data-id="delete-draw-<?= $draw->id ?>"
                >
                    <input type="hidden" name="id" value="<?= $draw->id ?>">
                </form>
            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>