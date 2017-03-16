#!/bin/bash
mydir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

rm -rf "$mydir/../build" >> /dev/null

#chmod +x "$mydir/pre-commit"
#cp "$mydir/pre-commit" "$mydir/../.git/hooks/pre-commit"

cd "$mydir/.."
git clone https://github.com/laradic/php-build-tools build
cd build
chmod +x tools-download.sh
./tools-download.sh -vd
