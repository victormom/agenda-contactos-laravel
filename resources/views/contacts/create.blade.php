@extends('layouts.app')

@section('title', 'Nuevo Contacto')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Nuevo Contacto</h1>
    
    <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf
        
        <div>
            <label class="block font-medium mb-1">Nombre *</label>
            <input type="text" name="name" required class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block font-medium mb-1">Foto</label>
            <input type="file" name="photo" accept="image/*" class="w-full">
        </div>
        
        <div>
            <label class="block font-medium mb-1">Categoría</label>
            <select name="category_id" class="w-full border rounded px-3 py-2">
                <option value="">Sin categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block font-medium mb-1">Teléfono</label>
            <input type="text" name="phone_numbers[0][number]" class="w-full border rounded px-3 py-2">
            <input type="hidden" name="phone_numbers[0][type]" value="mobile">
        </div>
        
        <div>
            <label class="block font-medium mb-1">Dirección</label>
            <textarea name="address" rows="3" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        
        <div>
            <label class="block font-medium mb-1">Notas</label>
            <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Guardar</button>
            <a href="{{ route('contacts.index') }}" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">Cancelar</a>
        </div>
    </form>
</div>
@endsection
