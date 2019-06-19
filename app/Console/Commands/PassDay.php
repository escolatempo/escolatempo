<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Agendado;
use App\Disponibilidade;

class PassDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pass:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Agendado::where('status', 'agendado')
        ->where('dia', '<', date('Y-m-d'))
        ->update(['status' => 'dada']);

        Disponibilidade::where('dia', '<', date('Y-m-d'))
        ->delete();

        $this->info('Cron foi rodado');
    }
}
