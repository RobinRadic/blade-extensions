#!/bin/bash

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
source "${MYDIR}/_main.sh"

if [ "$is_help" == "true" ]; then
    cat << EOF

$(f bold)$(fc green)help$(f off)

$(f bold)Name:          $(f off)$(fc cyan)git-submodule-update.sh $(f off)
$(f bold)Description:   $(f off)Updates submodules in the current working directory

$(f bold)Arguments:     $(f off)
    -h                     $(fc orange)(optional)$(f off) Show this help overview
    -v                     $(fc orange)(optional)$(f off) Enable verbose output
    -d                     $(fc orange)(optional)$(f off) Enable debug output
    -p <path>              $(fc orange)(optional)$(f off) only update specified submodule <path>

$(f bold)Examples:      $(f off)
    $(fc orange)Update all submodules $(f off)
        ./build/tools/git-submodule-update.sh

    $(fc orange)Update submodule lib/mysubmod1 $(f off)
        ./build/tools/git-submodule-update.sh -p lib/mysubmod1

    $(fc orange)Update submodule lib/mysubmod1 and show verbose and debug output$(f off)
        ./build/tools/git-submodule-update.sh -v -d -p lib/mysubmod1

EOF
    exit 0
fi

Echo "Doing submodule update in ${PWD}"

Exec 'git submodule update --init --recursive --remote --force $pflag'

if [ "$pflag" == "" ]; then
    Exec `git submodule foreach -q --recursive 'branch="$(git config -f $toplevel/.gitmodules submodule.$name.branch)" && git fetch --all > /dev/null 2>&1  && git checkout $branch  > /dev/null 2>&1 && git pull  > /dev/null 2>&1'`
else
    Echo info "Got a mflag: ${pflag}"
    thisdir="$PWD"
    cd "$pflag"
    branch="$(git config -f $toplevel/.gitmodules submodule.$name.branch)"
    git fetch --all
    git checkout "$branch"
    git pull  > /dev/null 2>&1
fi





#if promptyn "Are you sure?"; then
#    Echo success "Good"
#fi
