<x-app-layout>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-5">
                        <h1 class="text-2xl font-semibold text-gray-800">Gestión de Productos</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('productos.pdf') }}" class="inline-block bg-gradient-to-r from-green-600 to-green-700 py-3 px-6 rounded-md shadow-md hover:scale-105 transform transition duration-300">
                                <i class="fas fa-file-pdf text-lg"></i>
                            </a>
                            <a href="{{ route('productos.excel') }}" class="inline-block bg-gradient-to-r from-yellow-600 to-yellow-700 py-3 px-6 rounded-md shadow-md hover:scale-105 transform transition duration-300">
                                <i class="fas fa-file-excel text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('productos.create') }}" class="inline-block bg-gradient-to-r from-blue-600 to-blue-700 py-3 px-6 rounded-md shadow-md hover:scale-105 transform transition duration-300 mb-5">
                        Crear Producto
                    </a>

                    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-xs font-semibold text-gray-700">
                                <tr>
                                    <th class="py-3 px-6 border-b border-gray-300">ID</th>
                                    <th class="py-3 px-6 border-b border-gray-300">Nombre</th>
                                    <th class="py-3 px-6 border-b border-gray-300">Precio</th>
                                    <th class="py-3 px-6 border-b border-gray-300">Descripción</th>
                                    <th class="py-3 px-6 border-b border-gray-300">Imagen</th>
                                    <th class="py-3 px-6 border-b border-gray-300">Fecha de creacion</th>
                                    <th class="py-3 px-6 border-b border-gray-300">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse ($productos as $producto)
                                    <tr class="hover:bg-gray-50 transition duration-300">
                                        <td class="py-3 px-6 border-b border-gray-200">{{ $producto->id }}</td>
                                        <td class="py-3 px-6 border-b border-gray-200">{{ $producto->nombre }}</td>
                                        <td class="py-3 px-6 border-b border-gray-200"> ${{ $producto->precio }}</td>
                                        <td class="py-3 px-6 border-b border-gray-200">{{ Str::limit($producto->descripcion, 50) }}</td>
                                        <td>
                                            @if($producto->image_url)
                                                <img src="{{ asset('storage/' . $producto->image_url) }}" alt="Imagen de {{ $producto->nombre }}" width="100">
                                            @else
                                                No hay imagen
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 border-b border-gray-200">{{ $producto->updated_at }}</td>
                                        <td class="py-3 px-6 border-b border-gray-200">
                                            <div class="flex space-x-4">
                                                <!-- Botón Editar -->
                                                <a href="{{ route('productos.edit', $producto) }}" 
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md shadow-md transition duration-300 transform hover:scale-105 flex items-center justify-center">
                                                    <i class="fas fa-edit text-white"></i> <!-- Ícono de edición -->
                                                </a>

                                                <!-- Botón Eliminar -->
                                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline-block delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md shadow-md transition duration-300 transform hover:scale-105 flex items-center justify-center">
                                                        <i class="fas fa-trash text-white"></i> <!-- Ícono de eliminar -->
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        



                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-3 px-6 text-center text-gray-500 border-b border-gray-200">No hay productos disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript para confirmar eliminación -->
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                    this.submit();
                }
            });
        });
    </script>
</x-app-layout>
