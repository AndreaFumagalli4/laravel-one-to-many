@extends('layouts.admin')

@section('content')
    <div class="container">
        @include('admin.partials.editCreate', ['route' => 'admin.projects.show', 'method' => 'PUT', 'title' => 'Edit project', 'project' => $project])
    </div>
@endsection