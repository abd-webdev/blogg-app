<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Gate;

class ListPolicies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policies:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered policies and their corresponding models';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $policies = Gate::policies();

        if (empty($policies)) {
            $this->info('No policies are registered.');
            return;
        }

        $this->info('Registered Policies:');
        $this->table(
            ['Model', 'Policy'],
            collect($policies)->map(fn($policy, $model) => [
                'Model' => $model,
                'Policy' => $policy,
            ])
        );
    }
}
