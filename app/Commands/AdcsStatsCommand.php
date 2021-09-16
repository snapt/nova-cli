<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class AdcsStatsCommand extends Command
{
    protected $signature = 'adcs:stats {id}';
    protected $description = 'Get the statistics for a single ADC';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $id = $this->argument('id');
        $stats = $api->get('adcs/' . $id . '/stats');


        $this->comment('Statistics for ' . $stats['adc']['name']);
        $this->info('Attached to ' . count($stats['attachedNodes']) . ' nodes:');
        foreach ($stats['attachedNodes'] as $node) {
            $this->info(' - ' . $node['name']);
        }


        $this->newLine();
        $this->comment('Summary for ADC per Node');
        $tableRows = [];
        foreach ($stats['attachedNodes'] as $node) {
            $nStats = $stats['adcNodeSummaries'][$node['id']];
            $tableRows[] = [
                $node['name'],
                number_format($nStats['http_requests_rate'], 2),
                number_format($nStats['http_requests_rate_max'], 2),
                number_format($nStats['bytes_in_rate'], 2) . 'bps',
                number_format($nStats['bytes_out_rate'], 2) . 'bps',
                $nStats['backends_requests_last_1024_connect_time_average'] . 'ms',
                $nStats['backends_requests_last_1024_reponse_time_average'] . 'ms',
                $nStats['servers_up'] . ' / ' . $nStats['servers_down'],
            ];
        }

        $this->table(['Node', 'HTTP ReqRate', 'HTTP Rate Max', 'BPS In', 'BPS Out', 'Connect Time', 'Response Time', 'Upstreams Up/Down'], $tableRows);


        $this->comment('Full statistics for ADC');
        $tableRows = [];
        foreach ($stats['adcSummary'] as $name => $value) {
            $tableRows[] = [$name, $value];
        }

        $this->table(['Metric', 'Value'], $tableRows);
    }
}
