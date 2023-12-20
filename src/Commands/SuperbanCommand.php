<?php

namespace Zeevx\Superban\Commands;

use Illuminate\Console\Command;

class SuperbanCommand extends Command
{
    public $signature = 'superban';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
