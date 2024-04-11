<?php

class Combinations
{
    private $_elements = array();

    public function __construct($elements)
    {
        $this->setElements($elements);
    }

    public function setElements($elements)
    {
        $this->_elements = array_values($elements);
    }

    public function getCombinations($length, $with_repetition = false)
    {
        $combinations = array();

        foreach ($this->x_calculateCombinations($length, $with_repetition) as $value) {
            $combinations[] = $value;
        }

        return $combinations;
    }

    public function getPermutations($length, $with_repetition = false)
    {
        $permutations = array();

        foreach ($this->x_calculatePermutations($length, $with_repetition) as $value) {
            $permutations[] = $value;
        }

        return $permutations;
    }

    private function x_calculateCombinations($length, $with_repetition = false, $position = 0, $elements = array())
    {

        $items_count = count($this->_elements);

        for ($i = $position; $i < $items_count; $i++) {

            $elements[] = $this->_elements[$i];

            if (count($elements) == $length) {
                yield $elements;
            } else {
                foreach ($this->x_calculateCombinations($length, $with_repetition, ($with_repetition == true ? $i : $i + 1), $elements) as $value2) {
                    yield $value2;
                }
            }

            array_pop($elements);
        }
    }

    private function x_calculatePermutations($length, $with_repetition = false, $elements = array(), $keys = array())
    {

        foreach ($this->_elements as $key => $value) {

            if ($with_repetition == false) {
                if (in_array($key, $keys)) {
                    continue;
                }
            }

            $keys[] = $key;
            $elements[] = $value;

            if (count($elements) == $length) {
                yield $elements;
            } else {
                foreach ($this->x_calculatePermutations($length, $with_repetition, $elements, $keys) as $value2) {
                    yield $value2;
                }
            }

            array_pop($keys);
            array_pop($elements);
        }
    }

    public function generate()
    {
        $size = 2;
        if (sizeof($this->_elements) >= 4) {
            $size = 4;
        }
        $combinations = $this->getPermutations($size, false);
        $out = '';
        foreach ($combinations as $combination) {
            $out .= implode(' ', $combination) . ' ';
        }

        return $out;
    }
    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip();
    }

}

if (!function_exists('priority')) {
    function priority()
    {
        return ['Low', 'Medium', 'High', 'Featured'];
    }
}

if (!function_exists('setOption')) {
    function setOption($key, $value = null)
    {
        try {
            $option = App\Option::where('key', $key)->first();

            if ($value) {
                if ($option) {
                    $option->update([
                        'value' => $value,
                    ]);
                } else {
                    App\Option::create([
                        'key' => $key,
                        'value' => $value,
                    ]);
                }

            } else {
                if ($option) {
                    $option->delete();
                }
            }

            Cache::forget('cache_option_' . $key, $value);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('getOption')) {
    function getOption($key, $defaultValue = null)
    {

        $return = $defaultValue;
        if (Cache::has('cache_option_' . $key)) {
            $return = Cache::get('cache_option_' . $key);
        } else {
            $option = App\Option::where('key', $key)->first();
            if ($option) {
                $return = $option->value;
                Cache::forever('cache_option_' . $key, $return);
            }
        }

        return $return;
    }
}

if (!function_exists('currency')) {
    function currency()
    {
        $locale = App::getLocale();

        if ($locale != 'en') {
            $localCurrency = getOption('local_currency', '');

            return '<span class="currency"> ' . $localCurrency . ' </span>';
        }

        $currency = getOption('currency', '');

        return $currency . ' ';
    }
}

if (!function_exists('decimalPlace')) {
    function decimalPlace()
    {
        return getOption('decimal_place', 2);
    }
}

if (!function_exists('priceFormat')) {
    function priceFormat($value, $currency = 'default', $separator = '')
    {

        if ($currency == 'default') {
            $currency = currency();
        }

        return $currency . number_format($value, decimalPlace(), '.', $separator);
    }
}

if (!function_exists('fillNine')) {
    function fillNine($input = null)
    {
        $values = explode(',', $input);
        $before = intval($values[0] ?? 0);
        $after = intval($values[1] ?? 0);
        $beforeOut = str_pad('', ($before - $after), '9');
        $afterOut = str_pad('', $after, '9');
        return $beforeOut . '.' . $afterOut;
    }
}

if (!function_exists('crudValidator')) {
    function crudValidator($column)
    {

        $rules = [];
        if ($column['required'] == true) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }

        if ($column['type'] == 'integer') {
            $rules[] = 'integer';
        }

        if ($column['type'] == 'email') {
            $rules[] = 'email';
        }

        if ($column['type'] == 'decimal') {
            $rules[] = 'regex:/^\d+(\.\d{1,3})?$/';
        }

        if ($column['type'] == 'image') {
            $rules[] = 'file';
            $rules[] = 'image';
            $rules[] = 'max: 10240';
        }

        if ($column['type'] == 'mobile') {
            $rules[] = 'regex:/^([0-9\s\-\+\(\)]*)$/';
        }

        if ($column['length'] && $column['type'] != 'decimal') {
            $rules[] = 'max:' . $column['length'];
        }

        if ($column['type'] == 'decimal') {
            $rules[] = 'lt:' . fillNine($column['length']);
        }

        return '\'' . implode('\', \'', $rules) . '\'';
    }
}

function findBetween(string $string, string $start, string $end, bool $greedy = false)
{
    $start = preg_quote($start, '/');
    $end = preg_quote($end, '/');

    $format = '/(%s)(.*';
    if (!$greedy) {
        $format .= '?';
    }

    $format .= ')(%s)/';

    $pattern = sprintf($format, $start, $end);

    preg_match_all($pattern, $string, $matches);

    return $matches[2] ?? [];
}

if (!function_exists('page')) {
    function page($name, $backlink, $view, $json = [])
    {
        return response()->json(array_merge_recursive([
            'jquery' => [
                [
                    'element' => '#page',
                    'method' => 'attr',
                    'value' => ['page-name', $name],
                ],
                [
                    'element' => '#page',
                    'method' => 'attr',
                    'value' => ['act-request', $backlink],
                ],
                [
                    'element' => '#page',
                    'method' => 'html',
                    'value' => $view,
                ],
            ],
            'init' => ['#page'],
            'scrolltop' => true,
        ], $json));
    }
}

if (!function_exists('getPermissionWithRoutePath')) {

    function getPermissionWithRoutePath($route, $permits, $pre_path)
    {

        if (is_array($permits) && count($permits) > 0) {

            foreach ($permits as $key => $value) {

                $temp_path = $pre_path;

                array_push($temp_path, $key);

                if (is_array($value) && count($value) > 0) {
                    $res_path = getPermissionWithRoutePath($route, $value, $temp_path);

                    if ($res_path != null) {
                        return $res_path;
                    }
                } elseif ($value == $route) {
                    return $temp_path;
                }
            }
        }

        return null;
    }
}

if (!function_exists('ifJsonDecode')) {
    function ifJsonDecode($string)
    {
        $isJson = is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
        if ($isJson) {
            return json_decode($string, true);
        }
        return $string;
    }
}

if (!function_exists('getCart')) {
    function getCart()
    {
        $cart = null;

        if (request()->cart) {
            $cart = request()->cart;
        } else {
            if (isset($_COOKIE['__cart'])) {
                $cart = $_COOKIE['__cart'];
            }
        }

        return json_decode($cart, true);
    }
}

if (!function_exists('setCart')) {
    function setCart($cart)
    {
        $jsonEncodeCart = json_encode($cart);
        $_COOKIE['__cart'] = $jsonEncodeCart;
        return setcookie('__cart', $jsonEncodeCart, time() + 31556926, '/', null, true, false);
    }
}

if (!function_exists('productExistsInCart')) {
    function productExistsInCart($productId, $defaultValue = null)
    {

        $cart = getCart();

        if (!isset($cart['products'])) {
            $cart = [
                'products' => [],
            ];
        }

        return $cart['products'][$productId]['quantity'] ?? $defaultValue;
    }
}

if (!function_exists('productStatusInCart')) {
    function productStatusInCart($productId)
    {
        $cart = getCart();

        if (!isset($cart['products'])) {
            $cart = [
                'products' => [],
            ];
        }
        return $cart['products'][$productId]['status'] ?? true;
    }
}

if (!function_exists('productMessageInCart')) {
    function productMessageInCart($productId)
    {
        $cart = getCart();

        if (!isset($cart['products'])) {
            $cart = [
                'products' => [],
            ];
        }
        return $cart['products'][$productId]['message'] ?? '';
    }
}

if (!function_exists('productTotalSellingPriceInCart')) {
    function productTotalSellingPriceInCart($productId, $defaultValue = null)
    {
        $cart = getCart();

        if (!isset($cart['products'])) {
            $cart = [
                'products' => [],
            ];
        }

        return $cart['products'][$productId]['total_selling_price'] ?? $defaultValue;
    }
}

if (!function_exists('productTotalPriceInCart')) {
    function productTotalPriceInCart($productId, $defaultValue = null)
    {
        $cart = getCart();

        if (!isset($cart['products'])) {
            $cart = [
                'products' => [],
            ];
        }

        return $cart['products'][$productId]['total_price'] ?? $defaultValue;
    }
}

if (!function_exists('minimumQuantityPrice')) {
    function minimumQuantityPrice($price, $quantity, $steper)
    {
        return $price * ($quantity / $steper);
    }
}

if (!function_exists('cartItemCount')) {
    function cartItemCount($defaultValue = 0)
    {
        $cart = getCart();
        $count = 0;
        if (isset($cart['products'])) {
            $count = count($cart['products']);
        }

        if ($count <= 0) {
            return $defaultValue;
        }

        return $count;
    }
}

if (!function_exists('cartTotalAmount')) {
    function cartTotalAmount()
    {
        $cart = getCart();

        $total = 0;
        if (isset($cart['products'])) {
            foreach ($cart['products'] as $id => $data) {
                $productTotal = $data['total_selling_price'] ?? 0;
                $total = $total + $productTotal;
            }
        }

        return priceFormat($total, '');
    }
}

if (!function_exists('cartUpdate')) {
    function cartUpdate($clear = false)
    {

        $return = [];
        $cart = getCart();
        $cartProducts = [];

        if (isset($cart['products'])) {
            $cartProducts = $cart['products'];
            $cart['products'] = [];
        }

        foreach ($cartProducts as $cartProductId => $cartProduct) {
            $product = App\Product::find($cartProductId);

            if ($product && $product->status == 'published') {

                $message = $cartProduct['message'] ?? '';

                $quantity = $cartProduct['quantity'];

                if ($product->price != $cartProduct['price'] || $product->selling_price != $cartProduct['selling_price']) {
                    $message = 'Product price has been updated.';
                }

                if ($product->stock_status == 'limited' && $product->stock_available < $quantity) {
                    $quantity = $product->stock_available;
                    $message = 'Product purchase quantity updated based on stock.';
                }

                if ($product->minimum_quantity > $quantity) {
                    if ($quantity == 0) {
                        $message = 'The product has been updated.';
                    } else {
                        $message = 'Product minimum purchase quantity has been updated.';
                    }
                    $quantity = $product->minimum_quantity;
                }

                if ($product->unit->stepper != $cartProduct['steper']) {
                    $quantity = $product->minimum_quantity;
                    $message = 'The product has been updated.';
                }

                if ($product->stock_status == 'limited' && ($product->stock_available <= 0 || $product->stock_available < $product->minimum_quantity)) {
                    $quantity = 0;
                    $message = 'Out of stock.';
                }

                if ($clear) {
                    if ($quantity > 0) {
                        $cart['products'][$cartProductId] = [
                            "price" => $product->price,
                            "selling_price" => $product->selling_price,
                            "quantity" => $quantity,
                            "steper" => $product->unit->stepper,
                            "total_price" => $product->price * ($quantity / $product->unit->stepper),
                            "total_selling_price" => $product->selling_price * ($quantity / $product->unit->stepper),
                            "message" => $message,
                        ];
                    }
                } else {
                    $cart['products'][$cartProductId] = [
                        "price" => $product->price,
                        "selling_price" => $product->selling_price,
                        "quantity" => $quantity,
                        "steper" => $product->unit->stepper,
                        "total_price" => $product->price * ($quantity / $product->unit->stepper),
                        "total_selling_price" => $product->selling_price * ($quantity / $product->unit->stepper),
                        "message" => $message,
                    ];
                }

            }
        }

        if (empty($cart['products'])) {
            $cart['products'] = new \stdClass();
        }

        return $cart;
    }
}

if (!function_exists('_local')) {

    function _local($data, $local = '')
    {
        $locale = App::getLocale();

        if ($locale != 'en') {

            if ($local == '') {
                return $data;
            }

            return $local;
        }

        return $data;
    }
}

if (!function_exists('fileName')) {
    function fileName($extension, $suffix = '')
    {
        $code = strtolower(md5(uniqid(rand(), true)));
        return uniqid() . '-' . substr($code, 0, 8) . '-' . substr($code, 8, 4) . '-' . substr($code, 12, 4) . '-' . substr($code, 16, 4) . '-' . substr($code, 20) . $suffix . '.' . $extension;
    }
}

if (!function_exists('unicode')) {
    function unicode()
    {
        $code = strtolower(md5(uniqid(rand(), true)));
        return uniqid() . '-' . substr($code, 0, 13) . '-' . substr($code, 8, 13) . '-' . substr($code, 12, 13) . '-' . substr($code, 16, 13) . '-' . substr($code, 13);
    }
}

if (!function_exists('authUser')) {

    function authUser($type = 'web')
    {

        if ($type == 'web') {

            return Auth::user();

        } elseif ($type == 'api') {
            $token = request()->header('Authorization');

            if ($token) {
                $explode = explode('|', $token, 2);

                if (is_array($explode)) {
                    $bearer = $explode[0] ?? null;
                    $token = $explode[1] ?? null;

                    if ($bearer != null && $token != null && $token != '' && $token != ' ') {
                        $id = str_replace('Bearer ', '', $bearer);

                        if ($id) {
                            $user = App\User::find($id);
                            $userapi = App\ApiToken::where('user_id', $id)->latest()->get();
                            if ($user) {
                                if ($user->status == 'active' && (count($userapi) > 0)) {
                                    foreach ($userapi as $api) {
                                        if (Illuminate\Support\Facades\Hash::check($token, $api->api_token)) {

                                            return $user;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } elseif ($type == 'deliveryagentapi') {
            $token = request()->header('Authorization');
            if ($token) {
                $explode = explode('|', $token, 2);

                if (is_array($explode)) {
                    $bearer = $explode[0] ?? null;
                    $token = $explode[1] ?? null;

                    if ($bearer != null && $token != null && $token != '' && $token != ' ') {
                        $id = str_replace('Bearer ', '', $bearer);

                        if ($id) {
                            $agent = App\DeliveryAgent::find($id);
                            $agentapi = App\DeliveryAgentApiToken::where('agent_id', $id)->latest()->get();

                            if ($agent) {
                                if ($agent->verified == '1' && (count($agentapi) > 0)) {
                                    foreach ($agentapi as $api) {
                                        if (Illuminate\Support\Facades\Hash::check($token, $api->api_token)) {

                                            return $agent;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } elseif ($type == 'deliverypartnerapi') {
            $token = request()->header('Authorization');
            if ($token) {
                $explode = explode('|', $token, 2);

                if (is_array($explode)) {
                    $bearer = $explode[0] ?? null;
                    $token = $explode[1] ?? null;

                    if ($bearer != null && $token != null && $token != '' && $token != ' ') {
                        $id = str_replace('Bearer ', '', $bearer);

                        if ($id) {
                            $dp = App\DeliveryPartner::find($id);
                            $dpapi = App\DeliveryPartnerApiToken::where('dp_id', $id)->latest()->get();

                            if ($dp) {
                                if ((count($dpapi) > 0)) {
                                    foreach ($dpapi as $api) {
                                        if (Illuminate\Support\Facades\Hash::check($token, $api->api_token)) {

                                            return $dp;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }else {

            return null;
        }

        return null;
    }
}

if (!function_exists('permissions')) {

    function permissions()
    {
        return Config::get('permissions', []);
    }
}

if (!function_exists('hasPermission')) {

    function hasPermission($route)
    {

        if (config('app.debug', false) && !config('app.permission', true)) {
            return 1;
        }

        $authUser = authUser();

        if (!$authUser) {
            return 0;
        }

        if ($authUser->role->type != 'private') {
            return 0;
        }

        if ($authUser->role->type == 'private' && $authUser->role->created_by == 'system') {
            return 1;
        }

        $role = $authUser->role;

        if (!$role) {
            return 0;
        }

        $role_id = $role->id;

        $permissionKeys = [];

        if (Cache::has('permissions')) {

            $permissionKeys = Cache::get('permissions');

        } else {

            $permissions = App\Permission::all();

            $permissionKeys = [];

            foreach ($permissions as $permission) {
                $permissionKeys[] = $permission->role_id . '|' . $permission->permission;
            }

            Cache::forever('permissions', $permissionKeys);
        }

        $routePath = getPermissionWithRoutePath($route, permissions(), []);

        if (is_array($routePath)) {
            if (count($routePath) == 3) {
                if (in_array($role_id . '|' . $routePath[0] . '-' . $routePath[1], $permissionKeys)) {
                    return 1;
                }
            }
        }

        return 0;
    }
}

if (!function_exists('subscribePushNotification')) {

    function subscribePushNotification($token, $topics = '/order')
    {

        $key = config('app.firebase.server_key', false);

        $title = config('app.name', false);

        $message = 'New test message';

        $headers = array(
            'Authorization:key=' . $key,
            'Content-Type:application/json',
        );

        $fields = array(
            'to' => '/topics' . $topics,
            "registration_tokens" => [$token],
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://iid.googleapis.com/iid/v1:batchAdd');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('sendPushNotificationWithTopic')) {

    function sendPushNotificationWithTopic($message, $topics = '/order')
    {

        $key = config('app.firebase.server_key', false);

        $title = config('app.name', false);

        $headers = array(
            'Authorization:key=' . $key,
            'Content-Type:application/json',
        );

        $fields = array(
            'to' => '/topics' . $topics,
            'notification' => ['title' => $title, 'body' => $message, 'sound' => 'default'],
            'data' => ['title' => $title, 'body' => $message, 'style' => 'inbox'],
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('sendPushNotification')) {

    function sendPushNotification($message, $token)
    {
        $key = config('app.firebase.server_key', false);

        $title = config('app.name', false);

        $headers = array(
            'Authorization:key=' . $key,
            'Content-Type:application/json',
        );

        $fields = array(
            'to' => $token,
            'priority' => 'high',
            'notification' => ['title' => $title, 'body' => $message, 'sound' => 'default'],
            'data' => ['title' => $title, 'body' => $message, 'style' => 'inbox', 'toast' => true],
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('webhookEvents')) {

    function webhookEvents($event, $value)
    {
        $url = config('app.webhook.url', false);

        if ($url) {
            $headers = [
                'Authorization:' => 'Bearer ' . config('app.webhook.api_key', ''),
            ];

            $fields = [
                'event' => $event,
                'value' => $value,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        }
    }
}

if (!function_exists('notify')) {

    function notify($productId)
    {
        $enquiries = App\Enquiry::where('product_id', $productId)->where('status', 'enquired')->get();
        foreach ($enquiries as $enquiry) {
            $status = false;
            if ($enquiry->product->status == 'published') {

                if ($enquiry->product->stock_status == 'limited') {
                    if ($enquiry->product->stock_available > 0) {
                        $status = true;
                    }
                }

                if ($enquiry->product->stock_status == 'unlimited') {
                    $status = true;
                }
            }

            if ($status) {
                if ($enquiry->user->fcm) {
                    sendPushNotification('Hi ' . $enquiry->user->name . ', ' . $enquiry->product->name . 'is available now.', $enquiry->user->fcm);
                }

                sendSms($enquiry->user->mobile, 'Hi, ' . $enquiry->user->name . ', Item ' . $enquiry->product->name . ' Currently Available in Stock @ laptopspareworld.com', '1307164095250242076');

                $enquiry->update([
                    'status' => 'notified',
                ]);
            }
        }
        ;
    }
}

if (!function_exists('sendSms')) {

    function sendSms($destination=null, $message=null, $templateId=null, $input_data, $type=null)
    {

        // return true;
        // $message="OTP: ".$otp." is your GROFIRST verification code. Enter it to verify your number and get things at your doorstep! Thank you for choosing GROFIRST.";
        $url= 'http://thesmsbuddy.com/api/v1/sms/send';

        $data['key'] = 'x0jKNNSiFG66dRyva7Q8cTB2DieCGyLQ';
        $data['type'] = 1;
        // $data['to'] = $destination;
        $data['sender'] = 'GRFRST';
        $data['message'] = $message;
        $data['flash'] = 0;
        $data['template_id'] = $templateId;
        $ip = $_SERVER['REMOTE_ADDR'];
        $destination_array=array();
        array_push($destination_array, $destination);

        // $params = http_build_query($data);
        if($destination&&$message&&$templateId) {
            if($type=='order') {

                    $default_number="8921900500";
                    array_push($destination_array, $default_number);

                $log_id= App\OrderSmsLog::create([
                    'mobile'=>$destination,
                    'order_id'=>$input_data,
                    'ip'=>$ip

                  ])->id;
            } else {
                $log_id= App\SmsLog::create([
                    'mobile'=>$destination,
                    'otp'=>$input_data,
                    'ip'=>$ip

                  ])->id;
            }
        }
        if(isset($log_id)) {
            foreach($destination_array as $key=> $dest) {
                $data['to'] = $dest;
                $params = http_build_query($data);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url."?".$params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);

                if ($err) {
                    return "cURL Error #:" . $err;
                }
                // else {
                //     return $result;
                // }
            }
            return true;

        } else {
            return false;
        }
    }
}
