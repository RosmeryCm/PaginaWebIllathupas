@extends('layouts.app')
@section('title','Retroalimentación')@section('heading','Resultado de actividad')
@section('content')
<div class="feedback-hero"><div class="score-ring"><strong>{{ $percentage }}%</strong><small>tu resultado</small></div><span class="eyebrow">ACTIVIDAD COMPLETADA</span><h1>{{ $percentage >= 70 ? '¡Excelente esfuerzo!' : '¡Sigue practicando!' }}</h1><p class="muted">Obtuviste {{ $score }} respuestas correctas de {{ $total }}. Cada intento es una oportunidad para aprender.</p><div class="feedback-actions"><a class="btn primary" href="{{ route('activities.index') }}">Ver más actividades</a><a class="btn secondary" href="{{ route('results.mine') }}">Mis resultados</a></div></div>
<div class="section-head"><div><span class="eyebrow">APRENDE DE TU INTENTO</span><h2>Tu retroalimentación</h2></div></div>
@foreach($feedback as $item)<div class="feedback-row"><span class="feedback-status {{ $item['correct']?'good':'bad' }}">{{ $item['correct']?'✓':'!' }}</span><div><b>{{ $item['question'] }}</b><p>{{ $item['message'] }}</p>@if(!$item['correct'])<small>Respuesta esperada: {{ $item['correct_answer'] }}</small>@endif</div></div>@endforeach
@endsection
