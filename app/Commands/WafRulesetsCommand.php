<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class WafRulesetsCommand extends Command
{
    protected $signature = 'waf:ruleset
                            {profile_id : the WAF profile ID}
                            {action : list|add|remove}
                            {list? : allowed|blocked for when adding or removing an IP to a list}
                            {ip? : the IP/cidr to add or remove if action is add|remove}';
    protected $description = 'Interact with the rulesets in a WAF profile';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $profile_id = $this->argument('profile_id');
        $action = $this->argument('action');
        $list = $this->argument('list');
        $ip = $this->argument('ip');

        if ($action === 'list') {
            $tableRows = [];
            $ips = $api->get('rulesets/' . $profile_id . '/ips');
            foreach ($ips['data'] as $key => $values) {
                foreach ($values as $value) {
                    if (trim($value) === '') {
                        continue;
                    }

                    $tableRows[] = [$key, $value];
                }
            }

            $this->comment('IP Rulesets for WAF Profile ' . $profile_id);
            $this->table(['Type', 'IP/CIDR'], $tableRows);
        }


        if ($action === 'remove') {
            $result = $api->post('rulesets/' . $profile_id . '/removeIp', [
                'list' => $list,
                'ip' => $ip,
            ]);

            $this->comment($result['data']['message']);
        }

        if ($action === 'add') {
            $result = $api->post('rulesets/' . $profile_id . '/addIp', [
                'list' => $list,
                'ip' => $ip,
            ]);

            $this->comment($result['data']['message']);
        }
    }
}
