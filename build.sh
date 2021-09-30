#! /usr/bin/env bash

docker build --no-cache -t t4clibuild .
docker-compose run --rm t4cli app:build
# docker-compose run --rm t4cli app:build --build-version=0.0.7
docker-compose run --rm t4cli app:docker
cd builds
docker build --no-cache -t samyerkes/t4-cli .
cd ..

# docker run --rm --tty -p 8080:8080 -v ~/.t4:/root/.t4 samyerkes/t4-cli