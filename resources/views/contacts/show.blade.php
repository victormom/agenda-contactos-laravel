@extends('layouts.app')

@section('title', $contact->name . ' - Contacto')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <!-- Header con botones de acción -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('contacts.index') }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a contactos
        </a>
        
        <div class="flex gap-2">
            <a href="{{ route('contacts.edit', $contact) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            
            <form action="{{ route('contacts.toggle-favorite', $contact) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-star mr-2"></i>
                    {{ $contact->is_favorite ? 'Quitar favorito' : 'Marcar favorito' }}
                </button>
            </form>
            
            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" 
                  class="inline" onsubmit="return confirm('¿Eliminar este contacto?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-trash mr-2"></i>
                    Eliminar
                </button>
            </form>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        
        <!-- Header con foto -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-8 text-white relative">
            @if($contact->is_favorite)
                <div class="absolute top-4 right-4">
                    <i class="fas fa-star text-yellow-300 text-2xl"></i>
                </div>
            @endif
            
            <div class="flex items-center space-x-6">
                <!-- Foto -->
                @if($contact->photo)
                    <img src="{{ asset('storage/' . $contact->photo) }}" 
                         alt="{{ $contact->name }}"
                         class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                    <div class="w-32 h-32 rounded-full bg-white/20 backdrop-blur flex items-center justify-center border-4 border-white shadow-lg">
                        <span class="text-6xl font-bold">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </span>
                    </div>
                @endif

                <!-- Información básica -->
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $contact->name }}</h1>
                    @if($contact->category)
                        <span class="inline-block bg-white/20 backdrop-blur px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-tag mr-1"></i>
                            {{ $contact->category->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Información de contacto -->
        <div class="p-8 space-y-6">
            
            <!-- Email -->
            @if($contact->email)
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-blue-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-medium">Email</p>
                        <a href="mailto:{{ $contact->email }}" class="text-lg text-blue-600 hover:underline">
                            {{ $contact->email }}
                        </a>
                    </div>
                </div>
            @endif

            <!-- Teléfonos -->
            @if($contact->phoneNumbers->count() > 0)
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone text-green-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-medium mb-2">Teléfonos</p>
                        <div class="space-y-2">
                            @foreach($contact->phoneNumbers as $phone)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                    <div>
                                        <span class="text-lg font-medium">{{ $phone->number }}</span>
                                        <span class="ml-2 text-sm text-gray-500">({{ $phone->getTypeName() }})</span>
                                    </div>
                                    <a href="tel:{{ $phone->number }}" class="text-green-600 hover:text-green-700">
                                        <i class="fas fa-phone-alt"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Dirección -->
            @if($contact->address)
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-purple-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-medium">Dirección</p>
                        <p class="text-lg whitespace-pre-line">{{ $contact->address }}</p>
                    </div>
                </div>
            @endif

            <!-- Notas -->
            @if($contact->notes)
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sticky-note text-yellow-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-medium">Notas</p>
                        <p class="text-lg whitespace-pre-line">{{ $contact->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Fechas -->
            <div class="border-t pt-6 mt-6 text-sm text-gray-500">
                <p><strong>Creado:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $contact->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
