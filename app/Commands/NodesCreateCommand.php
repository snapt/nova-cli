<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class NodesCreateCommand extends Command
{
    protected $signature = 'nodes:create {name}';
    protected $description = 'Create a new node';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $name = $this->argument('name');

        $response = $api->post('nodes', [
            'name' => $name,
        ]);

        $this->info($response['data']['message']);
        $this->comment('ID : ' . $response['data']['node_id']);
        $this->comment('Key: ' . $response['data']['node_key']);
    }
}
