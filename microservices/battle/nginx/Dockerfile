FROM nginx:stable

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        bc \
        curl \
        openssl \
        unzip \
    && rm -rf /var/lib/apt/lists/*

COPY microservices/battle/nginx/config/ /etc
COPY microservices/battle/nginx/scripts/ /usr/local/bin

RUN chmod +x /usr/local/bin/sensor.sh

RUN echo 01 > ca.srl \
    && openssl genrsa -out ca-key.pem 2048 \
    && openssl req -new -x509 -days 365 -subj "/CN=*" -key ca-key.pem -out ca.pem \
    && openssl genrsa -out server-key.pem 2048 \
    && openssl req -subj "/CN=*" -new -key server-key.pem -out server.csr \
    && openssl x509 -req -days 365 -in server.csr -CA ca.pem -CAkey ca-key.pem -out server-cert.pem \
    && openssl rsa -in server-key.pem -out server-key.pem \
    && cp *.pem /etc/nginx/ \
    && cp *.csr /etc/nginx/