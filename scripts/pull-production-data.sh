#!/usr/bin/env bash
set -euo pipefail

# Environment variables:
#   PROD_HOST        - Hostname of production server (required)
#   PROD_SSH_USER    - SSH user for production (defaults to current user)
#   PROD_SSH_PORT    - SSH port for production (defaults to 22)
#   PROD_DB_NAME     - Production database name (required)
#   PROD_DB_USER     - (optional) Production DB username
#   PROD_DB_PASS     - (optional) Production DB password
#   PROD_WP_PATH     - Path to WordPress root on production (required)
#   PROD_PLUGINS     - Space separated plugin directories to copy (optional)

: "${PROD_HOST:?PROD_HOST is required}"
PROD_SSH_USER="${PROD_SSH_USER:-$USER}"
PROD_SSH_PORT="${PROD_SSH_PORT:-22}"
: "${PROD_DB_NAME:?PROD_DB_NAME is required}"
# these two are optional:
PROD_DB_USER="${PROD_DB_USER:-}"
PROD_DB_PASS="${PROD_DB_PASS:-}"
: "${PROD_WP_PATH:?PROD_WP_PATH is required}"
PROD_PLUGINS="${PROD_PLUGINS:-}"

REMOTE="${PROD_SSH_USER}@${PROD_HOST}"
SSH_ARGS=(-p "${PROD_SSH_PORT}")
RSYNC_SSH="ssh ${SSH_ARGS[*]}"

# build optional mysqldump auth args
DB_AUTH_ARGS=()
if [ -n "$PROD_DB_USER" ]; then
    DB_AUTH_ARGS+=(-u "$PROD_DB_USER")
fi
if [ -n "$PROD_DB_PASS" ]; then
    DB_AUTH_ARGS+=(-p"$PROD_DB_PASS")
fi

echo "Exporting database from ${REMOTE}:${PROD_SSH_PORT}..."
echo "Running command: ssh ${SSH_ARGS[*]} ${REMOTE} \"mysqldump ${DB_AUTH_ARGS[*]} ${PROD_DB_NAME}\" | docker compose exec -T db mysql ${PROD_DB_NAME}"
ssh "${SSH_ARGS[@]}" "$REMOTE" "mysqldump ${DB_AUTH_ARGS[*]} ${PROD_DB_NAME}" \
    | docker compose exec -T db mysql -u wordpress -pwordpress wordpress

echo "Syncing uploads directory..."
mkdir -p wordpress/wp-content/uploads
rsync -avz -e "$RSYNC_SSH" --delete \
    "${REMOTE}:${PROD_WP_PATH}/wp-content/uploads/" \
    "wordpress/wp-content/uploads/"

for plugin in $PROD_PLUGINS; do
    echo "Syncing plugin $plugin..."
    mkdir -p "wordpress/wp-content/plugins/${plugin}"
    rsync -avz -e "$RSYNC_SSH" --delete \
        "${REMOTE}:${PROD_WP_PATH}/wp-content/plugins/${plugin}/" \
        "wordpress/wp-content/plugins/${plugin}/"
done

echo "Production data pull complete."
