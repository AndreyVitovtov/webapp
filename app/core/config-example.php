<?php

const DEV = true;

const BASE_URL = '';
const DEFAULT_LANG = 'en';
const TIMEZONE = 'UTC';

const ABSOLUTE_PATH = '/var/www/app/';
const PATH_TEMPLATES = ABSOLUTE_PATH . 'templates/';


/* DATABASE */
const DB_HOST = 'localhost';
const DB_PORT = '3306';
const DB_NAME = '';
const DB_USERNAME = '';
const DB_PASSWORD = '';

const LANGUAGES = [
	// To add localization, add the language pack to app/data/lang/abbr.json
	'en' => [
		'title' => 'English',
		'image' => 'en.png',
		'abbr' => 'en'
	],
	'ru' => [
		'title' => 'Русский',
		'image' => 'ru.png',
		'abbr' => 'ru'
	]
];

const EXTENSIONS_AVATAR = ['jpeg', 'jpg', 'png'];
const MAX_SIZE_AVATAR = 5; // 5mb

const MAX_SIZE_SEND_MESSAGE = 5;

const API_TOKEN = 'f3a9c712-8db5-4e67-bb2f-1a0c5d9e3f78';

const MAILING_COUNT_SEND_MESSAGE = 200;

const PROJECT_NAME = "Admin panel";
const VERSION = 'version: 1.0';

const CIPHER = '1234567890';

/* TELEGRAM */
const TELEGRAM_TOKEN = '';

const BOT_APP_NAME = '';
const BOT_APP_LINK = 'https://t.me/...';

const CHANNEL_APP_LINK = '';

/* WEBSOCKET */
const WEBSOCKET = 'websocket://...:2346';
const WEBSOCKET_LOCAL_CERT = '/etc/letsencrypt/live/.../cert.pem';
const WEBSOCKET_PRIVATE_KEY = '/etc/letsencrypt/live/.../privkey.pem';