<?php

namespace App\Commands;

use App\Api\NovaApi;
use LaravelZero\Framework\Commands\Command;

class CertificatesListCommand extends Command
{
    protected $signature = 'certificates:list';
    protected $description = 'List all of the certificates in your Organization';

    public function handle()
    {
        $api = new NovaApi(config('nova.key'));
        $certificates = $api->get('certificates');

        $tableRows = [];
        foreach ($certificates['data']['certificates'] as $certificate) {
            $tableRows[] = [$certificate['id'], $certificate['name'], $certificate['domains'], $certificate['expiry']];
        }

        $this->newLine();
        $this->comment('Organization Certificates');
        $this->table(['ID', 'Name', 'Domains', 'Expiry'], $tableRows);
    }
}
