#!/bin/bash

cd ..

if [ -f .git ]; then
    git push https://github.com/dada87/libs master:master --tags
endif