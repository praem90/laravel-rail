<?php

namespace Praem90\Rail;

use Illuminate\Log\Events\MessageLogged;

class Rail
{
    public function __construct(private $app) {}

    public function log(MessageLogged $event): void
    {
        $host = env('PRAEM90_RAIL_HOST', 'tcp://127.0.0.1:7878');
        $fp = stream_socket_client($host, $error_code, $error_message);

        if ($fp) {
            fwrite($fp, $event->message);
            fclose($fp);
        }
    }
}
