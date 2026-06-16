@extends('Layouts.app')

@section('title')
    Administra tus Presupuestos
@endsection

@php

    $name = auth()->user()->name;

    $greetings = [
        "Qué tal, $name",
        "Nuevos planes, $name?",
        "Buen día, $name",
        "Cómo va todo, $name?",
        "Bienvenido de nuevo, $name",
        "Listo para el día, $name?",
        "Qué hay de nuevo, $name?",
        "Todo en orden, $name?",
        "Por dónde empezamos, $name?",
        "Qué tienes para hoy, $name?",
        "$name, cuántos presupuestos hoy?",
        "$name, todo listo?",
        "$name, qué vamos a lograr hoy?",
        "$name, en qué andamos?",
        "$name, hay trabajo que hacer",
        "Aquí estamos, $name",
        "Otro día, otra oportunidad, $name",
        "Cuéntame, $name, qué sigue?",
        "De vuelta por aquí, $name",
        "Empecemos, $name",
    ];

    $greeting = $greetings[array_rand($greetings)];
@endphp

@section('actions')
    <h1 class="text-8xl text-purple-secondary font-bold tracking-tighter text-center mt-10">{{$greeting}}</h1>

    <div class="sm:flex sm:items-center mt-10">
<div class="sm:flex-auto">
    <h1 class="text-4xl font-bold tracking-tight text-purple-secondary text-center lg:text-start">
        Administra tus Presupuestos
    </h1>
    <p class="mt-2 text-lg text-gray-400 text-center lg:text-start">
        Gestiona todos tus planes financieros en esta sección.
    </p>
</div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('budgets.create') }}"
               class="block bg-purple-principal hover:bg-purple-principal-hover transition-all duration-200 text-white w-full px-5 py-3 rounded-2xl  font-bold  text-xl cursor-pointer text-center">Nuevo
                Presupuesto</a>
        </div>
    </div>
@endsection

@section('dashboardContents')

    @if (count($budgets) > 0)
        <div class="mt-8 grid grid-cols-1 gap-6">
            @foreach ($budgets as $budget)
                <div class="relative my-5 rounded-4xl ring-3 overflow-hidden
                {{ $budget->isGeneral() ? 'ring-general-projects' : 'ring-purple-secondary' }}">

                    {{-- Badge tipo --}}
                    <p class="absolute top-0 left-0 inline-block px-8 py-2 rounded-br-2xl text-lg
                    {{ $budget->isGeneral() ? 'bg-general-projects text-purple-principal font-bold' : 'bg-purple-secondary text-purple-principal-hover font-bold' }}">
                        {{ $budget->isGeneral() ? 'General' : 'Proyecto' }}
                    </p>

                    {{-- Contenido --}}
                    <div class="flex items-center justify-between pt-14 pb-12 px-12">
                        <div>
                            <a class="text-5xl mt-5 tracking-tighter font-bold block
                            {{ $budget->isGeneral() ? 'text-general-projects' : 'text-purple-secondary' }}"
                               href="{{ route('budgets.show', $budget) }}">{{ $budget->name }}</a>
                            <p class="text-xl lg:text-3xl font-bold {{$budget->isGeneral() ? 'text-general-projects' : 'text-purple-secondary'}} mt-4">
                                Presupuesto: ${{ $budget->amount }}</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-budget-dropdown :budget="$budget"
                                               :color="$budget->isGeneral() ? 'text-general-projects' : 'text-purple-secondary'"
                                               :hover-color="$budget->isGeneral() ? 'hover:bg-general-projects' : 'hover:bg-purple-secondary'"
                            />

                            <x-confirm-delete :id="'delete-dialog-'.$budget->id"
                                              :title="'Eliminar Presupuesto: '.$budget->name"
                                              message="Esta accion no se puede deshacer"
                                              :action="route('budgets.destroy', $budget)"/>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-xl mt-10">No Hay Presupuestos.
            <a href="{{ route('budgets.create') }}" class="text-amber-500">Comienza creando uno</a>
        </p>
    @endif
@endsection
