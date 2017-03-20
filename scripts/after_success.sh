#!/bin/bash
set -e # Exit with nonzero exit code if anything fails

mydir=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

if [ "$TRAVIS_EVENT_TYPE" != 'push' ]; then
    echo "Skipping. TRAVIS_EVENT_TYPE=${TRAVIS_EVENT_TYPE}"
    exit 0
fi
if [ "$TRAVIS_PHP_VERSION" != "5.6" -o "$MINOR_VERSION" != "4" ]; then
    echo "Skipping. TRAVIS_PHP_VERSION=${TRAVIS_PHP_VERSION} MINOR_VERSION=${MINOR_VERSION}"
    exit 0
fi
if [ "$TRAVIS_BRANCH" == "master" ]; then
    echo "Skipping, TRAVIS_BRANCH = $TRAVIS_BRANCH"
    exit 0
fi

DONE="0"
while [ $DONE -lt 1 ]; do
    curl -s -X GET \
    -o "$mydir/.curl-output" \
    -H "Content-Type: application/json" \
    -H "User-Agent: MyClient/1.0.0" \
    -H "Accept: application/vnd.travis-ci.2+json" \
     "https://api.travis-ci.org/builds/${TRAVIS_BUILD_ID}"

    OUTPUT=$(php $mydir/check-state.php)
    if [ "$OUTPUT" == "fail" ]; then
        echo "build failed"
        exit 1
    elif [ "$OUTPUT" == "pass" ]; then
        DONE=1
    elif [ "$OUTPUT" == "wait" ]; then
        echo "Checking again in 10 sec"
    elif [ "$OUTPUT" == "error" ]; then
        echo "error with curl output"
        exit 1
    fi
    sleep 15
done


git config user.name "Travis CI"
git config user.email "robin@radic.nl"
git config push.default matching
git config credential.helper "store --file=.git/credentials"
echo "https://${GITHUB_SECRET_TOKEN}:@github.com" > .git/credentials

git add -A src
git commit -m "Apply style fixes for ${TRAVIS_BUILD_ID} [skip ci]"
HASH=$(cat .git/HEAD)
git checkout $TRAVIS_BRANCH
git cherry-pick $HASH
git push origin $TRAVIS_BRANCH

if [ "$TRAVIS_BRANCH" == "develop" ]; then
    git remote set-branches --add origin master
    git fetch
    git checkout -b master origin/master
    git merge develop
    git push origin master
fi
