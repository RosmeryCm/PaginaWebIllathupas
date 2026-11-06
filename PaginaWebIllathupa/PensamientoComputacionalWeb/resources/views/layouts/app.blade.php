<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Panel') · Pensamiento Computacional</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="app-shell">
  @auth
  <aside class="sidebar">
    <a class="brand" href="{{ route('dashboard') }}"><span class="brand-mark">PC</span><span><b>Pensamiento</b><small>Computacional · UDH</small></span></a>
    <div class="side-label">MENÚ PRINCIPAL</div>
    <nav class="nav">
      <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span>⌂</span> Panel principal</a>
      <a class="{{ request()->routeIs('activities.*') ? 'active' : '' }}" href="{{ route('activities.index') }}"><span>▤</span> Actividades</a>
      @if(auth()->user()->role === 'estudiante')
        <a class="{{ request()->routeIs('results.mine') ? 'active' : '' }}" href="{{ route('results.mine') }}"><span>◷</span> Mis resultados</a>
      @endif
      @if(in_array(auth()->user()->role, ['docente','investigadora']))
        <a class="{{ request()->routeIs('results.progress') ? 'active' : '' }}" href="{{ route('results.progress') }}"><span>▥</span> Seguimiento</a>
      @endif
      @if(auth()->user()->role === 'investigadora')
        <div class="side-label">ADMINISTRACIÓN</div>
        <a class="{{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><span>♙</span> Usuarios y roles</a>
        <a href="{{ route('activities.create') }}"><span>＋</span> Nueva actividad</a>
      @endif
    </nav>
    <div class="sidebar-bottom"><div class="help-card"><div class="help-icon">✦</div><b>Aprender haciendo</b><p>Desarrolla habilidades para resolver problemas paso a paso.</p></div></div>
  </aside>
  @endauth
  <main class="main-area">
    @auth
    <header class="topbar">
      <div><span class="eyebrow">INSTITUCIÓN EDUCATIVA ILLATHUPA</span><div class="top-title">@yield('heading', 'Panel principal')</div></div>
      <div class="user-menu"><div class="avatar">{{ mb_substr(auth()->user()->name,0,1) }}</div><div class="user-meta"><b>{{ auth()->user()->name }}</b><small>{{ ucfirst(auth()->user()->role) }}</small></div><form method="POST" action="{{ route('logout') }}">@csrf<button class="logout" title="Cerrar sesión">↗</button></form></div>
    </header>
    @endauth
    <section class="page-content">
      @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
      @if($errors->any())<div class="alert error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
      @yield('content')
    </section>
    <footer class="footer">© {{ date('Y') }} · Sistema web interactivo de pensamiento computacional <span>Universidad de Huánuco</span></footer>
  </main>
</div>
</body></html>
