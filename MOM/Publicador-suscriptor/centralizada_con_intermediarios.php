<?php
// En el controlador:

// Controlador

function reservarVuelo() {
    // Recibir datos del formulario de reserva
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fechaSalida = $_POST['fechaSalida'];
    $fechaRegreso = $_POST['fechaRegreso'];
    $pasajeros = $_POST['pasajeros'];
    $clase = $_POST['clase'];
    
    // Comunicarse con el servicio de búsqueda de vuelos para obtener opciones
    $busquedaService = new BusquedaVuelosService();
    $opcionesVuelo = $busquedaService->buscarVuelos($origen, $destino, $fechaSalida, $fechaRegreso, $pasajeros, $clase);
    
    // Presentar opciones de vuelo al usuario
    $html = '<h2>Opciones de vuelo disponibles</h2>';
    foreach ($opcionesVuelo as $vuelo) {
        $html .= '<p>' . $vuelo['compania'] . ' - ' . $vuelo['horaSalida'] . ' - ' . $vuelo['horaLlegada'] . ' - ' . $vuelo['precio'] . '</p>';
    }
    
    // Si el usuario selecciona un vuelo, comunicarse con el servicio de reservaciones y el servicio de pagos
    if (isset($_POST['seleccion'])) {
        $seleccion = $_POST['seleccion'];
        $reservacionesService = new ReservacionesService();
        $reservacionesService->reservarVuelo($seleccion);
        
        $pagoService = new PagoService();
        $pagoService->procesarPago($_POST['total']);
        
        // Mostrar confirmación al usuario
        $html .= '<h2>Reservación completada</h2>';
        $html .= '<p>Su vuelo ha sido reservado y se ha procesado su pago.</p>';
    }
    
    // Mostrar el formulario de reserva y las opciones de vuelo
    $html .= '<form method="post">';
    $html .= '<input type="hidden" name="total" value="1000">';
    foreach ($opcionesVuelo as $i => $vuelo) {
        $html .= '<label for="seleccion_' . $i . '">';
        $html .= '<input type="radio" name="seleccion" value="' . $vuelo['id'] . '" id="seleccion_' . $i . '">';
        $html .= $vuelo['compania'] . ' - ' . $vuelo['horaSalida'] . ' - ' . $vuelo['horaLlegada'] . ' - ' . $vuelo['precio'];
        $html .= '</label>';
    }
    $html .= '<input type="submit" value="Reservar">';
    $html .= '</form>';
    
    echo $html;
}