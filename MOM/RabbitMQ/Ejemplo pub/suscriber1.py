import pika

# Conectarse al servidor RabbitMQ
connection = pika.BlockingConnection(pika.ConnectionParameters("localhost"))
channel = connection.channel()

# Crear un canal temporal y obtener su nombre
result = channel.queue_declare(queue="", exclusive=True)
queue_name = result.method.queue

# Unir el canal temporal al canal 'noticias'
channel.queue_bind(exchange="noticias", queue=queue_name)


# Definir una función de retorno de llamada para recibir mensajes
def callback(body):
    print("¡Nuevo mensaje recibido por el suscriptor 1!: %r" % body)


# Escuchar mensajes en el canal temporal
channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)

# Esperar por mensajes
print("Suscriptor 1 esperando por mensajes.")
channel.start_consuming()
