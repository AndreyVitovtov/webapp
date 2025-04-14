<style>
    .editor {
        border: 1px solid #ced4da;
        min-height: 200px;
        padding: 10px;
        border-radius: .375rem;
        background-color: #fff;
    }

    .editor:focus {
        outline: none;
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>

<form action="/airdrop/editSave" method="POST" enctype="multipart/form-data" id="form-add-airdrop"
      onsubmit="prepareSubmit(); return true;">
    <input type="hidden" name="id" value="<?= $airdrop->id ?>">
    <div class="mb-3">
        <label for="title" class="form-label">* <?= __('title') ?>:</label>
        <input type="text" name="title" value="<?= $airdrop->title ?>" class="form-control" id="title" required>
    </div>
    <div class="mb-3">
        <label for="logo" class="form-label"><?= __('logo') ?>:</label>
        <input type="file" name="logo" class="form-control" id="logo">
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">* <?= __('date') ?>:</label>
        <input type="datetime-local" name="date" value="<?= $airdrop->date ?>" class="form-control" id="date" required>
    </div>
    <div class="mb-3">
        <label for="total" class="form-label">* <?= __('total') ?>:</label>
        <input type="number" name="total" value="<?= $airdrop->total ?>" class="form-control" id="total" required>
    </div>
    <div class="mb-3">
        <label for="per-user" class="form-label">* <?= __('per user') ?>:</label>
        <input type="number" name="per_user" value="<?= $airdrop->per_user ?>" class="form-control" id="per-user"
               required>
    </div>
    <div class="mb-3">
        <label for="max-winners" class="form-label">* <?= __('max winners') ?>:</label>
        <input type="number" name="max_winners" value="<?= $airdrop->max_winners ?>" class="form-control"
               id="max-winners" required>
    </div>
    <div class="mb-3">
        <label for="channel-draw" class="form-label">* <?= __('channel draw') ?>:</label>
        <input type="text" name="channel_draw" value="<?= $airdrop->channel_draw ?>" class="form-control"
               id="channel-draw" required>
    </div>
    <div class="mb-3">
        <label for="channel-project-draw" class="form-label">* <?= __('channel project draw') ?>:</label>
        <input type="text" name="channel_project_draw" value="<?= $airdrop->channel_project_draw ?>"
               class="form-control" id="channel-project-draw" required>
    </div>
    <div class="mb-3">
        <label for="group-project-draw" class="form-label">* <?= __('group project draw') ?>:</label>
        <input type="text" name="group_project_draw" value="<?= $airdrop->group_project_draw ?>" class="form-control"
               id="group-project-draw" required>
    </div>

	<?php foreach (LANGUAGES as $key => $language): ?>
        <div class="mb-3">
            <label for="description_<?= $key ?>" class="form-label">* <?= __('description') ?>
                (<?= $language['title'] ?>):</label>
            <div class="btn-toolbar mb-2" role="toolbar">
                <div class="btn-group me-2" role="group">
                    <button type="button" class="btn btn-outline-secondary" onclick="execCmd('bold')"><b>B</b></button>
                    <button type="button" class="btn btn-outline-secondary" onclick="execCmd('italic')"><i>I</i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="execCmd('underline')"><u>U</u>
                    </button>
                </div>
                <button type="button" class="btn btn-outline-primary"
                        onclick="addLink()"><?= __('insert link') ?></button>
            </div>

            <div id="editor_<?= $key ?>" contenteditable="true"
                 class="editor mb-3"><?= $airdrop->description->$key ?></div>

            <input type="hidden" name="description_<?= $key ?>" id="description_<?= $key ?>">
        </div>
	<?php endforeach; ?>


    <div class="mb-3">
        <label for="active" class="form-check-label"><?= __('active') ?>:</label>
        <input type="checkbox" name="active" value="1" id="active"
               class="form-check-input" <?= $airdrop->active ? 'checked' : '' ?>>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>

<script>
    function execCmd(cmd) {
        document.execCommand(cmd, false, null);
    }

    function addLink() {
        const url = prompt("<?= __('link') ?>:");
        const text = prompt("<?= __('text') ?>:");
        if (url && text) {
            const linkHtml = `<a href="${url}" target="_blank">${text}</a>`;
            document.execCommand('insertHTML', false, linkHtml);
        }
    }

    function prepareSubmit() {
		<?php foreach(LANGUAGES as $key => $language): ?>
        document.getElementById('description_<?= $key ?>').value = document.getElementById('editor_<?= $key ?>').innerHTML;
		<?php endforeach; ?>
    }
</script>