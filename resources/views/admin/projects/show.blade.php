@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card text-center mt-3">
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
                    @if (str_starts_with($project->thumb, 'http'))
                        <img src="{{ $project->thumb }}"
                    @else 
                        <img src="{{ asset('storage/' . $project->thumb) }}"
                    @endif
                        alt="Project image" class="img-fluid mt-3">
                </div>
                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-success">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
                <a href="{{ $project->link }}" class="btn btn-sm btn-info">
                    Go to the project repository
                </a>
                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline-block form-deleter" data-element-name="{{ $project->title }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/deleteHandler.js')
@endsection