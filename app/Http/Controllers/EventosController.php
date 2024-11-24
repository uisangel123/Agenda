<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Carbon\Carbon;

class EventosController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    $hoy = Carbon::today(); // Obtener la fecha actual
    $eventosHoy = Evento::whereDate('start', $hoy)->get(); // Filtrar eventos del día
    return view('eventos.index', compact('eventosHoy'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //recibir los datos del formulario y insertarlos en la base de datos
    $datosEvento = $request->except(['_token', '_method', 'method']);
    evento::insert($datosEvento);
    print_r($datosEvento);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $data['eventos'] = evento::all();
   return response()->json($data['eventos']);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
    $datosEvento = $request->except(['_token', '_method', 'method']);
    $respuesta=evento::where('id','=',$id)->update($datosEvento);
    return response()->json($respuesta);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $evento = evento::find($id); // Encontrar el evento por ID
    if ($evento) {
        $evento->delete(); // Eliminar el evento
        return response()->json(['message' => 'Evento eliminado con éxito.']);
    } else {
        return response()->json(['message' => 'Evento no encontrado.'], 404);
    }

  }
}
