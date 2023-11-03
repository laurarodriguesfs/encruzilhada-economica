#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
CDIR=$( pwd )
cd $DIR/../themes
zip -r ../zips/tema-conpedi.zip tema-conpedi -x "tema-conpedi/node_modules/*"
