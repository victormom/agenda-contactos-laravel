<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden llenar masivamente
     */
    protected $fillable = [
        'contact_id',
        'type',
        'number',
    ];

    /**
     * RELACIÓN: Un número telefónico pertenece a un contacto
     * Ejemplo: El teléfono 555-1234 pertenece a Juan
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Obtener el nombre legible del tipo de teléfono
     * Uso: $phone->getTypeName() retorna "Móvil" en lugar de "mobile"
     */
    public function getTypeName()
    {
        $types = [
            'mobile' => 'Móvil',
            'home' => 'Casa',
            'work' => 'Trabajo',
        ];

        return $types[$this->type] ?? $this->type;
    }
}
