@extends('layouts.app')

@section('title', 'Dashboard - Agenda de Contactos')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Resumen de tu agenda de contactos</p>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Total de Contactos -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase">Total Contactos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalContacts }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Favoritos -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase">Favoritos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalFavorites }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-4">
                    <i class="fas fa-star text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 uppercase">Categorías</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalCategories }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-tags text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Contactos recientes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-clock text-blue-600 mr-2"></i>
                Contactos Recientes
            </h2>
            
            @if($recentContacts->count() > 0)
                <div class="space-y-3">
                    @foreach($recentContacts as $contact)
                        <a href="{{ route('contacts.show', $contact) }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition">
                            
                            <!-- Foto o inicial -->
                            @if($contact->photo)
                                <img src="{{ asset('storage/' . $contact->photo) }}" 
                                     alt="{{ $contact->name }}"
                                     class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>
                            @endif

                            <!-- Información -->
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $contact->name }}</p>
                                <p class="text-sm text-gray-500">
                                    @if($contact->category)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" 
                                              style="background-color: {{ $contact->category->color }}20; color: {{ $contact->category->color }}">
                                            {{ $contact->category->name }}
                                        </span>
                                    @endif
                                </p>
                            </div>

                            @if($contact->is_favorite)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">
                    <i class="fas fa-inbox text-4xl mb-2"></i><br>
                    No hay contactos aún
                </p>
            @endif
        </div>

        <!-- Contactos por categoría -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                Por Categoría
            </h2>
            
            <div class="space-y-3">
                @foreach($contactsByCategory as $category)
                    <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded-full" style="background-color: {{ $category['color'] }}"></div>
                            <span class="font-medium text-gray-900">{{ $category['name'] }}</span>
                        </div>
                        <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-semibold text-gray-700">
                            {{ $category['count'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
