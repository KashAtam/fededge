#!/bin/bash

# Script to apply Kubernetes deployment manifests and rollout the app deployment

set -e  # Exit on any error

# Accept environment argument, default to dev
ENV=${1:-dev}
CONFIG_DIR="deploy/config/$ENV"
DEPLOYMENT_NAME="$ENV-witness-it-app"

echo -e "\n$ENV: Applying Kubernetes manifests\n"

# Apply manifests in the correct order to avoid dependency errors
echo -e "\n# Create Namespace"
kubectl apply -f "deploy/config/namespace.yaml"

echo -e "\n# Doppler secrets"
kubectl apply -f "$CONFIG_DIR/doppler.yaml"

echo -e "\n# Certificate & Ingress"
kubectl apply -f "$CONFIG_DIR/certificate.yaml"
kubectl apply -f "$CONFIG_DIR/ingress.yaml"

echo -e "\n# Databases (MySQL & Redis)"
kubectl apply -f "$CONFIG_DIR/mysql.yaml"
kubectl apply -f "$CONFIG_DIR/redis.yaml"

echo -e "\n# Main app & other services"
kubectl apply -f "$CONFIG_DIR/app.yaml"

echo -e "\n# Restarting the deployment to pick up new image and config changes. With zero downtime strategy, this should not cause any disruption."
kubectl rollout restart deployment $DEPLOYMENT_NAME -n witness-it

echo -e "\n# Waiting for rollout to complete..."
kubectl rollout status deployment $DEPLOYMENT_NAME -n witness-it

echo -e "\nDeployment & Rollout completed successfully - $ENV."
