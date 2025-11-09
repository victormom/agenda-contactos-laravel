<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Rutas de la Aplicación
|--------------------------------------------------------------------------
*/

// Ruta principal - Redirige al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});



// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// CRUD Completo de Contactos
Route::resource('contacts', ContactController::class);

// Ruta adicional para marcar/desmarcar favoritos
Route::patch('/contacts/{contact}/toggle-favorite', [ContactController::class, 'toggleFavorite'])
    ->name('contacts.toggle-favorite');

// Categorías
Route::resource('categories', CategoryController::class)->only(['index']);
Route::get('/debug-contacts', function () {
    try {
        $contacts = \App\Models\Contact::paginate(10);
        $categories = \App\Models\Category::all();
        
        return [
            'contacts_count' => $contacts->count(),
            'categories_count' => $categories->count(),
            'view_exists_index' => view()->exists('contacts.index'),
            'view_exists_create' => view()->exists('contacts.create'),
            'layout_exists' => view()->exists('layouts.app'),
        ];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
});
// ... todo el código anterior ...

Route::get('/debug-contacts', function () {
    try {
        $contacts = \App\Models\Contact::paginate(10);
        $categories = \App\Models\Category::all();
        
        return [
            'contacts_count' => $contacts->count(),
            'categories_count' => $categories->count(),
            'view_exists_index' => view()->exists('contacts.index'),
            'view_exists_create' => view()->exists('contacts.create'),
            'layout_exists' => view()->exists('layouts.app'),
        ];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
});

Route::get('/test-controller', function () {
    try {
        $controller = new \App\Http\Controllers\ContactController();
        return ['controller_exists' => true];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()];
    }
});
