<?php

// Servidor web
class WebServer {
    private $paymentServer;
    private $shippingServer;
    
    public function __construct() {
        $this->paymentServer = new PaymentServer();
        $this->shippingServer = new ShippingServer();
    }
    
    public function processOrder($orderDetails) {
        $paymentResult = $this->paymentServer->processPayment($orderDetails);
        $shippingResult = $this->shippingServer->prepareShipping($orderDetails);
        
        // Mostrar al usuario un mensaje de confirmación con el resultado de la transacción y el número de seguimiento del envío.
        echo "Pago procesado: " . $paymentResult . "\n";
        echo "Envío preparado: " . $shippingResult . "\n";
    }
}

// Servidor de pagos
class PaymentServer {
    public function processPayment($orderDetails) {
        // Comunicarse con el servicio de pago en línea (PayPal, Stripe, etc.) para procesar el pago.
        return "Pago procesado exitosamente";
    }
}

// Servidor de envío
class ShippingServer {
    public function prepareShipping($orderDetails) {
        // Comunicarse con el servicio de envío (UPS, FedEx, etc.) para preparar el envío y obtener el número de seguimiento.
        return "Envío preparado exitosamente";
    }
}

// Ejemplo de uso
$webServer = new WebServer();
$orderDetails = array(
    "productId" => 123,
    "quantity" => 2,
    "shippingAddress" => "123 Main St.",
    "paymentMethod" => "PayPal"
);
$webServer->processOrder($orderDetails);

?>
