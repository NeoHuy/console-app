Composer PHAR Template
=========================

If you are trying to create a new Console Application that is distributed as .phar file, this template of files will surely help you make the process a lot easier and faster.

Features
--------

* PSR-4 autoloading compliant structure
* Unit-Testing with PHPUnit
* Comprehensive Guides and tutorial
* Easy PHAR file building process
* Eloquent ORM support
* Powered by Symfony Console
* Easy configuration via .env file


## Build Environment


In order to build the phar file, you need to install the box command. To do so:
```
curl -LSs https://box-project.github.io/box2/installer.php | php
```

Make sure you turn off readonly setting of phar file in your php.ini. In PHP7:

```
sudo vi /etc/php/7.0/cli/php.ini
```
Find the *phar.readonly* settings and set it to *Off*


Now move the box.phar file to /usr/local/bin so it can be globally available in console.

```
sudo mv box.phar /usr/local/bin/box
sudo chmod 755 /usr/local/bin/box
```

You are now ready to build phar file!

```
box --version
```