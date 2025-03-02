<?php
global $menu;
$menu = [
	[
		'title' => __('dashboard'),
		'icon' => 'chart-bar-1',
		'address' => '/',
		'controller' => 'Main'
	], [
		'title' => __('users'),
		'icon' => 'group',
		'address' => '/users',
		'controller' => 'Users'
	], [
		'title' => __('mailing'),
		'icon' => 'mail',
		'controller' => 'Mailing',
		'forbid' => ['guest'],
		'items' => [
			[
				'title' => __('add'),
				'address' => '/mailing/add',
				'method' => 'add'
			], [
				'title' => __('all'),
				'address' => '/mailing',
				'method' => 'index'
			]
		]
	], [
		'title' => __('airdrop'),
		'icon' => 'shuffle',
		'controller' => 'Airdrop',
		'forbid' => ['guest'],
		'items' => [
			[
				'title' => __('add'),
				'address' => '/airdrop/add',
				'method' => 'add'
			], [
				'title' => __('all'),
				'address' => '/airdrop/all',
				'method' => 'all'
			]
		]
	], [
		'title' => __('draws'),
		'icon' => 'diamond',
		'controller' => 'Draws',
		'forbid' => ['guest'],
		'items' => [
			[
				'title' => __('add'),
				'address' => '/draws/add',
				'method' => 'add'
			], [
				'title' => __('all'),
				'address' => '/draws/all',
				'method' => 'all'
			]
		]
	], [
		'title' => __('channels'),
		'icon' => 'megaphone',
		'controller' => 'Channels',
		'forbid' => ['guest'],
		'items' => [
			[
				'title' => __('add'),
				'address' => '/channels/add',
				'method' => 'add'
			], [
				'title' => __('all'),
				'address' => '/channels/all',
				'method' => 'all'
			]
		]
	], [
		'title' => __('winners'),
		'icon' => 'trophy',
		'address' => '/winners',
		'controller' => 'Winners'
	], [
		'title' => __('administrators'),
		'icon' => 'star',
		'address' => '/administrators',
		'controller' => 'Administrators',
		'assets' => ['superadmin']
	], [
		'title' => __('settings'),
		'icon' => 'cogs',
		'address' => '/settings',
		'controller' => 'Settings',
		'assets' => [],
		'forbid' => ['guest']
	]
];
?>

<div class="logo">
    <a href="/">
		<?= PROJECT_NAME ?>
    </a>
</div>
<div class="menu-items">
	<?= implode('', array_map(function ($i) {
		extract($i);
		return isset($items) ?
			menuRoll($title, $icon, $controller, $items, $access ?? [], $forbid ?? []) :
			menuItem($title, $icon, $address, $controller, $assets ?? [], $forbid ?? []);
	}, $menu)) ?>
</div>