<?php
/**
 * Created by PhpStorm.
 * User: Zuxriddin
 * Date: 05.07.2018
 * Time: 0:44
 */

require_once('application/libraries/telegram/autoload.php');

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramResponseException;

class Bot extends CI_Controller
{
    const START = 0;
    const PICTURE = 1;
    const PRODUCT = 2;
    const DESCRIPTION = 3;
    const PRICE = 4;
    const PHONE = 5;
    const ADDRESS = 6;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('bot_model', 'bot');
        $this->config->load('bot_settings', true);
        $bot = $this->config->item('bot_settings');
        define('HOOK_URL', @$bot['hook_url']);
        define('TOKEN', @$bot['token']);
        define('BOT_NAME', @$bot['bot_name']);
        define('CHANNEL', @$bot['chat_id']);
    }

    public function index()
    {
        try {
            $constant = 'constant';
            $telegram = new Api(TOKEN);
            $request = $telegram->getWebhookUpdates();

            $user_id = @$request['message']['from']['id'];
            $user_name = @$request['message']['from']['username'];
            $first_name = @$request['message']['from']['first_name'];
            $last_name = @$request['message']['from']['last_name'];
            $user_type = @$request['message']['chat']['type'];
            $full_name = sprintf('%s %s', $first_name, $last_name);
            $request_type = $telegram->detectMessageType($request);
            $text = @$request['message']['text'];
            if ($user_type != 'private') {
                return 0;
            }
            $session = $this->bot->get_session($user_id);
            if ($session) {
                $active_step = $session->step;
                $data = Array(
                    'step' => $session->step,
                    'user_id' => $session->user_id,
                    'login' => $session->login,
                    'picture' => $session->picture,
                    'product' => $session->product,
                    'description' => $session->description,
                    'price' => $session->price,
                    'phone' => $session->phone,
                    'address' => $session->address,
                    'full_name' => $session->full_name,
                );
            } else {
                $active_step = self::START;
                $data = Array(
                    'login' => $user_name or '',
                    'user_id' => $user_id,
                    'full_name' => $full_name,
                );
            }

            switch ($active_step) {
                case self::START:
                    $message = "\xF0\x9F\x96\xBC Sotmoqchi bo'lgan mahsulotingiz rasmini jo'nating";
                    $telegram->sendMessage([
                        'chat_id' => $user_id,
                        'text' => $message,
                    ]);
                    $data['step'] = self::PICTURE;
                    $this->bot->set_session($data);
                    break;

                case self::PICTURE:
                    if ($request_type == 'photo') {
						$pictures = $request["message"]['photo'];
						foreach($pictures as $list => $value) {
							$picture = $value;
						}

                        $picture_id = @$picture['file_id'];
                        $data['step'] = self::PRODUCT;
                        $data['picture'] = $picture_id or '';
                        $message = "\xF0\x9F\x96\x8A Mahsulotingizni nomini yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);

                    } else {
                        $message = "\xF0\x9F\x96\xBC Sotmoqchi bo'lgan mahsulotingiz rasmini jo'nating";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    }
                    $this->bot->set_session($data);
                    break;

                case self::PRODUCT:
                    if ($request_type == 'text') {
                        $data['step'] = self::DESCRIPTION;
                        $data['product'] = $text;
                        $message = "\xF0\x9F\x93\x9D Izoh yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);

                    } else {
                        $message = "\xF0\x9F\x96\x8A Mahsulotingizni nomini yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    }
                    $this->bot->set_session($data);
                    break;

                case self::DESCRIPTION:
                    if ($request_type == 'text') {
                        $data['step'] = self::PRICE;
                        $data['description'] = $text;
                        $message = "\xF0\x9F\x92\xB0 Mahsulotingizni narxini yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    } else {
                        $message = "\xF0\x9F\x93\x9D Izoh yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    }
                    $this->bot->set_session($data);
                    break;

                case self::PRICE:
                    if ($request_type == 'text') {
                        $data['step'] = self::PHONE;
                        $data['price'] = $text;
                        $message = "\xF0\x9F\x93\x9E Telefon raqamingizni yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    } else {
                        $message = "\xF0\x9F\x92\xB0 Mahsulotingizni narxini yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    }
                    $this->bot->set_session($data);

                    break;

                case self::PHONE:
                    if ($request_type == 'text') {
                        $data['step'] = self::ADDRESS;
                        $data['phone'] = $text;
                        $message = "\xF0\x9F\x93\x8C Manzilingizni kiriting";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);

                    } else {
                        $message = "\xF0\x9F\x93\x9E Telefon raqamingizni yuboring";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    }
                    $this->bot->set_session($data);
                    break;

                case self::ADDRESS:
                    if ($request_type == 'text') {
                        $data['step'] = self::START;
                        $data['address'] = $text;
						
						$picture = $telegram->getFile(array('file_id' => $session->picture));
						$picture_path = @$picture['file_path'];
						file_put_contents(
						    'uploads/'.$session->picture.'.jpg',
                            @file_get_contents("https://api.telegram.org/file/bot{$constant('TOKEN')}/$picture_path"));

                        $message = "
\xE2\x9C\x85 Sizning mahsulot muvaffaqiyatli yuborildi.
Bizning xizmatdan foydalanganingiz uchun raxmat \xF0\x9F\x98\x8A
E'loningiz bir necha soatlardan so'ng kanalda ko'rinadi";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                        $announcement = array(
                            'id_user' => $session->user_id,
                            'picture' => $session->picture,
                            'product' => $session->product,
                            'description' => $session->description,
                            'price' => $session->price,
                            'phone' => $session->phone,
                            'address' => $session->address,
                            'owner' => $session->full_name,
                        );
                        $this->bot->add_announcement($announcement);
                    } else {
                        $message = "\xF0\x9F\x93\x8C Manzilingizni kiriting";
                        $telegram->sendMessage([
                            'chat_id' => $user_id,
                            'text' => $message
                        ]);
                    }
                    $this->bot->set_session($data);
                    break;
            }

        } catch (TelegramResponseException $e) {
            $errorData = $e->getResponseData();
            $telegram = new Api(TOKEN);
            $telegram->sendMessage([
                'chat_id' => -1001313389112,
                'text' => "Ошибка в боте. " . $errorData['description']
            ]);
            return 0;
        }
    }


    private function debug($text)
    {
        $telegram = new Api(TOKEN);
        $telegram->sendMessage([
            'chat_id' => 33854740,
            'text' => $text
        ]);
    }

    public function setWebHook()
    {
        $constant = 'constant';
        $url = "https://api.telegram.org/bot{$constant('TOKEN')}/setWebHook?url={$constant('HOOK_URL')}";
        curl_basic($url);
    }

    public function deleteWebHook()
    {
        $constant = 'constant';
        $url = "https://api.telegram.org/bot{$constant('TOKEN')}/deleteWebHook?url={$constant('HOOK_URL')}";
        curl_basic($url);
    }

    public function cronTabScheduler() {
        $telegram = new Api(TOKEN);
        $announcements = $this->bot->get_unpublished_announcement();

        foreach ($announcements as $item) {
			$picture = base_url('uploads/'.$item->picture.'.jpg');
            $product = $item->product;
            $description = $item->description;
            $price = $item->price;
            $phone = $item->phone;
            $address = $item->address;
			$message="
[​​​​​​​​​​​]($picture) *Mahsulot nomi*: $product
*Izoh*: $description
*Narxi*: $price
*Telefon*: $phone
*Manzil*: $address";
            $telegram->sendMessage([
                'chat_id' => CHANNEL,
                'parse_mode' => "Markdown",
                'text' => $message
            ]);

            // $this->bot->inactive_announcement($item->id);
        }
    }

}
