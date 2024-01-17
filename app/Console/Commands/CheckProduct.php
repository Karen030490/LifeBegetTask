<?php

namespace App\Console\Commands;

use App\Services\ExcelReader;
use Illuminate\Console\Command;

class CheckProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:update_qty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new ExcelReader();
        $service->readProductsFromXslx();
    }
}
