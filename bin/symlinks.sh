#!/bin/bash

function __link() #(name)
{
    if [[ -d "vendor/addworking/${1}" && ! -L "vendor/addworking/${1}" ]]; then
        rm -rf "vendor/addworking/${1}"
    fi

    if [ ! -L "vendor/addworking/${1}" ]; then
        ln -fs "../../../${1}" "vendor/addworking/${1}"
    fi
}

__link 'foundation'
__link 'laravel-bootstrap'
