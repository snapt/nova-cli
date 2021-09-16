<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class MeCommand extends Command
{
    protected $signature = 'me';
    protected $description = 'Display details about your Nova API credentials and account';

    public function handle()
    {
        $this->info('Loading Nova API credentials...');

        $api = new NovaApi(config('nova.key'));
        $me = $api->get('me');

        if (!isset($me['success']) || $me['success'] !== true) {
            $this->error('Failed to communicate with Nova or authenticate with your token.');
            exit;
        }

        $tableRows = [];
        foreach ($me['data'] as $name => $value) {
            $tableRows[] = [$name, $value];
        }

        $this->table(['Name', 'Value'], $tableRows);
    }
}
