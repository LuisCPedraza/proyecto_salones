<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\StudentGroup;
use App\Models\Professor;
use App\Models\Classroom;
use App\Models\AssignmentHistory;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::with('studentGroup', 'professor', 'classroom');
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $assignments = $query->paginate(15);
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $studentGroups = StudentGroup::where('status', 'active')->get();
        $professors = Professor::where('status', 'active')->get();
        $classrooms = Classroom::where('status', 'available')->get();
        return view('assignments.create', compact('studentGroups', 'professors', 'classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_group_id' => 'required|exists:student_groups,id',
            'professor_id' => 'required|exists:professors,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'day_of_week' => 'required|integer|between:0,5',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject' => 'nullable|string|max:255',
            'semester' => 'required|string|max:50',
            'status' => 'required|in:active,cancelled,pending',
        ]);
        $validated['created_by'] = auth()->id();
        $validated['assignment_type'] = 'manual';
        $assignment = Assignment::create($validated);
        AssignmentHistory::create([
            'assignment_id' => $assignment->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'ip_address' => $request->ip(),
        ]);
        return redirect()->route('assignments.assignments.index')->with('success', 'Asignación creada exitosamente');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load('studentGroup', 'professor', 'classroom', 'creator', 'histories');
        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $studentGroups = StudentGroup::where('status', 'active')->get();
        $professors = Professor::where('status', 'active')->get();
        $classrooms = Classroom::where('status', 'available')->get();
        return view('assignments.edit', compact('assignment', 'studentGroups', 'professors', 'classrooms'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'student_group_id' => 'required|exists:student_groups,id',
            'professor_id' => 'required|exists:professors,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'day_of_week' => 'required|integer|between:0,5',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject' => 'nullable|string|max:255',
            'semester' => 'required|string|max:50',
            'status' => 'required|in:active,cancelled,pending',
        ]);
        $changes = $assignment->getChanges();
        $assignment->update($validated);
        AssignmentHistory::create([
            'assignment_id' => $assignment->id,
            'user_id' => auth()->id(),
            'action' => 'updated',
            'changes' => $changes,
            'ip_address' => $request->ip(),
        ]);
        return redirect()->route('assignments.assignments.index')->with('success', 'Asignación actualizada exitosamente');
    }

    public function destroy(Assignment $assignment)
    {
        AssignmentHistory::create([
            'assignment_id' => $assignment->id,
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'ip_address' => request()->ip(),
        ]);
        $assignment->delete();
        return redirect()->route('assignments.assignments.index')->with('success', 'Asignación eliminada exitosamente');
    }

    public function mySchedule()
    {
        $user = auth()->user();
        if ($user->role === 'profesor') {
            $professor = $user->professor;
            $assignments = $professor ? $professor->assignments()->where('status', 'active')->get() : [];
        } else {
            $assignments = [];
        }
        return view('schedules.my-schedule', compact('assignments'));
    }

    public function semesterSchedule(Request $request)
    {
        $semester = $request->query('semester', '2025-1');
        $assignments = Assignment::where('semester', $semester)->where('status', 'active')->with('studentGroup', 'professor', 'classroom')->get();
        return view('schedules.semester-schedule', compact('assignments', 'semester'));
    }

    public function automatic(Request $request)
    {
        $validated = $request->validate([
            'semester' => 'required|string|max:50',
        ]);
        return back()->with('success', 'Asignación automática completada');
    }
}
