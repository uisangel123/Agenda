document.addEventListener("DOMContentLoaded", function() {
    // 1. Inicialización del calendario
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        // Fecha por defecto para el calendario
        defaultDate: new Date(2019, 8, 1),
        // Plugins utilizados por FullCalendar
        Plugins: ["dayGrid", "timeGrid", "list", "interaction"],

        // Configuración de la barra de herramientas del calendario
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,interaction",
        },

        // 2. Evento que se activa al hacer clic en una fecha del calendario
        dateClick: function(info) {
            limpiarFormulario(); // Limpia los campos del formulario
            $('#txtFecha').val(info.dateStr); // Asigna la fecha seleccionada al input
            $('#exampleModal').modal('toggle'); // Abre el modal

            // Habilita/Deshabilita los botones según el contexto
            $("#btnAgregar").prop("disabled", false);
            $("#btnModificar").prop("disabled", true);
            $("#btnBorrar").prop("disabled", true);
        },

        // 3. Evento que se activa al hacer clic en un evento existente
        eventClick: function(info) {
            // Desactiva el botón "Agregar" y habilita "Modificar" y "Borrar"
            $("#btnAgregar").prop("disabled", true);
            $("#btnModificar").prop("disabled", false);
            $("#btnBorrar").prop("disabled", false);

            // Llena los inputs con la información del evento
            $('#txtID').val(info.event.id);
            $('#txtTitulo').val(info.event.title);
            $('#txtDescripcion').val(info.event.extendedProps.description);
            $('#txtColor').val(info.event.backgroundColor);

            // Formatea la fecha para que sea compatible con el input de tipo fecha
            let mes = (info.event.start.getMonth() + 1);
            let dia = info.event.start.getDate();
            let año = info.event.start.getFullYear();

            mes = (mes < 10) ? "0" + mes : mes;
            dia = (dia < 10) ? "0" + dia : dia;

            // Formatea la hora para que sea compatible con el input de tipo hora
            let minutos = info.event.start.getMinutes();
            let hora = info.event.start.getHours();

            minutos = (minutos < 10) ? "0" + minutos : minutos;
            hora = (hora < 10) ? "0" + hora : hora;

            let horario = hora + ":" + minutos;

            $('#txtFecha').val(`${año}-${mes}-${dia}`);
            $('#txtHora').val(horario);

            $('#exampleModal').modal('toggle'); // Abre el modal
        },

        // Obtiene los eventos desde la URL configurada (proporcionados por el controlador)
        events: url_show,
    });

    // Configuración del idioma del calendario a español
    calendar.setOption("locale", "Es");

    // Renderiza el calendario en la página
    calendar.render();

    // 4. Manejo de botones del modal
    // Botón "Agregar"
    $('#btnAgregar').click(function() {
        ObjEvento = recolectarDatosGui("POST"); // Recolecta los datos con método POST
        EnviarInformacion('', ObjEvento); // Envía la información al controlador
    });

    // Botón "Borrar"
    $('#btnBorrar').click(function() {
        ObjEvento = recolectarDatosGui("DELETE"); // Recolecta los datos con método DELETE
        EnviarInformacion('/' + $('#txtID').val(), ObjEvento); // Envía la información al controlador
    });

    // Botón "Modificar"
    $('#btnModificar').click(function() {
        ObjEvento = recolectarDatosGui("PATCH"); // Recolecta los datos con método PATCH
        EnviarInformacion('/' + $('#txtID').val(), ObjEvento); // Envía la información al controlador
    });

    // 5. Función para recolectar datos del formulario
    function recolectarDatosGui(method) {
        // Crea un objeto con los datos del formulario y el método de envío
        let nuevoEvento = {
            id: $("#txtID").val(),
            title: $("#txtTitulo").val(),
            description: $("#txtDescripcion").val(),
            color: $("#txtColor").val(),
            textColor: "#FFFFFF",
            start: $("#txtFecha").val() + " " + $("#txtHora").val(),
            end: $("#txtFecha").val() + " " + $("#txtHora").val(),
            '_token': $("meta[name='csrf-token']").attr("content"),
            'method': method
        };
        return nuevoEvento;
    }

    // 6. Función para enviar información al controlador mediante AJAX
    function EnviarInformacion(accion, objEvento) {
        $.ajax({
            type: objEvento.method,
            url: url_ + accion,
            data: objEvento,
            success: function(msg) {
                console.log(msg); // Muestra el mensaje de éxito en la consola
                $('#exampleModal').modal('toggle'); // Cierra el modal
                calendar.refetchEvents(); // Actualiza los eventos del calendario
            },
            error: function() {
                alert("Hay un error"); // Muestra un mensaje de error
            }
        });
    }

    // 7. Función para limpiar los campos del formulario
    function limpiarFormulario() {
        $('#txtID').val("");
        $('#txtTitulo').val("");
        $('#txtDescripcion').val("");
        $('#txtColor').val("");
        $('#txtFecha').val("");
        $('#txtHora').val("07:00");
    }
});
