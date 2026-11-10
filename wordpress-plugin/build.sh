#!/usr/bin/env bash
# Kopiert die aktuelle index.html ins Plugin und erzeugt periodensystem.zip
set -euo pipefail
cd "$(dirname "$0")"
cp ../index.html periodensystem/app/index.html
rm -f periodensystem.zip
zip -rq periodensystem.zip periodensystem
echo "Fertig: $(pwd)/periodensystem.zip"
