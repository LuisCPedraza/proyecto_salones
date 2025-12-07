<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomAvailability;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::with('creator');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('location', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $classrooms = $query->paginate(15);
        return view('infrastructure.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('infrastructure.classrooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:classrooms|max:255',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'resources' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:available,maintenance,unavailable',
        ]);
        $validated['created_by'] = auth()->id();
        if ($request->filled('resources')) {
            $validated['resources'] = explode(',', $validated['resources']);
        }
        Classroom::create($validated);
        return redirect()->route('infrastructure.classrooms.index')->with('success', 'Salón creado exitosamente');
    }

    public function show(Classroom $classroom)
    {
        $availabilities = $classroom->availabilities()->get();
        $restrictions = $classroom->restrictions()->get();
        return view('infrastructure.classrooms.show', compact('classroom', 'availabilities', 'restrictions'));
    }

    public function edit(Classroom $classroom)
    {
        return view('infrastructure.classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name,' . $classroom->id,
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'resources' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:available,maintenance,unavailable',
        ]);
        if ($request->filled('resources')) {
            $validated['resources'] = explode(',', $validated['resources']);
        }
        $classroom->update($validated);
        return redirect()->route('infrastructure.classrooms.index')->with('success', 'Salón actualizado exitosamente');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('infrastructure.classrooms.index')->with('success', 'Salón eliminado exitosamente');
    }
}
