#!/usr/bin/env bash

sudo docker-compose -f ../docker-compose.yml --project-directory ./ up -d nginx mysql
