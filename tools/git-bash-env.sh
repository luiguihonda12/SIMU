#!/usr/bin/env bash

# Carga las herramientas instaladas en Windows cuando se trabaja desde Git Bash.
export PATH="/c/Users/Arroz/AppData/Local/Microsoft/WinGet/Packages/PHP.PHP.8.4_Microsoft.Winget.Source_8wekyb3d8bbwe:$PATH"
export PATH="/c/ProgramData/ComposerSetup/bin:/c/Program Files/MySQL/MySQL Server 8.4/bin:$PATH"

echo "SIMU: PHP $(php -r 'echo PHP_VERSION;') disponible"
