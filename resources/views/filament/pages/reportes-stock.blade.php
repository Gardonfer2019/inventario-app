<x-filament-panels::page>
{{-- Filtros de fecha --}}
    {{-- Filtros de fecha --}}
    <div class="flex gap-4 mb-6 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-300">Desde</label>
            <input
                type="date"
                wire:model="desde"
                class="mt-1 block w-full rounded bg-gray-800 border-gray-700 "
        />
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-300">Hasta</label>
                    <input
                        type="date"
                        wire:model="hasta"
                        class="mt-1 block w-full rounded bg-gray-800 border-gray-700"
        />
                </div>
                {{-- Aquí está el botón de filtro --}}
                <div>
                    <x‑filament::button
                        type="button"
                        wire:click="$refresh"
                        class="mt-6 "
                    >Filtrar</x‑filament::button>
                </div>
            </div>

    {{-- Detalle de movimientos --}}
    <x‑filament::card class="overflow-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-3 py-2 text-left text-gray-300">Fecha</th>
                    <th class="px-3 py-2 text-left text-gray-300">Tipo</th>
                    <th class="px-3 py-2 text-left text-gray-300">Producto</th>
                    <th class="px-3 py-2 text-right text-gray-300">Cant.</th>
                    <th class="px-3 py-2 text-right text-gray-300">Unit.</th>
                    <th class="px-3 py-2 text-right text-gray-300">Total</th>
                    <th class="px-3 py-2 text-left text-gray-300">Ref.</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach ($movimientos as $tipo => $items)
                    <tr class="bg-gray-700">
                        <td colspan="7" class="px-3 py-1 font-semibold text-gray-100">
                            {{ ucfirst($tipo) }}
                        </td>
                    </tr>
                    @foreach ($items as $mov)
                        <tr class="bg-gray-800 hover:bg-gray-700">
                            <td class="px-3 py-1">{{ $mov->fecha->format('d/m/Y') }}</td>
                            <td class="px-3 py-1">{{ ucfirst($mov->tipo) }}</td>
                            <td class="px-3 py-1">{{ $mov->producto->nombre }}</td>
                            <td class="px-3 py-1 text-right">{{ $mov->cantidad }}</td>
                            <td class="px-3 py-1 text-right">{{ number_format($mov->costo_unitario,2) }}</td>
                            <td class="px-3 py-1 text-right">
                                {{ number_format($mov->cantidad * $mov->costo_unitario,2) }}
                            </td>
                            <td class="px-3 py-1">{{ $mov->referencia }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </x‑filament::card>

    {{-- Totales generales --}}
    <x‑filament::card class="mt-4">
        <div class="flex justify-between">
            <span class="font-medium">Total Ingresos:</span>
            <span>{{ number_format($totalIngresos,2) }}</span>
        </div>
        <div class="flex justify-between mt-2">
            <span class="font-medium">Total Egresos:</span>
            <span>{{ number_format($totalEgresos,2) }}</span>
        </div>
    </x‑filament::card>
</x-filament-panels::page>
