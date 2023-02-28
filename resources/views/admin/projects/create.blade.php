@extends('layouts.admin')

@section('content')
    <div class="container">
        @include('admin.partials.editCreate', ['route' => 'admin.projects.store', 'method' => 'POST', 'title' => 'Create new project'])
    </div>
@endsection