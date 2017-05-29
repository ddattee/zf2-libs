#!/bin/bash

cd ..

if [ -d .git ]; then
    git push https://github.com/dada87/libs master:master --tags
fi