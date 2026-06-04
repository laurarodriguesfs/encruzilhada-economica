#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
CDIR=$( pwd )
cd $DIR/../themes
zip -r ../zips/tema-encruzilhada-economica.zip tema-encruzilhada-economica -x "tema-encruzilhada-economica/node_modules/*"
