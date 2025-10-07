<div class="p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Gestión de Préstamos</h1>

        @if (session()->has('message'))
            <div class="p-3 bg-green-100 text-green-800 rounded mb-3">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-3 bg-red-100 text-red-800 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        <input type="text"
               wire:model.live="search"
               placeholder="Buscar por libro..."
               class="border border-gray-300 p-2 w-full rounded focus:ring-2 focus:ring-blue-400 mb-4">

        <form wire:submit.prevent="store" class="grid grid-cols-2 gap-4 bg-white p-4 rounded shadow mb-6">
            <div>
                <label class="block text-sm font-semibold mb-1">Libro</label>
                <select wire:model="book_id" class="border p-2 w-full rounded">
                    <option value="">Selecciona un libro</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
                @error('book_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Fecha de préstamo</label>
                <input type="date" wire:model="loaned_at" class="border p-2 w-full rounded">
                @error('loaned_at') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ $isEdit ? 'Actualizar' : 'Guardar' }}
                </button>
                @if($isEdit)
                    <button type="button" wire:click="resetFields" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</button>
                @endif
            </div>
        </form>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-2">Libro</th>
                    <th class="p-2">Fecha préstamo</th>
                    <th class="p-2">Fecha devolución</th>
                    <th class="p-2">Devuelto</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr class="border-t">
                        <td class="p-2">{{ $loan->book->title }}</td>
                        <td class="p-2">{{ $loan->loaned_at->format('Y-m-d') }}</td>
                        <td class="p-2">{{ $loan->due_date->format('Y-m-d') }}</td>
                        <td class="p-2">{{ $loan->returned_at ? 'Sí' : 'No' }}</td>
                        <td class="p-2 flex gap-2">
                            <button wire:click="edit({{ $loan->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded">Editar</button>
                            @if(is_null($loan->returned_at))
                                <button wire:click="markReturned({{ $loan->id }})" class="bg-red-600 text-white px-3 py-1 rounded">Marcar devuelto</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 p-4">No se encontraron préstamos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $loans->links() }}
        </div>
        
    </div>


