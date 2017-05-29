#!/bin/bash

cd ..

if [ -d .git ]; then
    git push --tags --mirror git@github.com:dada87/libs.git master:master
fi