<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class AdcsListCommand extends Command
{
    protected $signature = 'adcs:list';
    protected $description = 'List all of the ADCs in your Organization';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $adcs = $api->get('adcs');

        $tableRows = [];
        foreach ($adcs['data']['adcs'] as $adc) {
            $tableRows[] = [$adc['id'], $adc['name'], $adc['provider']];
        }

        $this->newLine();
        $this->comment('Organization ADCs');
        $this->table(['ID', 'Name', 'type'], $tableRows);

        foreach ($adcs['data']['adcs'] as $adc) {

            $this->newLine();
            $this->comment('Nodes attached to ' . $adc['name']);

            $tableRows = [];
            foreach ($adcs['data']['attachments'][$adc['id']] as $attachment) {
                $tableRows[] = [$attachment['name'], $attachment['last_seen_state'], $attachment['public_ip'], $attachment['hostname'], $attachment['os_pretty_name']];
            }

            $this->table(['Node', 'State', 'Public IP', 'Hostname' , 'OS'], $tableRows);

        }
    }
}
