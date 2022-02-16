<?php
/**
 * Created by PhpStorm.
 * User: Zuxriddin
 * Date: 05.07.2018
 * Time: 0:52
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$config['token'] = getenv('TELEGRAM_BOT_TOKEN');
$config['hook_url'] = getenv('TELEGRAM_BOT_HOOK_URL');
$config['bot_name'] = '';

$config['chat_id'] = '';
