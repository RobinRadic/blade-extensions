#!/bin/bash
set -e # Exit with nonzero exit code if anything fails

# - TRAVIS_ALLOW_FAILURE: Set to true if the job is allowed to fail. false if not.
# - TRAVIS_BRANCH: For builds not triggered by a pull request this is the name of the branch currently being built; whereas for builds triggered by a pull request this is the name of the branch targeted by the pull request (in many cases this will be master).
# - TRAVIS_BUILD_DIR: The absolute path to the directory where the repository being built has been copied on the worker.
# - TRAVIS_BUILD_ID: The id of the current build that Travis CI uses internally.
# - TRAVIS_BUILD_NUMBER: The number of the current build (for example, “4”).
# - TRAVIS_COMMIT: The commit that the current build is testing.
# - TRAVIS_COMMIT_MESSAGE: The commit subject and body, unwrapped.
# - TRAVIS_COMMIT_RANGE: The range of commits that were included in the push or pull request. (Note that this is empty for builds triggered by the initial commit of a new branch.)
# - TRAVIS_EVENT_TYPE: Indicates how the build was triggered. One of push, pull_request, api, cron.
# - TRAVIS_JOB_ID: The id of the current job that Travis CI uses internally.
# - TRAVIS_JOB_NUMBER: The number of the current job (for example, “4.1”).
# - TRAVIS_OS_NAME: On multi-OS builds, this value indicates the platform the job is running on. Values are linux and osx currently, to be extended in the future.
# - TRAVIS_PULL_REQUEST: The pull request number if the current job is a pull request, “false” if it’s not a pull request.
# - TRAVIS_PULL_REQUEST_BRANCH: If the current job is a pull request, the name of the branch from which the PR originated. "" if the current job is a push build.
# - TRAVIS_PULL_REQUEST_SHA: If the current job is a pull request, the commit SHA of the HEAD commit of the PR. If it is a push build, "".
# - TRAVIS_PULL_REQUEST_SLUG: If the current job is a pull request, the slug (in the form owner_name/repo_name) of the repository from which the PR originated. If it is a push build, "".
# - TRAVIS_REPO_SLUG: The slug (in form: owner_name/repo_name) of the repository currently being built. (for example, “travis-ci/travis-build”).
# - TRAVIS_SECURE_ENV_VARS: Whether or not encrypted environment vars are being used. This value is either “true” or “false”.
# - TRAVIS_SUDO: true or false based on whether sudo is enabled.
# - TRAVIS_TEST_RESULT: is set to 0 if the build is successful and 1 if the build is broken.
# - TRAVIS_TAG: If the current build is for a git tag, this variable is set to the tag’s name.

echo "TRAVIS_ALLOW_FAILURE=${TRAVIS_ALLOW_FAILURE}"
echo "TRAVIS_BRANCH=${TRAVIS_BRANCH}"
echo "TRAVIS_BUILD_DIR=${TRAVIS_BUILD_DIR}"
echo "TRAVIS_BUILD_ID=${TRAVIS_BUILD_ID}"
echo "TRAVIS_BUILD_NUMBER=${TRAVIS_BUILD_NUMBER}"
echo "TRAVIS_COMMIT=${TRAVIS_COMMIT}"
echo "TRAVIS_COMMIT_MESSAGE=${TRAVIS_COMMIT_MESSAGE}"
echo "TRAVIS_COMMIT_RANGE=${TRAVIS_COMMIT_RANGE}"
echo "TRAVIS_EVENT_TYPE=${TRAVIS_EVENT_TYPE}"
echo "TRAVIS_JOB_ID=${TRAVIS_JOB_ID}"
echo "TRAVIS_JOB_NUMBER=${TRAVIS_JOB_NUMBER}"
echo "TRAVIS_OS_NAME=${TRAVIS_OS_NAME}"
echo "TRAVIS_PULL_REQUEST=${TRAVIS_PULL_REQUEST}"
echo "TRAVIS_PULL_REQUEST_BRANCH=${TRAVIS_PULL_REQUEST_BRANCH}"
echo "TRAVIS_PULL_REQUEST_SHA=${TRAVIS_PULL_REQUEST_SHA}"
echo "TRAVIS_PULL_REQUEST_SLUG=${TRAVIS_PULL_REQUEST_SLUG}"
echo "TRAVIS_REPO_SLUG=${TRAVIS_REPO_SLUG}"
echo "TRAVIS_SECURE_ENV_VARS=${TRAVIS_SECURE_ENV_VARS}"
echo "TRAVIS_SUDO=${TRAVIS_SUDO}"
echo "TRAVIS_TEST_RESULT=${TRAVIS_TEST_RESULT}"
echo "TRAVIS_TAG=${TRAVIS_TAG}"
