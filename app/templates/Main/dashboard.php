<div class="row">
    <div class="col-md-6">
        <canvas id="number-new-users"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="number-active-users"></canvas>
    </div>
</div>

<script>
    window.titles = {
        'number_registration': '<?= __('number registration') ?>',
        'number_active': '<?= __('number active') ?>',
        'active': '<?= __('active users') ?>',
        'no_active': '<?= __('no active users') ?>'
    };
    window.numberRegistrations = <?= json_encode($numberRegistrations ?? []) ?>;
    window.activeUsers = <?= json_encode($activeUsers ?? [], JSON_UNESCAPED_UNICODE) ?>;
</script>