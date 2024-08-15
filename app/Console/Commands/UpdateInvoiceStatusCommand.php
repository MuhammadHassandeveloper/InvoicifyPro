<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateInvoiceStatusCommand extends Command
{
    protected $signature = 'invoices:update_status';

    protected $description = 'Update invoice statuses';
    public function handle()
    {
        app('App\Http\Controllers\InvoiceController')->updateInvoiceStatus();
        $this->info('Invoice statuses updated successfully!');
    }
}
