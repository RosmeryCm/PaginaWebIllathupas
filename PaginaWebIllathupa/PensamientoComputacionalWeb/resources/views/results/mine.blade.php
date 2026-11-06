@extends('layouts.app')@section('title','Mis resultados')@section('heading','Mis resultados')
@section('content')
<div class="page-intro"><div><span class="eyebrow">MI PROGRESO</span><h1>Mis resultados</h1><p class="muted">Consulta el historial de tus actividades y los resultados obtenidos.</p></div></div>
<div class="table-card"><table><thead><tr><th>Actividad</th><th>Dimensión</th><th>Resultado</th><th>Fecha</th></tr></thead><tbody>@forelse($results as $result)<tr><td><b>{{ $result->activity->title }}</b></td><td>{{ ucfirst($result->activity->dimension) }}</td><td><span class="result-score">{{ $result->score }}/{{ $result->total_questions }} · {{ round($result->percentage) }}%</span></td><td>{{ $result->completed_at->format('d/m/Y H:i') }}</td></tr>@empty<tr><td colspan="4" class="empty">Aún no tienes resultados. ¡Realiza una actividad para comenzar!</td></tr>@endforelse</tbody></table></div><div class="pagination">{{ $results->links() }}</div>
@endsection
