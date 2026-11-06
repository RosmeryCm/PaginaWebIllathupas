<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Response as StudentResponse;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    public function submit(Request $request, Activity $activity)
    {
        abort_unless($activity->published, 404);
        $activity->load('questions');
        $data = $request->validate(['answers' => ['required', 'array'], 'answers.*' => ['required', 'integer', 'min:0', 'max:10']]);
        abort_if($activity->questions->isEmpty(), 422, 'Esta actividad todavía no tiene preguntas.');

        $score = 0;
        $feedback = [];
        DB::transaction(function () use ($request, $activity, $data, &$score, &$feedback) {
            foreach ($activity->questions as $question) {
                $selected = (int) ($data['answers'][$question->id] ?? -1);
                $correct = $selected === (int) $question->correct_option;
                if ($correct) $score++;
                StudentResponse::create([
                    'user_id' => $request->user()->id,
                    'activity_id' => $activity->id,
                    'question_id' => $question->id,
                    'selected_option' => $selected,
                    'is_correct' => $correct,
                ]);
                $feedback[] = ['question' => $question->statement, 'correct' => $correct,
                    'message' => $correct ? $question->feedback_correct : $question->feedback_incorrect,
                    'correct_answer' => $question->options[$question->correct_option] ?? 'No definida'];
            }
            $total = $activity->questions->count();
            Result::create([
                'user_id' => $request->user()->id, 'activity_id' => $activity->id,
                'score' => $score, 'total_questions' => $total,
                'percentage' => round(($score / $total) * 100, 2), 'completed_at' => now(),
            ]);
        });

        return view('activities.feedback', [
            'activity' => $activity, 'feedback' => $feedback,
            'score' => $score, 'total' => $activity->questions->count(),
            'percentage' => round(($score / $activity->questions->count()) * 100),
        ]);
    }
}
