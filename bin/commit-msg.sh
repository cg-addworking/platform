#!/usr/bin/env bash

# # set this to your active development branch
# develop_branch="develop"
# current_branch="$(git rev-parse --abbrev-ref HEAD)"
#
# # only check commit messages on main development branch
# [ "$current_branch" != "$develop_branch" ] && exit 0

# regex to validate in commit msg
commit_regex='^(feature|fix|chore|refactor|infrastructure): \w+'
error_msg="\e[43m\e[30mAborting commit.\e[0m Your commit message is missing its type (feature, fix, etc.):"

if ! grep -iqE "$commit_regex" "$1"; then
    echo -e "$error_msg\n\n\t$(cat $1)" >&2
    exit 1
fi
