<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repositories;

use App\Models\Repository;
use Illuminate\Filesystem\Filesystem;

/**
 * Description of Git
 *
 * @author martijn
 */
class Git {
    protected $fs;
    public function __construct(Filesystem $filesystem)
    {
        $this->fs = $filesystem;
    }
    public function all() {
        return Repository::all();
    }
    
    public function readFolders() {
        $base = config('git-manage.repositories_base_path');
        $folders = $this->fs->directories($base);
        $git_folders = array_filter($folders, function ($folder) {
            return $this->fs->exists($folder . '/.git');
        });
        
        return $git_folders;
    }
    
    public function get($name) {
        $repo = Repository::where('name', $name)->first();
        $repo->git_object = new \Cz\Git\GitRepository($repo->path);
        return $repo;
    }
}
