#!/usr/bin/env bash
set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"
source "$SCRIPT_DIR/git-bash-env.sh"
cd "$PROJECT_DIR"

echo 'SIMU disponible en http://127.0.0.1:8000/index.php?pg=inicio'
php -S 127.0.0.1:8000 -t .
