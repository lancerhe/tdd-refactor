# tdd-refactor

## Introduction

For refactor.

## Install

Make sure install git, php version 5.4+ with yaf extension.  
for extension config:

    [Yaf]
    extension=yaf.so
    yaf.environ=local
    yaf.cache_config=0
    yaf.name_suffix=0
    yaf.name_separator="_"
    yaf.forward_limit=5
    yaf.use_namespace=1
    yaf.use_spl_autoload=1
    yaf.lowcase_path=1

Auto install:

Install PHP 5.4.33  
https://github.com/LancerHe/awesome-setup/blob/master/install/php.sh

Install PHP Extension(YAF)  
https://github.com/LancerHe/awesome-setup/blob/master/install/php-ext.sh

Install Git  
https://github.com/LancerHe/awesome-setup/blob/master/install/git.sh

## Run Test
    
    cd /git-project/
    composer install
        Warning: This development build of composer is over 30 days old. It is recommended to update it by running "/usr/local/php-

        5.4.33/bin/composer.phar self-update" to get the latest version.
        Loading composer repositories with package information
        Installing dependencies (including require-dev) from lock file
          - Installing catfan/medoo (dev-master 920ae29)
            Cloning 920ae293ee87286f955a5265124509695e172434

        catfan/medoo suggests installing ext-pdo-mysql (For MySQL or MariaDB databases)
        catfan/medoo suggests installing ext-pdo-pqsql (For PostgreSQL databases)
        catfan/medoo suggests installing ext-pdo-sqlite (For SQLite databases)
        catfan/medoo suggests installing ext-pdo_dblib (For MSSQL or Sybase databases on Liunx/UNIX platform)
        catfan/medoo suggests installing ext-pdo_oci (For Oracle databases)
        catfan/medoo suggests installing ext-pdo_sqlsrv (For MSSQL databases on Windows platform)
        Generating autoload files

    phpunit -c tests/phpunit.xml
        PHPUnit 4.1.3 by Sebastian Bergmann.

        Configuration read from /data/tests/phpunit.xml

        .

        Time: 719 ms, Memory: 3.50Mb

        OK (1 test, 3 assertions)
