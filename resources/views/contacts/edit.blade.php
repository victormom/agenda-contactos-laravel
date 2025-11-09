@extends('layouts.app')

@section('title', 'Editar ' . $contact->name)

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="mb-6">
        <a href="{{ route('contacts.show', $contact) }}" class="text-blue-600 hover:text-blue-700 mb-2 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver al contacto
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Editar Contacto</h1>
        <p class="text-gray-600 mt-1">Actualiza la información de {{ $contact->name }}</p>
    </div>

    <form action="{{ route('contacts.update', $contact) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Foto actual y nueva -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto de Perfil</label>
            <div class="flex items-center space-x-4">
                <div id="preview" class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                    @if($contact->photo)
                        <img src="{{ asset('storage/' . $contact->photo) }}" class="w-full h-full object-cover" id="current-photo">
                    @else
                        <i class="fas fa-user text-gray-400 text-3xl"></i>
                    @endif
                </div>
                <div>
                    <input type="file" name="photo" id="photo" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF hasta 2MB</p>
                </div>
            </div>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                Nombre Completo <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $contact->name) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $contact->email) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
            <select name="category_id" id="category_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Sin categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $contact->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Números Telefónicos -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Números Telefónicos</label>
            <div id="phone-container" class="space-y-3">
                @foreach($contact->phoneNumbers as $index => $phone)
                    <div class="flex gap-2 phone-row">
                        <select name="phone_numbers[{{ $index }}][type]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="mobile" {{ $phone->type == 'mobile' ? 'selected' : '' }}>Móvil</option>
                            <option value="home" {{ $phone->type == 'home' ? 'selected' : '' }}>Casa</option>
                            <option value="work" {{ $phone->type == 'work' ? 'selected' : '' }}>Trabajo</option>
                        </select>
                        <input type="text" name="phone_numbers[{{ $index }}][number]" value="{{ $phone->number }}"
                               placeholder="Número telefónico"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <button type="button" onclick="removePhone(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach
                
                @if($contact->phoneNumbers->count() == 0)
                    <div class="flex gap-2 phone-row">
                        <select name="phone_numbers[0][type]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="mobile">Móvil</option>
                            <option value="home">Casa</option>
                            <option value="work">Trabajo</option>
                        </select>
                        <input type="text" name="phone_numbers[0][number]" placeholder="Número telefónico"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <button type="button" onclick="removePhone(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" onclick="addPhone()"
                    class="mt-3 inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                <i class="fas fa-plus mr-2"></i>
                Agregar teléfono
            </button>
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
            <textarea name="address" id="address" rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $contact->address) }}</textarea>
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
            <textarea name="notes" id="notes" rows="4" placeholder="Información adicional..."
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $contact->notes) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('contacts.show', $contact) }}" 
               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <i class="fas fa-save mr-2"></i>
                Actualizar Contacto
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>
    let phoneIndex = {{ $contact->phoneNumbers->count() }};

    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').innerHTML = 
                    `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(file);
        }
    });

    function addPhone() {
        const container = document.getElementById('phone-container');
        const newPhone = document.createElement('div');
        newPhone.className = 'flex gap-2 phone-row';
        newPhone.innerHTML = `
            <select name="phone_numbers[${phoneIndex}][type]" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="mobile">Móvil</option>
                <option value="home">Casa</option>
                <option value="work">Trabajo</option>
            </select>
            <input type="text" name="phone_numbers[${phoneIndex}][number]" placeholder="Número telefónico"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <button type="button" onclick="removePhone(this)" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newPhone);
        phoneIndex++;
    }

    function removePhone(button) {
        const rows = document.querySelectorAll('.phone-row');
        if (rows.length > 1) {
            button.closest('.phone-row').remove();
        } else {
            alert('Debe haber al menos un campo de teléfono');
        }
    }
</script>
@endpush
@endsection
