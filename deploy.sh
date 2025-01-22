#!/bin/bash

# Define services
SERVICES=( "user-service" "order-service" )

# Loop through each service
for SERVICE in "${SERVICES[@]}"; do

  IMAGE_NAME="${SERVICE}-image"
  IMAGE_TAG="latest"
  CONTAINER_NAME="${SERVICE}-container"
  HOST_PORT=$((8080 + $RANDOM % 1000)) # Assign a random port for demonstration
  CONTAINER_PORT=80

  # Stop and remove old container
  echo "Stopping and removing old container for $SERVICE..."
  docker stop $CONTAINER_NAME 2>/dev/null || true
  docker rm $CONTAINER_NAME 2>/dev/null || true

  # Build the Docker image
  echo "Building the Docker image for $SERVICE..."
  docker build -t $IMAGE_NAME:$IMAGE_TAG -f ${SERVICE}/Dockerfile ${SERVICE}

  # Run the Docker container
  echo "Running the Docker container for $SERVICE..."
  docker run -d --name $CONTAINER_NAME -p $HOST_PORT:$CONTAINER_PORT $IMAGE_NAME:$IMAGE_TAG

  echo "Deployment complete for $SERVICE!"
done
