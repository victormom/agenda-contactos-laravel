@extends('layouts.app')

@section('title', 'Contactos')

@section('content')
<div>
    <h1 class="text-3xl font-bold mb-6">Contactos</h1>
    
    @if($contacts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($contacts as $contact)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-bold text-lg">{{ $contact->name }}</h3>
                    <p class="text-gray-600">{{ $contact->email }}</p>
                    <a href="{{ route('contacts.show', $contact) }}" class="text-blue-600">Ver detalles</a>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $contacts->links() }}
        </div>
    @else
        <div class="bg-white p-12 rounded-lg shadow text-center">
            <p class="text-gray-600 mb-4">No hay contactos</p>
            <a href="{{ route('contacts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Crear Contacto</a>
        </div>
    @endif
</div>
@endsection
