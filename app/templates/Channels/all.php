<form action="/channels/all" method="GET" class="mb-5">
    <div class="mb-3">
        <select name="draw-id" id="draw-id" class="form-select">
            <option value=""><?= __('all') ?></option>
            <?php foreach ($draws ?? [] as $draw): ?>
                <option value="<?= $draw['id'] ?>" <?= ($draw['id'] == ($drawId ?? 0) ? 'selected' : '') ?>><?= $draw['title'][getCurrentLang()] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('Ok') ?>" class="btn">
    </div>
</form>
<table class="table table-hover table-striped table-responsive">
    <thead>
    <tr>
        <th><?= __('title') ?></th>
        <th><?= __('url') ?></th>
        <th><?= __('language') ?></th>
        <th><?= __('draw') ?></th>
        <th class="table-actions"><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($channels ?? [] as $channel): ?>
        <tr>
            <td><?= $channel->title ?></td>
            <td><?= $channel->url ?></td>
            <td><?= LANGUAGES[$channel->language]['title'] ?></td>
            <td><?= $draws[$channel->draw_id]['title'][getCurrentLang()] ?? '-' ?></td>
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