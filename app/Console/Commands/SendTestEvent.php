<?php

namespace App\Console\Commands;

use App\Events\SomeTestEvent;
use Illuminate\Console\Command;

class SendTestEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-test-event';

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
        event(new SomeTestEvent(['message' => 'Hello from CLI!']));
        $this->info('Event sent!');
    }
}
