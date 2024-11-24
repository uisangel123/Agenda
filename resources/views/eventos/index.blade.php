@extends('layouts.app')

@section('scripts')

    <script>
        var url_ = "{{ url('/eventos/') }}";
        var url_show = "{{ url('/eventos/show') }}";
    </script>
    <script src="{{ asset('js/main.js')}}"></script>
    <script>
          document.addEventListener("DOMContentLoaded", function() {
        var eventosHoy = @json($eventosHoy);

        // Obtener la fecha actual
        const hoy = new Date();
        const opcionesFecha = { day: '2-digit', month: '2-digit', year: 'numeric' };
        const fechaActual = hoy.toLocaleDateString('es-ES', opcionesFecha);

        if (eventosHoy.length > 0) {
            let contenido = "<ul>";
            eventosHoy.forEach(evento => {
                contenido += `<li>${evento.title} - ${evento.start}</li>`;
            });
            contenido += "</ul>";

            document.getElementById('modalBody').innerHTML = contenido;
            document.getElementById('modalTitle').innerText = `Eventos de Hoy (${fechaActual})`;
        } else {
            document.getElementById('modalBody').innerHTML = "No tienes eventos para hoy.";
            document.getElementById('modalTitle').innerText = `Sin eventos (${fechaActual})`;
        }

        var myModal = new bootstrap.Modal(document.getElementById("staticBackdrop"));
        myModal.show();
    });
    </script>


@endsection

@section('content')
    <div class="row">
        <div class="col"></div>
        <div class="col-9">
            <div id="calendar"></div>
        </div>
        <div class="col"></div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos del evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="d-none">
                        <input type="text" name="txtID" id="txtID">
                    </div>

                    <div class="form row">
                        <div class="form-group col-md-12">
                            <label for="txtTitulo">Titulo:</label>
                            <input type="text" class="form-control" name="txtTitulo" id="txtTitulo">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="txtFecha">Fecha:</label>
                            <input type="text" class="form-control" name="txtFecha" id="txtFecha" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtHora">Hora:</label>
                            <input type="time" min="07:00" max="19:00" step="600" class="form-control"
                                name="txtHora" id="txtHora">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="txtDescripcion">Descrpcion:</label>
                            <textarea name="txtDescripcion" class="form-control" cols="30" rows="3" id="txtDescripcion"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="txtColor">Color:</label>
                            <input type="text" class="form-control" name="txtColor" id="txtColor">
                        </div>

                    </div>


                </div>
                <div class="modal-footer">

                    <button class="btn btn-success" id="btnAgregar" type="submit">Agregar</button>
                    <button class="btn btn-warning" id="btnModificar">Modificar</button>
                    <button class="btn btn-danger" id="btnBorrar">Borrar</button>
                    <button class="btn btn-primary" data-bs-dismiss="modal" id="btnCancelar">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
