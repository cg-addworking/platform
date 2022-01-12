#!/bin/bash

commits=`git log --all --since="${1:-"3 months ago"}" --pretty=format:"%h"`

for id in $commits; do
    stats=$(git show -s --format="%ci,%h,%an" $id)
    changes=$(git show --numstat --oneline $id | tail -n +2 | awk '{ print $1+$2 }' | paste -sd+ | bc)
    echo "${stats},${changes}"
done
