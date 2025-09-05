#!/bin/bash
set -e

# Clear old containers
docker container prune -f

# Build containers
docker-compose build

# Run compose in detached mode
docker-compose up -d

# Run tests in container
if ! docker-compose run --rm app-test composer start-test; then
    echo "Tests failed! Stopping all containers..."
    docker-compose down
    exit 1
fi

echo "Tests passed! Showing app logs..."

docker logs -f app
