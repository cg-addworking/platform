#!/usr/bin/env bash

DIR=".git"

if [ -d "$DIR" ]; then
  ln -fs ../../bin/commit-msg.sh .git/hooks/commit-msg
  ln -fs ../../bin/pre-commit.sh .git/hooks/pre-commit
fi