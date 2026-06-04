FROM node:14

COPY compose/local/watcher/entrypoint.sh /entrypoint.sh

ENTRYPOINT /entrypoint.sh

RUN chmod +x /entrypoint.sh

RUN mkdir /app

WORKDIR /app