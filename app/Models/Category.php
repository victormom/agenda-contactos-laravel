<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Los campos que se pueden llenar masivamente
     * Esto protege contra asignación masiva no deseada
     */
    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * RELACIÓN: Una categoría tiene muchos contactos
     * Ejemplo: La categoría "Familia" puede tener 10 contactos
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
