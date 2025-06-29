<div class="user-photo">
    <img src="<?= $user->photo_url ?? '' ?>" alt="">
</div>
<table class="table mb-5">
    <tr>
        <td><?= __('username') ?>:</td>
        <td><?php $userName = $user->username; ?> <?= empty($userName) ? '-' : '<a href="https://t.me/' . ($user->username ?? "") . '" target="_blank">@' . ($user->username ?? '') . '</a>' ?></td>
    </tr>
    <tr>
        <td><?= __('first name') ?>:</td>
        <td><?= $user->first_name ?? '' ?></td>
    </tr>
    <tr>
        <td><?= __('last name') ?>:</td>
        <td><?= $user->last_name ?? '' ?></td>
    </tr>
    <tr>
        <td><?= __('chat id') ?>:</td>
        <td><?= $user->chat_id ?? '' ?></td>
    </tr>
    <tr>
        <td><?= __('language') ?>:</td>
        <td><?= LANGUAGES[$user->language_code]['title'] ?? $user->language_code ?></td>
    </tr>
    <tr>
        <td><?= __('active') ?>:</td>
        <td><?= ($user->active ? '<i class="icon-check-1"></i>' : '<i class="icon-cancel"></i>') ?></td>
    </tr>
    <tr>
        <td><?= __('added') ?>:</td>
        <td><?= $user->added ?></td>
    </tr>
    <tr>
        <td><?= __('referrer') ?>:</td>
        <td><?= (!empty($user->referrer['username']) ? '<a href="/users/details/' . $user->referrer['id'] . '">' . $user->referrer['username'] . '</a>' : '-') ?></td>
    </tr>
    <tr>
        <td><?= __('coefficient') ?>:</td>
        <td><?= (!empty($coefficientAdmin) ? $coefficientAdmin : ($coefficient ?? settings('coefficient'))) ?></td>
    </tr>
    <tr>
        <td><?= __('balance') ?>:</td>
        <td><?= ($user->balance->balance ?? 0) ?></td>
    </tr>
    <tr>
        <td><?= __('wallet') ?></td>
        <td><?= $user->wallet->address ?? '-' ?></td>
    </tr>
</table>
<h6><?= __('coefficient') ?></h6>
<form action="/users/addCoefficient" method="POST" class="mb-4">
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <div class="mb-2">
        <input type="number" step="0.01" name="coefficient"
               value="<?= !empty($coefficientAdmin) ? $coefficientAdmin : '' ?>"
               class="form-control">
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>
<h6><?= __('send message') ?></h6>
<form action="/users/sendMessage" method="POST">
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <div class="mb-2">
        <textarea name="text" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('send') ?>" class="btn">
    </div>
</form>
<h6><?= __('write off from balance') ?></h6>
<form action="/users/writeOffFromBalance" method="POST">
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <div class="mb-2">
        <input type="number" name="amount" step="any" required class="form-control">
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('write off') ?>" class="btn">
    </div>
</form>
<h6 class="mt-3"><?= __('subscribe to channels') ?></h6>
<table class="table table-striped table-bordered table-responsive table-hover">
    <thead>
    <tr>
        <th><?= __('channel') ?></th>
        <th><?= __('subscribe') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($subscribeChannels ?? [] as $channel): ?>
        <tr>
            <td><a href="<?= $channel['url'] ?>" target="_blank"><?= $channel['title'] ?></a></td>
            <td><i class="icon-<?= $channel['subscribe'] ? 'check-1' : 'cancel' ?>"></i></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>