#!/usr/bin/env bash

# get bash colors and styles here: http://misc.flogisoft.com/bash/tip_colors_and_formatting
C_RESET='\e[0m'
C_RED='\e[31m'
C_GREEN='\e[32m'
C_YELLOW='\e[33m'

function __run() #(step, name, cmd)
{
    local output exitcode

    printf "${C_YELLOW}[%s]${C_RESET} %-20s" "$1" "$2"
    output=$(eval "$3" 2>&1)
    exitcode=$?

    if [[ 0 == $exitcode || 130 == $exitcode ]]; then
        echo -e "${C_GREEN}OK!${C_RESET}"
    else
        echo -e "${C_RED}NOK!${C_RESET}\n\n$output"
        exit 1
    fi
}

# see https://stackoverflow.com/a/41730200/381220 for --diff-filter meaning
cached="git diff --name-only --diff-filter=d --cached | grep \".php$\""
ignore="resources/lang,resources/views,bootstrap/helpers,database/migrations,bin,Tests/Acceptance,Application/Langs,Application/Views"
phpcs="vendor/bin/phpcs --report=code --colors --report-width=80 --standard=PSR2 --ignore=${ignore}"

__run "1/4" "php lint" "${cached} | xargs -r /usr/bin/env php -l"
__run "2/4" "code sniffer" "${cached} | xargs -r ${phpcs}"
__run "3/4" "phpstan" "${cached} | xargs -r vendor/bin/phpstan analyse"
__run "4/4" "translations" "${cached} | xargs -r php artisan translation:check"
