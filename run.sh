#!/bin/bash
set -e

# Check if first argument is "include-tests"
INCLUDE_TESTS=false
if [ "$1" == "include-tests" ]; then
    INCLUDE_TESTS=true
fi

# Clear old containers
docker stop app-test || true
docker stop web || true
docker stop app || true
docker stop db || true
docker container prune -f

# Build containers
docker-compose build

if [ "$INCLUDE_TESTS" = true ]; then
    # Run compose in detached mode wth all services
    docker-compose up -d
    sleep 5
    # Run tests in container
    if ! docker-compose run --rm app-test composer start-test; then
        echo "Tests failed! Stopping all containers..."
        docker stop app-test || true
        docker stop web || true
        docker stop app || true
        docker stop db || true
        docker container prune -f
        exit 1
    fi

    echo "Tests passed! Showing app logs..."
    docker logs -f app
else
    # Run compose in detached mode wth test container excluded
    docker-compose up -d --scale app-test=0
    echo "Tests skipped. Showing app logs..."
    docker logs -f app
fi
