<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\Proveedor;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Muestra el dashboard con las estadísticas principales.
     */
    public function dashboard()
    {
        $totalItems = Product::count();
        $itemsWithLowStockCount = Product::where('cantidad_actual', '>', 0)->where('cantidad_actual', '<', Product::LOW_STOCK_THRESHOLD)->count();
        $itemsOutOfStockCount = Product::where('cantidad_actual', '=', 0)->count();
        $inventoryValue = Product::sum(DB::raw('cantidad_actual * costo_unitario'));
        $itemsNearExpirationCount = Product::where('fecha_de_vencimiento', '>', Carbon::now())
                                          ->where('fecha_de_vencimiento', '<=', Carbon::now()->addDays(30))
                                          ->count();

        $expiredProducts = Product::where('fecha_de_vencimiento', '<', Carbon::now())->get();
        $outOfStockProducts = Product::where('cantidad_actual', '=', 0)->get();
        $lowStockProducts = Product::where('cantidad_actual', '>', 0)
                                   ->where('cantidad_actual', '<', Product::LOW_STOCK_THRESHOLD)
                                   ->get();
        $nearExpirationProducts = Product::where('fecha_de_vencimiento', '>', Carbon::now())
                                        ->where('fecha_de_vencimiento', '<=', Carbon::now()->addDays(30))
                                        ->get();

        return view('dashboard', [
            'totalItems' => $totalItems,
            'itemsWithLowStock' => $itemsWithLowStockCount,
            'itemsOutOfStock' => $itemsOutOfStockCount,
            'inventoryValue' => $inventoryValue,
            'itemsNearExpiration' => $nearExpirationProducts,
            'lowStockProducts' => $lowStockProducts,
            'expiredProducts' => $expiredProducts,
            'outOfStockProducts' => $outOfStockProducts,
        ]);
    }

    /**
     * Muestra la lista de todos los productos, aplicando filtros y ordenamiento.
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
                $query->where('cantidad_actual', '>=', Product::LOW_STOCK_THRESHOLD);
            } elseif ($status == 'stock_bajo') {
                $query->where('cantidad_actual', '>', 0)->where('cantidad_actual', '<', Product::LOW_STOCK_THRESHOLD);
            } elseif ($status == 'agotado') {
                $query->where('cantidad_actual', '=', 0);
            }
        }
        
        $sortBy = $request->input('sort_by', 'nombre_del_producto');
        $sortDirection = $request->input('sort_direction', 'asc');
        
        $allowedSortColumns = ['nombre_del_producto', 'proveedor', 'categoria', 'cantidad_actual', 'fecha_de_vencimiento'];
        if (in_array($sortBy, $allowedSortColumns) && in_array($sortDirection, ['asc', 'desc'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $products = $query->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'status']),
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $marcas = Marca::orderBy('nombre')->get();
        return view('products.create', compact('proveedores', 'marcas'));
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_del_producto' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'numero_de_lote' => 'nullable|string|max:255',
            'fecha_de_vencimiento' => 'nullable|date',
            'cantidad_actual' => 'required|integer|min:0',
            'costo_unitario' => 'nullable|numeric|min:0',
            'presentacion_tipo' => 'nullable|string|max:255',
            'presentacion_cantidad' => 'nullable|integer|min:0',
        ]);

        $presentacionCompleta = null;
        if (!empty($validatedData['presentacion_tipo']) && isset($validatedData['presentacion_cantidad'])) {
            $presentacionCompleta = $validatedData['presentacion_tipo'] . ' - ' . $validatedData['presentacion_cantidad'] . ' unidades';
        }
        $validatedData['presentacion'] = $presentacionCompleta;
        
        $product = Product::create($validatedData);

        InventoryMovement::create([
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'type'       => 'entrada',
            'quantity'   => $product->cantidad_actual,
            'notes'      => 'Creación de nuevo elemento en el inventario.',
        ]);

        return redirect()->route('productos.index')->with('success', '¡Producto agregado exitosamente!');
    }

    public function show(Product $product){}

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id); 
        $proveedores = Proveedor::orderBy('nombre')->get();
        $marcas = Marca::orderBy('nombre')->get();
        return view('products.edit', compact('product', 'proveedores', 'marcas'));
    }

    /**
     * Actualiza un producto en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validatedData = $request->validate([
            'nombre_del_producto' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'proveedor' => 'nullable|string|max:255',
            'numero_de_lote' => 'nullable|string|max:255',
            'fecha_de_vencimiento' => 'nullable|date',
            'cantidad_actual' => 'required|integer|min:0',
            'costo_unitario' => 'nullable|numeric|min:0',
            'presentacion_tipo' => 'nullable|string|max:255',
            'presentacion_cantidad' => 'nullable|integer|min:0',
        ]);
        $presentacionCompleta = null;
        if (!empty($validatedData['presentacion_tipo']) && isset($validatedData['presentacion_cantidad'])) {
            $presentacionCompleta = $validatedData['presentacion_tipo'] . ' - ' . $validatedData['presentacion_cantidad'] . ' unidades';
        }
        $validatedData['presentacion'] = $presentacionCompleta;
        $product->update($validatedData);

        InventoryMovement::create([
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'type'       => 'actualizacion',
            'quantity'   => 0,
            'notes'      => 'Producto actualizado.',
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy($id)
    {
        $this->authorize('esAdmin');
        $product = Product::findOrFail($id);
        InventoryMovement::create([
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'type'       => 'eliminado',
            'quantity'   => $product->cantidad_actual,
            'notes'      => 'Elemento eliminado del inventario.',
        ]);
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
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'type'       => 'salida',
            'quantity'   => $validated['quantity'],
            'notes'      => $validated['notes'],
        ]);
        return redirect()->route('productos.index')->with('success', 'Stock actualizado correctamente.');
    }

    /**
     * Muestra la página de trazabilidad con el historial de movimientos.
     */
    public function showTraceability(Request $request)
    {
        $query = InventoryMovement::with(['product', 'user'])->latest();

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $movements = $query->paginate(15);
        
        $products = Product::orderBy('nombre_del_producto')->get();
        $movementTypes = InventoryMovement::select('type')->distinct()->pluck('type');

        return view('trazabilidad.index', [
            'movements' => $movements,
            'products' => $products,
            'movementTypes' => $movementTypes,
            'filters' => $request->only(['product_id', 'type', 'start_date', 'end_date'])
        ]);
    }
}