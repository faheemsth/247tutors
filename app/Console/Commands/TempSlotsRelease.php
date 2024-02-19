<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TempSlot;
use Carbon\Carbon;

class TempSlotsRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tempslots:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cron is used to release temp slots to make them available for other users';

    /**
     * Execute the console command.
     *
     * @return int 
     */
    public function handle()
    {
        $slots = TempSlot::where('created_at', '<' , Carbon::now()->subMinutes(5))->delete();
    }
}
