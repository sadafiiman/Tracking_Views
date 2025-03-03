#!/bin/bash

if ! command -v docker &> /dev/null
then
    echo "Docker is not installed. Please install Docker first."
    exit 1
fi

if ! command -v docker-compose &> /dev/null
then
    echo "Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

echo "Configuring Docker DNS..."
if [ ! -f "/etc/docker/daemon.json" ]; then
    echo "Creating Docker DNS config..."
    echo '{
      "dns": ["8.8.8.8", "8.8.4.4"]
    }' | sudo tee /etc/docker/daemon.json
    sudo systemctl restart docker
    echo "Docker DNS configured successfully."
else
    echo "Docker DNS config already exists. Skipping DNS configuration."
fi


echo "Building and starting the Docker containers..."
docker-compose up --build --force-recreate -d


if [ $? -eq 0 ]; then
    echo "Application started successfully!"
else
    echo "There was an error while starting the application."
    exit 1
fi

echo "Tailing logs from the application..."
docker-compose logs -f
