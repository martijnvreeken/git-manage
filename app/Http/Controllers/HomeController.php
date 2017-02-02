<?php

namespace App\Http\Controllers;

use App\Repositories\Git;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    protected $root;
    protected $fs;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Git $root, Filesystem $filesystem)
    {
//        $this->middleware('auth');
        $this->root = $root;
        $this->fs = $filesystem;
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $repositories = $this->root->all();
        return view('home', compact('repositories'));
    }
    
    public function view($name) {
        $repo = $this->root->get($name);
        $folders = $this->fs->directories($repo->path);
        $files = $this->fs->files($repo->path);
        $tags = $repo->git_object->getTags();
        $branches = $repo->git_object->getLocalBranches();
        return view('repo.view', compact('repo', 'tags', 'branches', 'folders', 'files'));
    }
    
    public function create(Request $request) {
        $name = $request->get('repository-name');
        $repo = \App\Models\Repository::create(['name' => $name]);
        \Cz\Git\GitRepository::init($repo->path, ['--bare']);
        return redirect(route('home'))->with('status', trans('messages.repo_created'));
    }
    
    public function destroy(Request $request) {
        $root = $request->get('path');
        \App\Models\Repository::where('path', $root)->delete();
        $this->fs->deleteDirectory($root);
        return redirect(route('home'))->with('status', trans('messages.repo_deleted'));
    }
}
