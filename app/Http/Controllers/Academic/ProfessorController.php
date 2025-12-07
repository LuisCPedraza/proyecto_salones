<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use App\Models\User;
use App\Models\ProfessorAvailability;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index(Request $request)
    {
        $query = Professor::with('user', 'creator');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $professors = $query->paginate(15);
        return view('academic.professors.index', compact('professors'));
    }

    public function create()
    {
        $users = User::where('role', 'profesor')->get();
        return view('academic.professors.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:professors',
            'specialties' => 'required|string',
            'cv_path' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:active,inactive,on_leave',
        ]);
        $validated['created_by'] = auth()->id();
        if ($request->hasFile('cv_path')) {
            $validated['cv_path'] = $request->file('cv_path')->store('cvs', 'public');
        }
        $validated['specialties'] = explode(',', $validated['specialties']);
        Professor::create($validated);
        return redirect()->route('academic.professors.index')->with('success', 'Profesor registrado exitosamente');
    }

    public function show(Professor $professor)
    {
        $availabilities = $professor->availabilities()->get();
        return view('academic.professors.show', compact('professor', 'availabilities'));
    }

    public function edit(Professor $professor)
    {
        $users = User::where('role', 'profesor')->get();
        return view('academic.professors.edit', compact('professor', 'users'));
    }

    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'specialties' => 'required|string',
            'cv_path' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:active,inactive,on_leave',
        ]);
        if ($request->hasFile('cv_path')) {
            $validated['cv_path'] = $request->file('cv_path')->store('cvs', 'public');
        }
        $validated['specialties'] = explode(',', $validated['specialties']);
        $professor->update($validated);
        return redirect()->route('academic.professors.index')->with('success', 'Profesor actualizado exitosamente');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('academic.professors.index')->with('success', 'Profesor eliminado exitosamente');
    }

    public function availability(Professor $professor)
    {
        $availabilities = $professor->availabilities()->get();
        return view('academic.professors.availability', compact('professor', 'availabilities'));
    }

    public function updateAvailability(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|between:0,5',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,unavailable',
        ]);
        ProfessorAvailability::updateOrCreate(
            [
                'professor_id' => $professor->id,
                'day_of_week' => $validated['day_of_week'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ],
            ['status' => $validated['status']]
        );
        return back()->with('success', 'Disponibilidad actualizada exitosamente');
    }
}
