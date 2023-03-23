import pika

# Conexión con el servidor RabbitMQ
connection = pika.BlockingConnection(pika.ConnectionParameters("localhost"))
channel = connection.channel()

# Creación de una cola en RabbitMQ
channel.queue_declare(queue="colaHello")


# Función para procesar los mensajes recibidos
def callback(body):
    print("Mensaje recibido: ", body)


# Configuración del consumidor
channel.basic_consume(queue="colaHello", on_message_callback=callback, auto_ack=True)

# Inicio del consumo de mensajes
print("Esperando mensajes. Presione CTRL+C para salir.")
channel.start_consuming()
