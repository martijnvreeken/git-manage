<?php

namespace App\Console\Commands\GitManage;

use App\Models\Repository;
use App\Repositories\Git;
use Illuminate\Console\Command;

class Init extends Command
{
    protected $root;
    protected $base_path;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git-manage:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read repositories from disk and insert them into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Git $root)
    {
        parent::__construct();
        $this->root = $root;
        $this->base_path = config('git-manage.repositories_base_path');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $folders = $this->root->readFolders();
        $count = 0;
        array_walk($folders, function ($path) use (&$count) {
            $name = substr($path, strlen($this->base_path)+1); // +1 to also remove the 'slash'
            try {
                $repo = new Repository();
                $repo->name = $name;
                $repo->path = $path;
                $repo->save();
                $this->line("found $name and created the model...");
                $count++;
            } catch(\Exception $error) {
                \Log::error($error);
            }
        });
        $this->info($count . ' repositories were created');

    }
}
