<?php

namespace App\Console\Commands;

use App\Http\Controllers\CampaignController;
use Illuminate\Console\Command;

class SendCampaignMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_campaign_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to Campaign Users';

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
     * @return int
     */
    public function handle()
    {
        $campaign=new CampaignController();
        $campaign->startCampaign();
    }
}
