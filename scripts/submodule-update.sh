#!/bin/bash
# http://stackoverflow.com/questions/1777854/git-submodules-specify-a-branch-tag/18799234#18799234
git submodule update --init --recursive --remote --force

# get out of detached head state
git submodule foreach -q --recursive 'branch="$(git config -f $toplevel/.gitmodules submodule.$name.branch)"; git checkout $branch'

