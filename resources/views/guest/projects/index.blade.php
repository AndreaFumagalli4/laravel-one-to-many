@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($projects as $project)
        <div class="card text-center mt-5">
            <div class="card-header">
                Type : <span class="fw-bold">{{ $project->type->name }}</span>
            </div>
            <div class="card-body">
                <h2 class="card-title fw-bold">
                    {{ $project->title }}
                </h2>
                <p class="mt-4">
                    Language used: {{ $project->used_language }}
                </p>
                <div class="my-4">
                    <img src="{{ asset('storage/' . $project->thumb) }}" alt="Project image" class="img-fluid">
                </div>
                <a href="{{ $project->link }}" class="btn btn-sm btn-info">
                    Go to the project repository
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endsection