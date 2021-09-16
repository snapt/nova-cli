<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class NodesListCommand extends Command
{
    protected $signature = 'nodes:list';
    protected $description = 'List all of the Nodes in your Organization';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $nodes = $api->get('nodes');

        $tableRows = [];
        foreach ($nodes['data']['stats'] as $key => $value) {
            $tableRows[] = [$key, $value];
        }

        $this->comment('Organization Node Statistics');
        $this->table(['Stat', 'Value'], $tableRows);

        $tableRows = [];
        foreach ($nodes['data']['nodes'] as $node) {
            $tableRows[] = [$node['id'], $node['name']];
        }

        $this->newLine();
        $this->comment('Organization Nodes');
        $this->table(['ID', 'Name'], $tableRows);
    }
}
