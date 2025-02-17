<table class="table table-hover table-striped table-responsive">
    <thead>
    <tr>
        <th><?= __('title') ?></th>
        <th><?= __('url') ?></th>
        <th><?= __('chat_id') ?></th>
        <th><?= __('language') ?></th>
        <th class="table-actions"><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($channels ?? [] as $channel): ?>
        <tr>
            <td><?= $channel->title ?></td>
            <td><?= $channel->url ?></td>
            <td><?= $channel->chat_id ?></td>
            <td><?= LANGUAGES[$channel->language]['title'] ?></td>
            <td class="table-actions">
                <a href="/channels/edit/<?= $channel->id ?>" class="btn">
                    <i class="icon-edit"></i>
                    <span class="desk"><?= __('edit') ?></span>
                </a>
                <button form="delete-channel-<?= $channel->id ?>" class="btn">
                    <i class="icon-trash"></i>
                    <span class="desk"><?= __('delete') ?></span>
                </button>
                <form action="/channels/delete" method="POST"
                      class="form-confirm"
                      id="delete-channel-<?= $channel->id ?>"
                      data-title="<?= __('deletion confirmation') ?>"
                      data-body="<?= __('are you sure you want to remove the channel') ?>"
                      data-id="delete-channel-<?= $channel->id ?>"
                >
                    <input type="hidden" name="id" value="<?= $channel->id ?>">
                </form>
            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>