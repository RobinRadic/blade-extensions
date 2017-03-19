#!/bin/bash
set -e # Exit with nonzero exit code if anything fails

# TRAVIS_PULL_REQUEST
# TRAVIS_BRANCH
if [ "$TRAVIS_EVENT_TYPE" != 'push' ]; then
    echo "Skipping. TRAVIS_EVENT_TYPE=${TRAVIS_EVENT_TYPE}"
    exit 0
fi
if [ "$TRAVIS_PHP_VERSION" != "5.6" -o "$MINOR_VERSION" != "4" ]; then
    echo "Skipping. TRAVIS_PHP_VERSION=${TRAVIS_PHP_VERSION} MINOR_VERSION=${MINOR_VERSION}"
    exit 0
fi
#git remote set-url origin "https://${GITHUB_SECRET_TOKEN}@github.com/radic/blade-extensions"

git config user.name "Travis CI"
git config user.email "robin@radic.nl"
git config push.default matching
git config credential.helper "store --file=.git/credentials"
echo "https://${GITHUB_SECRET_TOKEN}:@github.com" > .git/credentials

php-cs-fixer fix src --config-file .php_cs || true
git add -A src
git commit -m "Apply style fixes for ${TRAVIS_BUILD_ID} [skip ci]"
HASH=$(cat .git/HEAD)
git checkout $TRAVIS_BRANCH
git cherry-pick $HASH
git push
