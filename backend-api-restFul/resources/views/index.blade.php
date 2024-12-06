@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-5">Gestión de Productos</h1>
            <a href="{{ route('productos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">Crear Producto</a>
            <table class="table-auto w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2">Precio</th>
                        <th class="border border-gray-300 px-4 py-2">Descripción</th>
                        <th class="border border-gray-300 px-4 py-2">Imagen</th>
                        <th class="border border-gray-300 px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $producto->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $producto->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $producto->precio }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $producto->descripcion }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if($producto->image_url)
                                <img src="{{ asset('storage/' . $producto->image_url) }}" alt="{{ $producto->nombre }}" width="50">
                            @else
                                <span>Sin imagen</span>
                            @endif
                        </td>

                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('productos.edit', $producto) }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md">Editar</a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center border border-gray-300 px-4 py-2">No hay productos disponibles</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
