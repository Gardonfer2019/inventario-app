<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimientoStockResource\Pages;
use App\Filament\Resources\MovimientoStockResource\RelationManagers;
use App\Models\MovimientoStock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\BadgeColumn;

class MovimientoStockResource extends Resource
{
    protected static ?string $model = MovimientoStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Inventario';
    protected static ?string $navigationLabel = 'Movimientos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                ->default(fn () => auth()->id()),
                Forms\Components\Select::make('producto_id')
                    ->label('Producto')
                    ->relationship('producto', 'nombre')
                    ->searchable()
                    ->required(),
                Forms\Components\Radio::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'ingreso' => 'Ingreso',
                        'egreso'  => 'Egreso',
                    ])
                    ->required()
                    ->inline(),
                Forms\Components\TextInput::make('cantidad')
                    ->label('Cantidad')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('costo_unitario')
                    ->label('Costo Unitario')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('referencia')
                    ->label('Referencia')
                    ->nullable()
                    ->maxLength(100),
                Forms\Components\DatePicker::make('fecha')
                    ->label('Fecha')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('producto.sku')->label('SKU'),
                Tables\Columns\TextColumn::make('producto.nombre')->label('Producto'),
                BadgeColumn::make('tipo')
                    ->label('Tipo')
                    // Formatea el texto que se muestra dentro del badge
                    ->formatStateUsing(fn ($state): string => match ($state) {
                        'ingreso' => 'Ingreso',
                        'egreso'  => 'Egreso',
                    })
                    // Define colores en función del valor original
                    ->colors([
                        'success' => 'ingreso',
                        'danger'  => 'egreso',
                    ]),
                Tables\Columns\TextColumn::make('cantidad')->label('Cant.'),
                Tables\Columns\TextColumn::make('costo_unitario')
                    ->label('C.Unit.'),
                Tables\Columns\TextColumn::make('user.name')->label('Usuario'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovimientoStocks::route('/'),
            'create' => Pages\CreateMovimientoStock::route('/create'),
            'edit' => Pages\EditMovimientoStock::route('/{record}/edit'),
        ];
    }
}
