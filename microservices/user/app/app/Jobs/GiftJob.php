<?php

namespace App\Jobs;

use App\Models\User;
use GuzzleHttp\Client;

class GiftJob extends Job
{
    public function __construct()
    {
    }

    public function handle()
    {
        $client = new Client(['verify' => false]);
        $remoteCall = $client->get(
            'http://microservice_secret_nginx/api/v1/secrets/1'
        );
        /* Do stuff with the return from a remote service, for
 example save it in the wallet */
    }
}
