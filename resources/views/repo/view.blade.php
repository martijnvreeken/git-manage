@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2>{{ $repo->name }} 
                <span class="pull-right">
                    <a class="btn btn-default" href="#" onclick="event.preventDefault(); document.getElementById('destroy-form').submit();">
                        <span class="fa fa-trash"></span> Delete
                    </a>
                </span>
            </h2>
            <form id="destroy-form" action="{{ route('repo.destroy') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
                <input type="hidden" name="path" value="{{ $repo->path }}" />
            </form>
            <p>{{ $repo->description }}</p>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Tags</div>
                        <div class="panel-body">
                            @if($tags == null)
                            <p class="text-info">No tags found</p>
                            @else
                            <ul class="list-group">
                            @foreach($tags as $tag)
                                <li class="list-group-item">{{ $tag }}</li>
                            @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Branches</div>
                        <div class="panel-body">
                            @if($branches == null)
                            <p class="text-info">No branches found</p>
                            @else
                            <ul class="list-group">
                            @foreach($branches as $branch)
                                <li class="list-group-item">{{ $branch }}</li>
                            @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Folders and files in this repository</div>
                <div class="panel-body">
                    <ul class="list-group">
                    @foreach($folders as $folder)
                    <li class="list-group-item list-group-item-info folder"><span class="fa fa-folder" aria-hidden="true"></span> {{ $folder }}</li>
                    @endforeach
                    @foreach($files as $file)
                    <li class="list-group-item list-group-item-text file"><span class="fa fa-file" aria-hidden="true"></span> {{ $file }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
@endsection