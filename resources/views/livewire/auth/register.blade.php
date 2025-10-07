<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Registro</h2>

    <form wire:submit.prevent="register" class="space-y-4">
        <input type="text" wire:model="name" placeholder="Nombre" class="w-full p-2 border rounded">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="email" wire:model="email" placeholder="Correo" class="w-full p-2 border rounded">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="password" wire:model="password" placeholder="Contraseña" class="w-full p-2 border rounded">
        <input type="password" wire:model="password_confirmation" placeholder="Confirmar contraseña" class="w-full p-2 border rounded">
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Registrarse
        </button>

        <a href="{{ route('login') }}" class="text-sm text-blue-600 block mt-2 text-center">
            ¿Ya tienes cuenta? Inicia sesión
        </a>
    </form>
</div>