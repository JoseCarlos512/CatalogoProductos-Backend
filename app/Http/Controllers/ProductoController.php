<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * Listar y buscar dentro de la tabla producto
     */
    public function index(Request $request)
    {
        $input = $request->all();
        // select * from producto (ORM, Laravel.. ELOCQUENT)
        // $productos = Producto::all();

        // select * from producto inner join users on (ORM, Laravel.. ELOCQUENT)
        //$productos = Producto::with(['user:id,email,name'])->get(); //Retornar el producto con su usuario
        
        
        //$productos = Producto::with(['user:id,email,name'])->paginate(10); //Paginar

        // select * from producto where nombre like '%par%' or 
        // Dentro del with esta (user) que es metodo de Producto (Modelo)
        // conectado con el user
        $productos = Producto::with(['user:id,email,name'])
                                ->whereCodigo($request->txtBuscar) // ->where('codigo', '=', $request->txtBuscar)
                                ->orWhere('nombre', 'like',     "%{$request->txtBuscar}%")
                                ->get(); //->paginate(10);      //get(); obtener sin pagincacion  

        return \response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * Insertar nuevos registros
     */
    public function store(CreateProductoRequest $request)
    {
        //insert into productos values (...........$request)
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;; //auth()->user()->id; //usuarios autenticados
        $producto = Producto::create($input);
        
        return \response()->json(['res' => true, 
                                  'message' => 'Insertado correctamente'
                                 ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Recoger un solo registro de la base de datos
     */
    public function show($id)
    {
        // select * from  producto where id = $id
        // $producto = Producto::find($id);

        // select * from  producto inner join user where id = $id
        $producto = Producto::with('user:id,email,name')->findOrFail($id);

        return \response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Modificar registros
     */
    public function update(UpdateProductoRequest $request, $id)
    {
        //update productos set nombre = $request .... where id = $id
        $input = $request->all();
        $producto = Producto::find($id);
        $producto->update($input);

        return \response()->json(['res' => true, 
                                  'message' => 'Modificado correctamente'
                                 ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Eliminar registros
     */
    public function destroy($id)
    {
        try {
            //delete from productos where id = $id
            Producto::destroy($id);
            return \response()->json(['res' => true, 
                                  'message' => 'eliminado correctamente',
                                  ], 200);
        } catch (\Exception $e) {

            return \response()->json(['res' => false, 
                                  'message' => $e->getMessage(),
                                  ], 500);
        }
    }

    /**
     *  Incrementar likes de productos
     */
    public function setLike($id) {
        $producto = Producto::find($id);
        $producto->like = $producto->like + 1;
        $producto->save();

        return \response()->json(['res' => true, 
                                  'message' => 'mas un like',
                                  ], 200);
    }

    /**
     *  Decrementar un like del producto
     */
    public function setDislike($id) {
        $producto = Producto::find($id);
        $producto->dislike = $producto->dislike + 1;
        $producto->save();

        return \response()->json(['res' => true, 
                                  'message' => 'mas un dislike',
                                  ], 200);
    }

    /**
     *  Asignar la ruta de la imagen guardada
     */
    public function setImagen(Request $request, $id) {
       
        $producto = Producto::findOrFail($id);
        $producto->url_imagen = $this->cargarImagen($request->imagen, $id);
        $producto->save();

        return \response()->json(['res' => true, 
                                  'message' => 'Imagen cargada correctamente',
                                  ], 200);
    }

    private function cargarImagen($file, $id) {
        // nombreArchivo = 78978779811_55.png
        $nombreArchivo = time() . "_{$id}." . $file->getClientOriginalExtension();
        $file->move(public_path('imagenes'), $nombreArchivo);
        return $nombreArchivo;
    }
}

    

