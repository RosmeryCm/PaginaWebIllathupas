@extends('layouts.app')
@section('title',$activity->exists?'Editar actividad':'Nueva actividad')@section('heading','Gestión de actividades')
@section('content')
<a class="back-link" href="{{ route('activities.index') }}">← Volver a actividades</a><div class="page-intro"><div><span class="eyebrow">ADMINISTRACIÓN</span><h1>{{ $activity->exists?'Editar actividad':'Crear actividad' }}</h1><p class="muted">Completa la información pedagógica de la actividad.</p></div></div>
<form class="form-card" method="POST" action="{{ $activity->exists?route('activities.update',$activity):route('activities.store') }}">@csrf @if($activity->exists)@method('PUT')@endif
<label>Título de la actividad</label><input name="title" value="{{ old('title',$activity->title) }}" required maxlength="150" placeholder="Ej. Detectives de patrones">
<label>Descripción</label><textarea name="description" required rows="3">{{ old('description',$activity->description) }}</textarea>
<label>Dimensión</label><select name="dimension" required>@foreach(['descomposicion'=>'Descomposición','patrones'=>'Reconocimiento de patrones','abstraccion'=>'Abstracción','algoritmico'=>'Pensamiento algorítmico'] as $key=>$label)<option value="{{ $key }}" @selected(old('dimension',$activity->dimension)===$key)>{{ $label }}</option>@endforeach</select>
<label>Instrucciones para el estudiante</label><textarea name="instructions" required rows="4">{{ old('instructions',$activity->instructions) }}</textarea>
<label class="check publish-check"><input type="checkbox" name="published" value="1" @checked(old('published',$activity->published))> Publicar actividad para los estudiantes</label>
@if(!$activity->exists)<div class="notice">Después de crear la actividad podrás incorporar preguntas desde el módulo de contenido. Esta versión incluye preguntas demostrativas cargadas mediante el seeder.</div>@endif
<div class="form-actions"><a class="btn secondary" href="{{ route('activities.index') }}">Cancelar</a><button class="btn primary">Guardar actividad</button></div></form>
@endsection
