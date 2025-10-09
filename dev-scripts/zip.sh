#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
CDIR=$( pwd )
cd $DIR/../themes
zip -r ../zips/tema-lopes-e-vasconcelos.zip tema-lopes-e-vasconcelos -x "tema-lopes-e-vasconcelos/node_modules/*"
