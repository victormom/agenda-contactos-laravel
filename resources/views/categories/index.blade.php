@extends('layouts.app')

@section('title', 'Categorías - Agenda')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Categorías</h1>
            <p class="text-gray-600 mt-1">Organiza tus contactos por categorías</p>
        </div>
    </div>

    <!-- Grid de categorías -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden border-l-4" 
                 style="border-color: {{ $category->color }}">
                
                <div class="p-6">
                    <!-- Color y nombre -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" 
                                 style="background-color: {{ $category->color }}20">
                                <i class="fas fa-tag" style="color: {{ $category->color }}"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $category->name }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Contador de contactos -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <span class="text-sm text-gray-600">Contactos</span>
                        <span class="text-2xl font-bold" style="color: {{ $category->color }}">
                            {{ $category->contacts_count }}
                        </span>
                    </div>

                    <!-- Botón ver contactos -->
                    <a href="{{ route('contacts.index', ['category' => $category->id]) }}" 
                       class="mt-4 block w-full text-center px-4 py-2 rounded-lg font-medium transition"
                       style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                        <i class="fas fa-eye mr-2"></i>
                        Ver contactos
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Si no hay categorías -->
    @if($categories->count() == 0)
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-tags text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay categorías</h3>
            <p class="text-gray-600">Las categorías se crean automáticamente con los seeders</p>
        </div>
    @endif

</div>
@endsection
