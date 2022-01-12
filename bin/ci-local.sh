#!/usr/bin/env bash

# get bash colors and styles here: http://misc.flogisoft.com/bash/tip_colors_and_formatting
C_RESET='\e[0m'
C_RED='\e[31m'
C_GREEN='\e[32m'
C_YELLOW='\e[33m'

function __run() #(step, name, cmd)
{
    local color output exitcode

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

__run "1/7" "routes" "php artisan route:list --ansi"
__run "2/7" "php lint" "find . -path ./vendor -prune -o -name '*.php' -print0 | xargs -0 -n1 -P16  php -l > /dev/null"
__run "3/7" "code sniffer" "vendor/bin/phpcs --standard=PSR2 --colors app/ components/ --ignore=Application/Langs,Application/Views,Tests/Acceptance,*.js,components/Infrastructure/LaravelBootstrap/Application/components,components/Infrastructure/LaravelBootstrap/Application/layouts"
__run "4/7" "phpstan" "vendor/bin/phpstan analyse -c phpstan.neon"
__run "5/7" "translations" "php artisan translation:check"
__run "6/7" "behavior test" "vendor/bin/behat --list-scenarios | vendor/bin/fastest 'vendor/bin/behat --stop-on-failure --colors --no-interaction {}'"
__run "7/7" "unit test" "find tests/ -name '*Test.php' | vendor/bin/fastest 'vendor/bin/phpunit -c phpunit.xml --stop-on-error --stop-on-failure {};'"
