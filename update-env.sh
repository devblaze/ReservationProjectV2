#!/bin/sh

set -e

apk add --no-cache curl jq
echo 'Installed curl and jq'

for i in $(seq 1 30); do
    echo "Attempt $i: Fetching ngrok URL..."
    TUNNELS=$(curl -s --max-time 5 http://ngrok:4040/api/tunnels)
    echo "Raw tunnels data:"
    echo "$TUNNELS"
    NGROK_URL=$(echo "$TUNNELS" | jq -r '.tunnels[] | select(.proto=="https") | .public_url' | head -n1)
    
    if [ ! -z "$NGROK_URL" ]; then
        echo "Ngrok URL found: $NGROK_URL"
        sed -i "s|APP_URL=.*|APP_URL=$NGROK_URL|g" /app/.env.production
        sed -i "s|VITE_HMR_HOST=.*|VITE_HMR_HOST=${NGROK_URL#https://}|g" /app/.env.production
        echo "Updated .env.production file"
        cat /app/.env.production
        
        # Export variables for other services to use
        echo "APP_URL=$NGROK_URL" >> /app/.env
        echo "VITE_HMR_HOST=${NGROK_URL#https://}" >> /app/.env
        
        exit 0
    else
        echo "Ngrok URL not found, retrying in 10 seconds..."
        sleep 10
    fi
done

echo "Failed to get ngrok URL after 30 attempts"
exit 1
