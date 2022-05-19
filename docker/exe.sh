#!/bin/bash
cd ..
cp .env.example .env

cd docker
docker exec -it php composer install