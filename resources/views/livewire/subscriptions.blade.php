<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Mis Suscripciones</h1>

    @if (session()->has('message'))
        <div class="p-3 mb-3 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="store" class="grid grid-cols-2 gap-4 bg-white p-4 rounded shadow mb-6">
        <div>
            <label>Plan</label>
            <select wire:model="plan_name" class="border p-2 w-full rounded">
                <option value="">Selecciona un plan</option>
                <option value="basic">Basic</option>
                <option value="premium">Premium</option>
            </select>
        </div>
        <div>
            <label>Fecha de inicio</label>
            <input type="date" wire:model="starts_at" class="border p-2 w-full rounded">
        </div>

        <div class="col-span-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Crear Suscripción
            </button>
        </div>
    </form>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Plan</th>
                <th class="p-2">Estado</th>
                <th class="p-2">Inicio</th>
                <th class="p-2">Fin</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $sub)
                <tr class="border-t">
                    <td class="p-2">{{ $sub->plan_name }}</td>
                    <td class="p-2">
                        <span class="px-2 py-1 rounded {{ $this->statusColor($sub->status) }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                    <td class="p-2">{{ $sub->starts_at }}</td>
                    <td class="p-2">{{ $sub->ends_at ?? '-' }}</td>
                    <td class="p-2 flex gap-2">
                        @if($sub->status !== 'cancelled')
                            <button wire:click="cancel({{ $sub->id }})" 
                                    class="bg-red-600 text-white px-2 py-1 rounded text-sm">
                                Cancelar
                            </button>
                        @endif

                        <button wire:click="simulateStripeWebhook({{ $sub->id }}, 'active')" 
                                class="bg-blue-600 text-white px-2 py-1 rounded text-sm">
                            Activar
                        </button>

                        <button wire:click="simulateStripeWebhook({{ $sub->id }}, 'past_due')" 
                                class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">
                            Moroso
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $subscriptions->links() }}
    </div>
</div>




