#!/bin/bash

if [ ! -f phploc.phar ]; then
    echo "Downloading phploc.phar from phpunit.de"
    wget https://phar.phpunit.de/phploc.phar
    echo "Done."
fi

if [ -f phpstats.csv ]; then
    echo "Existing phpstats.csv will be removed"
    read -n 1 -s -r -p "Press any key to continue or CTRL+C to cancel"
    echo
    rm -f phpstats.csv
fi

GIT_CHECKOUT_EXIT_CODE=0

while [ $GIT_CHECKOUT_EXIT_CODE = "0" ]; do
    GIT_LOG=$(git log --date=short --format='%h,%ad,%ae' HEAD^..HEAD)
    echo $GIT_LOG
    php phploc.phar --count-tests --log-csv phploc.csv -- app/ tests/ >/dev/null

    if [ ! -f phpstats.csv ]; then
        CSV_HEAD=$(head -n 1 phploc.csv)
        echo "Commit,Date,Author,${CSV_HEAD}" > phpstats.csv
    fi

    CSV_DATA=$(tail -n 1 phploc.csv)
    echo "${GIT_LOG},${CSV_DATA}" >> phpstats.csv
    rm phploc.csv

    GIT_CHECKOUT_OUTPUT=$(git checkout HEAD~1 2>&1)
    GIT_CHECKOUT_EXIT_CODE=$?
done

echo -e "\n${GIT_CHECKOUT_OUTPUT}"
