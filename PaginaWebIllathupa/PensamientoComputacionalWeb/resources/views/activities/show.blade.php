@extends('layouts.app')
@section('title',$activity->title)@section('heading','Actividad')
@section('content')
<a class="back-link" href="{{ route('activities.index') }}">← Volver a actividades</a><div class="exercise-header"><span class="pill">{{ ucfirst($activity->dimension) }}</span><h1>{{ $activity->title }}</h1><p class="muted">{{ $activity->description }}</p></div><div class="instruction-card"><span class="instruction-icon">✦</span><div><b>Antes de comenzar</b><p>{{ $activity->instructions }}</p></div></div>
@if(auth()->user()->role==='estudiante')
@if($activity->questions->isEmpty())<div class="empty">Esta actividad aún no tiene preguntas configuradas.</div>@else
<form method="POST" action="{{ route('exercises.submit',$activity) }}">@csrf
@foreach($activity->questions as $index=>$question)<div class="question-card"><div class="question-number">PREGUNTA {{ str_pad($index+1,2,'0',STR_PAD_LEFT) }}</div><h3>{{ $question->statement }}</h3><div class="option-list">@foreach($question->options as $optionIndex=>$option)<label class="option"><input type="radio" name="answers[{{ $question->id }}]" value="{{ $optionIndex }}" required><span class="option-letter">{{ chr(65+$optionIndex) }}</span><span>{{ $option }}</span></label>@endforeach</div></div>@endforeach
<button class="btn primary submit-btn">Enviar respuestas <span>→</span></button></form>
@endif
@else
<div class="question-card"><h3>Vista de revisión</h3><p class="muted">Esta cuenta puede consultar el contenido, pero no enviar respuestas como estudiante.</p>@foreach($activity->questions as $q)<p><b>{{ $q->statement }}</b></p>@endforeach</div>
@endif
@if(auth()->user()->role==='investigadora')<div class="admin-actions"><a class="btn secondary" href="{{ route('activities.edit',$activity) }}">Editar datos</a><form method="POST" action="{{ route('activities.destroy',$activity) }}" onsubmit="return confirm('¿Eliminar esta actividad?')">@csrf @method('DELETE')<button class="btn danger">Eliminar</button></form></div>@endif
@endsection
