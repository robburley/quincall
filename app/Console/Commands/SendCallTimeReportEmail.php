<?php

namespace App\Console\Commands;

use App\Mail\CallTimeReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCallTimeReportEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:call-time {recipient}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email the call time report to a recipient';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::to($this->argument('recipient'))->send(new CallTimeReport);
    }
}
