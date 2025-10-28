#!/bin/bash 

# 1. Descobre o caminho absoluto para este script (ex: /.../dev-scripts)
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# 2. Muda para o diretório do script (COM ASPAS!)
cd "$DIR"

# 3. Executa os outros scripts
./compilar.sh
./zip.sh
