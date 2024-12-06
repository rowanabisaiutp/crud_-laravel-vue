<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="{{ $producto->nombre }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="precio" class="block text-gray-700">Precio:</label>
                        <input type="text" id="precio" name="precio" value="{{ $producto->precio }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ $producto->descripcion }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Imagen Actual:</label>
                        @if($producto->image_url)
                            <img src="{{ asset('storage/' . $producto->image_url) }}" alt="Imagen actual" class="w-32 h-32 object-cover rounded-md mb-4">
                        @else
                            <p class="text-gray-500">No hay imagen disponible.</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">Subir Nueva Imagen (opcional):</label>
                        <input type="file" id="image" name="image" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 px-4 py-2 rounded-md hover:bg-blue-600">Actualizar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
