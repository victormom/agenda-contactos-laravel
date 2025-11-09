<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden llenar masivamente
     */
    protected $fillable = [
        'name',
        'email',
        'photo',
        'address',
        'notes',
        'is_favorite',
        'category_id',
    ];

    /**
     * Convertir automáticamente estos campos a tipos específicos
     * is_favorite será boolean en lugar de 0 o 1
     */
    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    /**
     * RELACIÓN: Un contacto pertenece a una categoría
     * Ejemplo: Juan pertenece a la categoría "Familia"
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * RELACIÓN: Un contacto tiene muchos números telefónicos
     * Ejemplo: Juan tiene teléfono de casa, móvil y trabajo
     */
    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    /**
     * SCOPE: Para filtrar solo contactos favoritos
     * Uso: Contact::favorites()->get()
     */
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * SCOPE: Para búsqueda por nombre o email
     * Uso: Contact::search('juan')->get()
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
    }
}
