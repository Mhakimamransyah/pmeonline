<?php

namespace App\Console\Commands;

use App\Cycle;
use App\Package;
use Illuminate\Console\Command;

class RevertInjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revert:injects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revert injects';

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
        $last = Cycle::all()->last();
        $target = Cycle::findOrFail(3);
        foreach ($target->packages as $package) {
            $srcPackage = Package::query()->where('name', str_replace("3", $last->id, $package->name))->get()->last();
            $package->injects()->saveMany($srcPackage->injects);
        }
    }
}
