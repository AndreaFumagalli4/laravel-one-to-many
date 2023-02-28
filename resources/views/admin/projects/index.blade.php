@extends('layouts.admin')

@section('content')

    @include('admin.partials.popup')

    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                @if (session('message'))
                    <div class="alert {{session('alert-type')}}">
                        {{session('message')}}
                    </div>
                @endif
            </div>
            <div class="col-12">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>
                                Projects:
                            </h2>
                        </div>
                        <div>
                            @if($trashed)
                            <a href="{{ route('admin.projects.tashed') }}" class="btn btn-sm btn-warning">
                                <b>{{$trashed}}</b> item/s in recycled bin 
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-borderless mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Title</th>
                            <th scope="col">used_language</th>
                            <th scope="col">project_date</th>
                            <th scope="col">
                                <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-info">
                                    Create new project
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        <tr>
                            <th scope="row">{{ $project->id }}</th>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->used_language }}</td>
                            <td>{{ $project->project_date }}</td>
                            <td>
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-success">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline-block delete" data-element-name="{{ $project->title }}">
                                    @csrf
                                    @method('DELETE')
        
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $projects->links() }}
    </div>
@endsection

@section('scripts')
    @vite('resources/js/deleteHandler.js')
@endsection