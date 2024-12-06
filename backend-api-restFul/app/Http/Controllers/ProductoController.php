<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    
    // Obtener todos los productos en formato JSON
    public function getProductosJson()
    {
        $productos = Producto::all();
        return response()->json($productos);
    }

    // Seccion para la descarga del PDF 
    public function downloadProductosPdf()
    {
        $productos = Producto::all();
    
        // Convertir la imagen a base64 para cada producto
        foreach ($productos as $producto) {
            if ($producto->image_url) {
                $imagePath = storage_path('app/public/' . $producto->image_url);
                $imageData = base64_encode(file_get_contents($imagePath));
                $producto->image_base64 = 'data:image/jpeg;base64,' . $imageData;
            }
        }
    
        // Generar el PDF usando la vista 'productos.pdf' con la imagen en base64
        $pdf = PDF::loadView('productos.pdf', compact('productos'));
    
        return $pdf->download('productos.pdf');
    }
    

    public function getProductoById($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado.',
            ], 404);
        }

        return response()->json($producto, 200);
    }

    // Mostrar todos los productos
    public function index()
    {
        $productos = Producto::all();
        return view('dashboard', compact('productos'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('productos.create');
    }

    // Guardar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|string|max:55',
            'descripcion' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Subir la imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }

        // Crear producto
        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamhente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    // Actualizar un producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|string|max:55',
            'descripcion' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto = Producto::findOrFail($id);

        // Subir nueva imagen si se proporciona
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $producto->image_url = $imagePath;
        }

        // Actualizar otros campos
        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'image_url' => $producto->image_url,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar un producto
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
