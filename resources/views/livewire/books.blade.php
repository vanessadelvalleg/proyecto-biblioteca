<div class="p-6"> <!-- Root div obligatorio para Livewire -->
    <h1 class="text-2xl font-bold mb-4 text-center">Gestión de Libros</h1>

    @if (session()->has('message'))
        <div class="p-3 bg-green-100 text-green-800 rounded mb-3">
            {{ session('message') }}
        </div>
    @endif

    <!-- Búsqueda en tiempo real -->
    <input type="text"
           wire:model.live="search"
           placeholder="Buscar por título o autor..."
           class="border border-gray-300 p-2 w-full rounded focus:ring-2 focus:ring-blue-400 mb-4">

    <!-- Formulario de libros -->
    <form wire:submit.prevent="store" class="grid grid-cols-2 gap-4 bg-white p-4 rounded shadow">
        <div>
            <label class="block text-sm font-semibold mb-1">Título</label>
            <input type="text" wire:model="title" class="border p-2 w-full rounded">
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Autor</label>
            <input type="text" wire:model="author" class="border p-2 w-full rounded">
            @error('author') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">ISBN</label>
            <input type="text" wire:model="isbn" class="border p-2 w-full rounded">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Año de publicación</label>
            <input type="number" wire:model="published_year" class="border p-2 w-full rounded">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Copias disponibles</label>
            <input type="number" wire:model="available_copies" class="border p-2 w-full rounded">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-1">Copias totales</label>
            <input type="number" wire:model="total_copies" class="border p-2 w-full rounded">
        </div>

        <div class="col-span-2 flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                {{ $isEdit ? 'Actualizar' : 'Guardar' }}
            </button>
            @if ($isEdit)
                <button type="button" wire:click="resetFields" class="bg-gray-400 text-white px-4 py-2 rounded">
                    Cancelar
                </button>
            @endif
        </div>
    </form>

    <!-- Tabla de libros -->
    <table class="w-full mt-6 border-collapse">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-2">Título</th>
                <th class="p-2">Autor</th>
                <th class="p-2">ISBN</th>
                <th class="p-2">Año</th>
                <th class="p-2">Disponibles</th>
                <th class="p-2">Totales</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr class="border-t">
                    <td class="p-2">{{ $book->title }}</td>
                    <td class="p-2">{{ $book->author }}</td>
                    <td class="p-2">{{ $book->isbn }}</td>
                    <td class="p-2">{{ $book->published_year }}</td>
                    <td class="p-2">{{ $book->available_copies }}</td>
                    <td class="p-2">{{ $book->total_copies }}</td>
                    <td class="p-2 flex gap-2">
                        <button wire:click="edit({{ $book->id }})"
                                class="bg-yellow-500 text-white px-3 py-1 rounded">Editar</button>
                        <button wire:click="delete({{ $book->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded">Eliminar</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 p-4">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>


