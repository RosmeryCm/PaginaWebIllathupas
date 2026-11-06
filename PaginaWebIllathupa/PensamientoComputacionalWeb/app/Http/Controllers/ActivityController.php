<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::withCount('questions')->latest();
        if ($request->user()->role === 'estudiante') $query->where('published', true);
        return view('activities.index', ['activities' => $query->paginate(9)]);
    }

    public function show(Request $request, Activity $activity)
    {
        abort_if($request->user()->role === 'estudiante' && !$activity->published, 403);
        $activity->load('questions');
        return view('activities.show', compact('activity'));
    }

    public function create() { return view('activities.form', ['activity' => new Activity()]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $activity = Activity::create($data);
        foreach ($request->input('questions', []) as $question) {
            if (filled($question['statement'] ?? null)) $activity->questions()->create($this->questionData($question));
        }
        return redirect()->route('activities.index')->with('success', 'Actividad creada correctamente.');
    }

    public function edit(Activity $activity) { $activity->load('questions'); return view('activities.form', compact('activity')); }

    public function update(Request $request, Activity $activity)
    {
        $activity->update($this->validated($request));
        return redirect()->route('activities.show', $activity)->with('success', 'Actividad actualizada. Para modificar preguntas, crea una nueva actividad o amplía el módulo de edición.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Actividad eliminada.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:1000'],
            'dimension' => ['required', Rule::in(['descomposicion', 'patrones', 'abstraccion', 'algoritmico'])],
            'instructions' => ['required', 'string', 'max:3000'],
            'published' => ['nullable', 'boolean'],
        ]) + ['published' => $request->boolean('published')];
    }

    private function questionData(array $q): array
    {
        return [
            'statement' => $q['statement'],
            'options' => array_values(array_filter($q['options'] ?? [])),
            'correct_option' => (int) ($q['correct_option'] ?? 0),
            'feedback_correct' => $q['feedback_correct'] ?? '¡Excelente trabajo!',
            'feedback_incorrect' => $q['feedback_incorrect'] ?? 'Revisa el concepto e inténtalo nuevamente.',
        ];
    }
}
