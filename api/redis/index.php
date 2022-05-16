<?php
// Prepend a base path if Predis is not available in your "include_path".
require '../../vendor/predis/predis/autoload.php';

Predis\Autoloader::register();
$client = new Predis\Client();
//$client->set('foo3', 'bar3');


if (isset($_SERVER['REQUEST_METHOD']))
{
    $result = [];
    switch ($_SERVER['REQUEST_METHOD'])
    {
        case 'GET':
            $keys = $client->keys('*');

            if (count($keys)) {
                $result['status'] = true;
                $result['code'] = 200;
                foreach ($keys as $v) {
                    $result['data'][$v] = $client->get($v);
                }
            }
        break;

        case 'DELETE':
            $keyDel = end(explode('/', $_SERVER['REQUEST_URI']));
            if ($client->del($keyDel)) {
                $result['status'] = true;
                $result['code'] = 200;
                $result['data'] = [];
            } else {
                $result['status'] = false;
                $result['code'] = 500;
                $result['data']['message'] = 'Error delete for this key';
            }

        break;

        default:
            $result['status'] = false;
            $result['code'] = 500;
            $result['data']['message'] = 'Error info message';

        break;
    }

    echo json_encode($result);
}