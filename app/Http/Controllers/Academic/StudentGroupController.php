<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\StudentGroup;
use Illuminate\Http\Request;

class StudentGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentGroup::with('creator');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('level', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $studentGroups = $query->paginate(15);
        return view('academic.student-groups.index', compact('studentGroups'));
    }

    public function create()
    {
        return view('academic.student-groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'student_count' => 'required|integer|min:1',
            'special_characteristics' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $validated['created_by'] = auth()->id();
        StudentGroup::create($validated);
        return redirect()->route('academic.student-groups.index')->with('success', 'Grupo creado exitosamente');
    }

    public function show(StudentGroup $studentGroup)
    {
        return view('academic.student-groups.show', compact('studentGroup'));
    }

    public function edit(StudentGroup $studentGroup)
    {
        return view('academic.student-groups.edit', compact('studentGroup'));
    }

    public function update(Request $request, StudentGroup $studentGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'student_count' => 'required|integer|min:1',
            'special_characteristics' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $studentGroup->update($validated);
        return redirect()->route('academic.student-groups.index')->with('success', 'Grupo actualizado exitosamente');
    }

    public function destroy(StudentGroup $studentGroup)
    {
        $studentGroup->delete();
        return redirect()->route('academic.student-groups.index')->with('success', 'Grupo eliminado exitosamente');
    }
}
