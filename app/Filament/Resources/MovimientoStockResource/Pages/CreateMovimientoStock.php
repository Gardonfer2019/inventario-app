<?php

namespace App\Filament\Resources\MovimientoStockResource\Pages;

use App\Filament\Resources\MovimientoStockResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimientoStock extends CreateRecord
{
    protected static string $resource = MovimientoStockResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
