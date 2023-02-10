FROM php:7.4-cli

COPY . /app/

RUN chmod +x /app/startup.sh

WORKDIR /app

CMD ["./startup.sh"]
