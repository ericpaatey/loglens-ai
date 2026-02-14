FROM php:8.2-cli
COPY . /usr/src/loglens-ai
WORKDIR /usr/src/loglens-ai
CMD [ "php", "./index.php" ]