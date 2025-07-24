<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'sku',
        'nombre',
        'descripcion',
        'costo_unitario',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoStock::class);
    }

    public function getStockAttribute()
    {
        $saldo = $this->movimientos()
            ->selectRaw("SUM(CASE WHEN tipo = 'ingreso' THEN cantidad ELSE -cantidad END) as stock")
            ->value('stock');

        return $saldo ?? 0;
    }
}
