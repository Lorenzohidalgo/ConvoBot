# ConvoBot

[ConvoBot](https://github.com/Lorenzohidalgo/ConvoBot) is a project formed by a Telegram Bot and a Web Application with the purpose of easing the effort of handling convocations for groups. The Web Application allow the users to view statistics about the users' usage behavior to enable the senders to boost the convocations efficiency. 


## Installation

To install the project you should first install a MariaDB or Mysql DB instance and run the provided SQL script. You should then update the .env file from the Web Application folder and the CON_PROP.py from the Chat Bot Folder with the new credentials to the DB.

To run the Telegram Chat Bot you will need Telegram Bot Token provided by @BotFather which you will need to insert into the CON_PROP.py file from the Chat Bot Folder.

Once conigured the data base and updated the connection property files, you will need to install the following software dependencies:

Telegram Chat Bot:
```bash
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install python3 python3-pip
sudo pip3 install python-telegram-bot DateTime mysql-connector-python AST python-dateutil
```

Web Application:
```bash
sudo apt-get update 
sudo apt-get upgrade
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install apache2 libapache2-mod-php7.2 php7.2 php7.2-xml php7.2-gd php7.2-opcache php7.2-mbstring
cd /tmp
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer require consoletvs/charts:6.*
```

## Usage

To run the Chat Bot you should use the following command:

```bash
python3 TB.py
```

To run the Web Application on the local computer you may use the following command or follow these [instructions](https://medium.com/@abedxh/deploy-laravel-5-4-project-in-ubuntu-16-04-apache-based-server-538d4620bb97):

```bash
php artisan serve
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
