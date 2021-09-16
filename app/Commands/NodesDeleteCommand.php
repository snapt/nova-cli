<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class NodesDeleteCommand extends Command
{
    protected $signature = 'nodes:delete {id}';
    protected $description = 'Delete a single node';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $id = $this->argument('id');

        $response = $api->get('nodes/' . $id . '/delete');
        $this->info($response['data']['message']);
    }
}
