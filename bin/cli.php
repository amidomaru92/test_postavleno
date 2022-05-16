<?php

print_r($argv);

switch ($argv[1]) {
    case 'redis':
        // Prepend a base path if Predis is not available in your "include_path".
        require 'vendor\predis\predis\autoload.php';

        Predis\Autoloader::register();
        $client = new Predis\Client();

        switch ($argv[2]) {
            case 'add':
                if(isset($argv[3]) && isset($argv[4])) {
                    $client->set($argv[3], $argv[4]);
                    $client->expire($argv[3], 3600);
                    echo 'Line added ^_^';
                } else {
                    echo 'Bad parametrs';
                }
            break;

            case 'delete':
                if(isset($argv[3])) {
                    $client->del($argv[3]);
                    echo 'Line '.$argv[3].' removed :-(';
                }
            break;

            default:
                echo 'Available only 2 command: add and delete';
            break;
        }
    break;

    case 'memcached':
        die('command is building');
        break;

    default:
        die('No find command line');
    break;
}