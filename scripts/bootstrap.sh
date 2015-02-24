#!/bin/sh

# http://stackoverflow.com/questions/1777854/git-submodules-specify-a-branch-tag/18799234#18799234
git submodule update --init --recursive --remote --no-fetch

# get out of detached head state
git submodule foreach -q --recursive 'branch="$(git config -f $toplevel/.gitmodules submodule.$name.branch)"; git checkout $branch; git pull'

cp -f scripts/pre-commit .git/hooks/pre-commit
echo "Added git pre-commit hook"
cp -f scripts/pre-push .git/hooks/pre-push
echo "Added git pre-push hook"
cp -f build/tools/phing.phar phing
echo "Added phing"
