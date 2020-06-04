1. установить 
https://www.virtualbox.org/wiki/Downloads
https://www.vagrantup.com/downloads.html
https://git-scm.com/download/win
2. Добавить виртуальную машину в консоли (Win+R)
vagrant box add laravel/homestead
при установке выбрать 3) virtualbox
3. Склонировать гит
git clone https://github.com/laravel/homestead.git c:/homestead
cd c:\homestead
git checkout release
c:/homestead/init.bat
4. Редактируем конфигурацию c:\homestead\Homestead.yaml

5. Добавляем айпи в hosts
C:\Windows\System32\drivers\etc\hosts
192.168.10.10  diplom.test

6. Поднять вагрант
создаем батник homestead.bat с содержимым
 @echo off

set cwd=%cd%
set homesteadVagrant=C:\Homestead

cd /d %homesteadVagrant% && vagrant %*
cd /d %cwd%

set cwd=
set homesteadVagrant=

Теперь можно вызывать команды вагрант как 
homestead.bat up
homestead.bat ssh
или добавить батник в PATH и использовать
vagrant up
vagrant ssh

при изменении конфигурации: vagrant reload --provision

7. Клонируем репозиторий
git clone https://github.com/GiTsu/diplom.git c:/diplom
cd c:/diplom
git checkout -b develop origin/develop

В папке появятся файлы проекта
Создаем .env файл, копируя из .env.example
Переходим на http://192.168.10.10/ или diplom.test (перезагрузка браузера) 
наблюдаем No input file specified, если неправильно указаны пути
наблюдаем ошибки PHP если все ок.
8. Запускаем сайт
Заходим по ssh: diplom.bat ssh

cd code/diplom
composer install

Заливаем базу 

mysql -u root -psecret homestead < ~/code/diplom/db_sample/prod_20200603.sql


