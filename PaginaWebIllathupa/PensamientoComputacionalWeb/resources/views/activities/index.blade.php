@extends('layouts.app')
@section('title','Actividades')@section('heading','Actividades')
@section('content')
<div class="page-intro"><div><span class="eyebrow">APRENDE A TU RITMO</span><h1>Actividades</h1><p class="muted">Explora ejercicios diseñados para fortalecer tu pensamiento computacional.</p></div>@if(auth()->user()->role==='investigadora')<a class="btn primary" href="{{ route('activities.create') }}">＋ Nueva actividad</a>@endif</div>
<div class="activity-catalog">@forelse($activities as $activity)<a class="catalog-card" href="{{ route('activities.show',$activity) }}"><div class="catalog-visual"><span>{{ str_pad($activity->id,2,'0',STR_PAD_LEFT) }}</span><b>{{ ['descomposicion'=>'▦','patrones'=>'⌘','abstraccion'=>'◇','algoritmico'=>'⇢'][$activity->dimension] }}</b></div><div class="catalog-body"><span class="pill">{{ ucfirst($activity->dimension) }}</span><h3>{{ $activity->title }}</h3><p>{{ $activity->description }}</p><div class="catalog-foot"><small>{{ $activity->questions_count }} pregunta(s)</small><b>Comenzar →</b></div></div></a>@empty<div class="empty">No hay actividades disponibles.</div>@endforelse</div>
<div class="pagination">{{ $activities->links() }}</div>
@endsection
