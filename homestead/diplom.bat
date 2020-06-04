@echo off

set cwd=%cd%
set homesteadVagrant=C:\homestead

cd /d %homesteadVagrant% && vagrant %*
cd /d %cwd%

set cwd=
set homesteadVagrant=