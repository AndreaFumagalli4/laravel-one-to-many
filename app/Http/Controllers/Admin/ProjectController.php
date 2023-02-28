<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(10);
        $trashed = Project::onlyTrashed()->get()->count();
        return view('admin.projects.index', compact('projects', 'trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create', [ 'project' => new Project(), 'types' => Type::all() ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:2|max:80|unique:projects',
            'thumb' => 'required|image|max:500',
            'used_language' => 'required|max:255',
            'link' => 'required|active_url',
            'type_id' => 'required|exists:types,id'
        ]);
        $data['thumb'] = Storage::put('imgs/', $data['thumb']);
        
        $newProject = new Project();
        $newProject->fill($data);
        $newProject->save();
        
        return redirect()->route('admin.projects.show', $newProject->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['project' => $project, 'types' => Type::all()]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => ['required', 'min:2', 'max:80', Rule::unique('projects')->ignore($project->id)],
            'thumb' => 'required|image|max:500',
            'used_language' => 'required|max:255',
            'link' => 'required|active_url',
            'type_id' => 'required|exists:types,id'
        ]);

        if ($request->hasFile('thumb')){

            if(!$project->isImageAUrl()){
                Storage::delete($project->thumb);
            }
            $data['thumb'] = Storage::put('imgs/', $data['thumb']);
        }

        $project->update($data);
        return redirect()->route('admin.projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', 'Moved to trash')->with('alert-type', 'alert-danger');
    }

    /**
     * Display a list of trasshed resources
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trashed', compact('projects'));
    }

    /**
     * Restore project data
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Project::where('id', $id)->withTrashed()->restore();
        return redirect()->route('admin.projects.index')->with('message', "Restored successfully")->with('alert-type', 'alert-success');
    }

    /**
     * Restore all project data
     *
     * @return \Illuminate\Http\Response
     */
    public function restoreAll()
    {
        Project::onlyTrashed()->restore();
        return redirect()->route('admin.projects.index')->with('message', "All project restored successfully")->with('alert-type', 'alert-success');
    }

    /**
     * Force delete project data
     *
    //  * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        // if(!$project->isImageAUrl()) {
        //     Storage::delete($project->thumb);
        // }

        Project::where('id', $id)->withTrashed()->forceDelete();
        return redirect()->route('admin.projects.index')->with('message', "Delete definetely")->with('alert-type', 'alert-danger');
    }
}
