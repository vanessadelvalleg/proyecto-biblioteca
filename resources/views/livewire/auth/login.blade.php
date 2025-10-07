<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Iniciar sesión</h2>

    @if (session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-3">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
        <input type="email" wire:model="email" placeholder="Correo" class="w-full p-2 border rounded">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="password" wire:model="password" placeholder="Contraseña" class="w-full p-2 border rounded">
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Iniciar sesión
        </button>

        <a href="{{ route('register') }}" class="text-sm text-blue-600 block mt-2 text-center">
            ¿No tienes cuenta? Regístrate
        </a>
    </form>
</div>