import pika

# Conectarse al servidor RabbitMQ
connection = pika.BlockingConnection(pika.ConnectionParameters("localhost"))
channel = connection.channel()

# Crear un canal con nombre 'noticias'
channel.exchange_declare(exchange="noticias", exchange_type="fanout")

# Publicar un mensaje en el canal
channel.basic_publish(
    exchange="noticias", routing_key="", body="¡Nueva noticia sobre tecnología!"
)

# Cerrar la conexión
connection.close()
