<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard con estadísticas
     */
    public function index()
    {
        // Contar totales
        $totalContacts = Contact::count();
        $totalFavorites = Contact::where('is_favorite', true)->count();
        $totalCategories = Category::count();
        
        // Contactos recientes (últimos 5)
        $recentContacts = Contact::with('category')
            ->latest()
            ->take(5)
            ->get();

        // Contactos por categoría
        $contactsByCategory = Category::withCount('contacts')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->contacts_count,
                    'color' => $category->color,
                ];
            });

        return view('dashboard', compact(
            'totalContacts',
            'totalFavorites',
            'totalCategories',
            'recentContacts',
            'contactsByCategory'
        ));
    }
}
