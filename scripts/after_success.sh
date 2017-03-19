#!/bin/bash
set -e # Exit with nonzero exit code if anything fails

# TRAVIS_PULL_REQUEST
# TRAVIS_BRANCH
if [ "$TRAVIS_EVENT_TYPE" != 'push' ]; then
    echo "after_success: Skipping"
    exit 0
fi

git config user.name "Travis CI"
git config user.email "robin@radic.nl"
#git remote set-url origin "https://${GITHUB_SECRET_TOKEN}@github.com/radic/blade-extensions"
git config credential.helper "store --file=.git/credentials"
echo "https://${GITHUB_SECRET_TOKEN}:@github.com" > .git/credentials

echo "after_success: Git configured"
git status
git add -A
echo "after_success: git add -A"
git status
git commit -m "TravisCI php-cs-fixer changes for: ${TRAVIS_BUILD_ID}"
echo "after_success: git commit "
git status
git push
echo "after_success: git push"
