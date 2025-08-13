<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Muestra el dashboard con las estadísticas principales.
     */
    public function dashboard()
    {
        $totalItems = Product::count();
        $itemsWithLowStock = Product::where('cantidad_actual', '>', 0)->where('cantidad_actual', '<', 10)->count();
        $itemsOutOfStock = Product::where('cantidad_actual', '=', 0)->count();
        $inventoryValue = Product::sum(DB::raw('cantidad_actual * costo_unitario'));
        $itemsNearExpiration = Product::where('fecha_de_vencimiento', '>', Carbon::now())
                                      ->where('fecha_de_vencimiento', '<=', Carbon::now()->addDays(30))
                                      ->get();
        $lowStockProducts = Product::where('cantidad_actual', '>', 0)
                                   ->where('cantidad_actual', '<', 10)
                                   ->get();
        return view('dashboard', compact(
            'totalItems', 'itemsWithLowStock', 'itemsOutOfStock',
            'inventoryValue', 'itemsNearExpiration', 'lowStockProducts'
        ));
    }

    /**
     * Muestra la lista de todos los productos, aplicando los filtros si existen.
     */
    public function index(Request $request)
    {
        $categories = Product::select('categoria')->whereNotNull('categoria')->distinct()->orderBy('categoria')->pluck('categoria');
        $query = Product::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre_del_producto', 'like', "%{$searchTerm}%")
                  ->orWhere('marca', 'like', "%{$searchTerm}%")
                  ->orWhere('proveedor', 'like', "%{$searchTerm}%")
                  ->orWhere('numero_de_lote', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('categoria', $request->input('category'));
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status == 'normal') {
                $query->where('cantidad_actual', '>=', 10);
            } elseif ($status == 'stock_bajo') {
                $query->where('cantidad_actual', '>', 0)->where('cantidad_actual', '<', 10);
            } elseif ($status == 'agotado') {
                $query->where('cantidad_actual', '=', 0);
            }
        }

        $products = $query->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'status'])
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_del_producto' => 'required|string|max:255', 'marca' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:255', 'proveedor' => 'nullable|string|max:255',
            'presentacion' => 'nullable|string|max:255', 'numero_de_lote' => 'nullable|string|max:255',
            'fecha_de_vencimiento' => 'nullable|date', 'cantidad_actual' => 'required|integer|min:0',
            'costo_unitario' => 'nullable|numeric|min:0',
        ]);
        Product::create($validatedData);
        return redirect()->route('productos.index');
    }

    public function show(Product $product){}

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id); 
        return view('products.edit', compact('product'));
    }

    /**
     * Actualiza un producto en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validatedData = $request->validate([
            'nombre_del_producto' => 'required|string|max:255', 'marca' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:255', 'proveedor' => 'nullable|string|max:255',
            'presentacion' => 'nullable|string|max:255', 'numero_de_lote' => 'nullable|string|max:255',
            'fecha_de_vencimiento' => 'nullable|date', 'cantidad_actual' => 'required|integer|min:0',
            'costo_unitario' => 'nullable|numeric|min:0',
        ]);
        $product->update($validatedData);
        return redirect()->route('productos.index');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // INICIO DEL CAMBIO: Registrar el movimiento de eliminación
        InventoryMovement::create([
            'product_id' => $product->id,
            'type'       => 'eliminado',
            'quantity'   => $product->cantidad_actual, // Registramos la cantidad que se eliminó
            'notes'      => 'Elemento eliminado del inventario.',
        ]);
        // FIN DEL CAMBIO

        $product->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
    
    /**
     * Muestra el formulario para registrar una salida de stock.
     */
    public function showDischargeForm($id)
    {
        $product = Product::findOrFail($id);
        return view('products.discharge', compact('product'));
    }

    /**
     * Procesa la salida de stock y actualiza la cantidad.
     */
    public function dischargeStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$product->cantidad_actual],
            'notes' => 'nullable|string',
        ]);
        $product->cantidad_actual -= $validated['quantity'];
        $product->save();
        InventoryMovement::create([
            'product_id' => $product->id, 'type' => 'salida',
            'quantity'   => $validated['quantity'], 'notes' => $validated['notes'],
        ]);
        return redirect()->route('productos.index')->with('success', 'Stock actualizado correctamente.');
    }

    /**
     * Muestra la página de trazabilidad con el historial de movimientos.
     */
    public function showTraceability()
    {
        $movements = InventoryMovement::with('product')->latest()->get();
        return view('trazabilidad.index', compact('movements'));
    }
}
