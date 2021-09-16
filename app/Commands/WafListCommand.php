<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class WafListCommand extends Command
{
    protected $signature = 'waf:list';
    protected $description = 'List all WAF profiles in your Organization';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $profiles = $api->get('waf/profiles');

        $tableRows = [];
        foreach ($profiles['data']['profiles'] as $profile) {
            $default = 'N';
            if ($profile['is_default']) {
                $default = 'Y';
            }
            $tableRows[] = [$profile['id'], $profile['name'], $default];
        }

        $this->newLine();
        $this->comment('WAF Profiles');
        $this->table(['ID', 'Name', 'Default'], $tableRows);
    }
}
