import pika

# Conexión con el servidor RabbitMQ
connection = pika.BlockingConnection(pika.ConnectionParameters("localhost"))
channel = connection.channel()

# Creación de una cola en RabbitMQ
channel.queue_declare(queue="colaHello")

# Envío de un mensaje a la cola
message = "Hola, mundo!"
channel.basic_publish(exchange="", routing_key="colaHello", body=message)

# Cierre de la conexión con el servidor RabbitMQ
connection.close()
