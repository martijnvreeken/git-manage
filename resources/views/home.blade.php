@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="navbar navbar-default">
                <form class="navbar-form navbar-left" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="repository-name" class="form-control" placeholder="New repository name" size="50">
                    </div>
                    <button type="submit" class="btn btn-default">Create</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Available repositories</div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                    @foreach($repositories as $repo)
                    <li role="presentation"><a href="{{ route('repo.view', $repo->name) }}">{{ $repo->name }}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
