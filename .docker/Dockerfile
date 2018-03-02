FROM php:7.2

RUN apt-get update && \
    apt-get install -y git gnupg

# NodeJs
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs
RUN npm install yarn

WORKDIR /app