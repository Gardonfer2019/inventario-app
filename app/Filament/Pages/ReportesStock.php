<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\MovimientoStock;

class ReportesStock extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static string  $view            = 'filament.pages.reportes-stock';
   // protected static string  $layout          = 'filament-panels::components.layouts.app';

    public $desde;
    public $hasta;

    public function mount(): void
    {
        $this->desde = now()->startOfMonth()->toDateString();
        $this->hasta = now()->toDateString();
    }

    public function getViewData(): array
    {
        $movs = MovimientoStock::with('producto')
            ->whereBetween('fecha', [$this->desde, $this->hasta])
            ->orderBy('fecha')
            ->get()
            ->groupBy('tipo');

        $ingresos = $movs->get('ingreso')
            ?->sum(fn($m) => $m->cantidad * $m->costo_unitario)
            ?? 0;

        $egresos = $movs->get('egreso')
            ?->sum(fn($m) => $m->cantidad * $m->costo_unitario)
            ?? 0;

        return [
            'movimientos'   => $movs,
            'totalIngresos' => $ingresos,
            'totalEgresos'  => $egresos,
        ];
    }
}
