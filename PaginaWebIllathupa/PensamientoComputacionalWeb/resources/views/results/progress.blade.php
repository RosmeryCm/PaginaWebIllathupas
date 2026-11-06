@extends('layouts.app')@section('title','Seguimiento')@section('heading','Seguimiento de estudiantes')
@section('content')
<div class="page-intro"><div><span class="eyebrow">ACOMPAÑAMIENTO PEDAGÓGICO</span><h1>Seguimiento de estudiantes</h1><p class="muted">Consulta resultados registrados para apoyar el proceso de aprendizaje.</p></div></div>
<div class="table-card"><table><thead><tr><th>Estudiante</th><th>Correo</th><th>Actividades completadas</th><th>Promedio</th></tr></thead><tbody>@foreach($students as $student)<tr><td><b>{{ $student->name }}</b></td><td>{{ $student->email }}</td><td>{{ $student->results->count() }}</td><td>{{ $student->results->count()?round($student->results->avg('percentage')).'%':'—' }}</td></tr>@endforeach</tbody></table></div><div class="pagination">{{ $students->links() }}</div>
@endsection
