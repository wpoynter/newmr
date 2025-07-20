#!/usr/bin/env bash
set -euo pipefail

# Environment variables:
#   PROD_HOST        - Hostname of production server (required)
#   PROD_SSH_USER    - SSH user for production (defaults to current user)
#   PROD_DB_NAME     - Production database name (required)
#   PROD_WP_PATH     - Path to WordPress root on production (required)
#   PROD_PLUGINS     - Space separated plugin directories to copy (optional)

: "${PROD_HOST:?PROD_HOST is required}"
PROD_SSH_USER="${PROD_SSH_USER:-$USER}"
: "${PROD_DB_NAME:?PROD_DB_NAME is required}"
: "${PROD_WP_PATH:?PROD_WP_PATH is required}"
PROD_PLUGINS="${PROD_PLUGINS:-}"

REMOTE="${PROD_SSH_USER}@${PROD_HOST}"

# Import database
echo "Exporting database from ${REMOTE}..."
ssh "$REMOTE" "mysqldump ${PROD_DB_NAME}" | docker compose exec -T db mysql ${PROD_DB_NAME}

echo "Syncing uploads directory..."
mkdir -p wordpress/wp-content/uploads
rsync -avz --delete "${REMOTE}:${PROD_WP_PATH}/wp-content/uploads/" "wordpress/wp-content/uploads/"

for plugin in $PROD_PLUGINS; do
    echo "Syncing plugin $plugin..."
    mkdir -p "wordpress/wp-content/plugins/${plugin}"
    rsync -avz --delete "${REMOTE}:${PROD_WP_PATH}/wp-content/plugins/${plugin}/" "wordpress/wp-content/plugins/${plugin}/"
done

echo "Production data pull complete."
