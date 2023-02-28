@extends('layouts.admin')

@section('content')

    @include('admin.partials.popup')

    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>
                                Projects:
                            </h2>
                        </div>
                        @if (count($projects))
                        <form class="d-inline delete double-confirm" action="{{route('admin.projects.restore-all')}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" title="restore all"><i class="fa-solid fa-recycle"></i>&nbsp;Restore all</button>
                        </form>            
                        @endif   
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-hover table-borderless mt-3">
            <thead>
                <tr>
                    <th scope="col">#id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>
                        <a href="{{ route('admin.projects.restore', $project->id) }}" class="btn btn-sm btn-success">
                            Restore
                        </a>
                        <form action="{{ route('admin.projects.force-delete', $project->id) }}" method="POST" class="d-inline-block delete form-deleter double-confirm" data-element-name="{{ $project->title }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/deleteHandler.js')
@endsection