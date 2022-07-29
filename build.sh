#!/usr/bin/env bash

sudo docker-compose -f ../docker-compose.yml --project-directory ./ build nginx mysql
