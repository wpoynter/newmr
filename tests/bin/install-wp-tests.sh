#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/../.." && pwd)"
WP_TESTS_DIR="$ROOT_DIR/tests/wordpress"
WP_CORE_DIR="$ROOT_DIR/wordpress"
WP_PHPUNIT_DIR="$ROOT_DIR/vendor/wp-phpunit/wp-phpunit"

if [ -d "$WP_TESTS_DIR" ]; then
  exit 0
fi

echo "Setting up WordPress test environment in $WP_TESTS_DIR"

mkdir -p "$WP_TESTS_DIR"

cp -R "$WP_CORE_DIR"/. "$WP_TESTS_DIR"/
ln -s "$WP_PHPUNIT_DIR" "$WP_TESTS_DIR/wp-phpunit"

echo "WordPress test environment ready."
