import pika

# Establecer la conexión con RabbitMQ
connection = pika.BlockingConnection(pika.ConnectionParameters("localhost"))
channel = connection.channel()

# Crear la cola
channel.queue_declare(queue="hello")

# Enviar un mensaje a la cola
channel.basic_publish(exchange="", routing_key="hello", body="Hello World!")
print(" [x] Sent 'Hello World!'")


# Definir una función para recibir mensajes
def callback(body):
    print(" [x] Received %r" % body)


# Registrar la función como manejador de mensajes
channel.basic_consume(queue="hello", on_message_callback=callback, auto_ack=True)

# Iniciar la escucha de la cola para recibir mensajes
print("Esperando mensajes.")
channel.start_consuming()

connection.close()
