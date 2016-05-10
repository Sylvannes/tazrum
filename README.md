TaZrum 4
========

Welcome to the TaZrum 4 source code!

[TaZrum](http://www.tazrum.nl/) is the best forum on the internet. Its community
mainly focuses on drinking rum, but other spirits, liquors, cocktails or even
any other kind of brewed alcoholic beverage are also paid plenty of attention.


REQUIREMENTS
------------

The project requires a web server running PHP 5.6. It uses composer for PHP
package management and MySQL for the data storage.


FIRST TIME SETUP
----------------

### Clone the project

	$ git clone https://github.com/SagaLhan/tazrum.git


### Install Composer packages

If you do not have [Composer](http://getcomposer.org/), you may install it by
following the instructions at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install the required packages of this project using the following
command:

	$ composer update


### Prepare the database

To build the database, first set the credentials to your database in
`config/db.php`. You can use `db.php.default` as an example.

Make sure the database with the specified name (default `tazrum4`) exists on the
database server. It does not need to contain any tables. The character set
should be `utf8` and the default collation should be `utf8_general_ci`.

### Build project

Execute the following line:

	vendor/phing/phing/bin/phing

This runs migrations that set up the database structure.

It is recommended to insert an initial data set for testing, with the following
command:

	$ ./yii debugdata/create

To get rid of the debug data again, use the following command:

	$ ./yii debugdata/destroy

### Configure the web server

Next, configure your webserver to serve the files, and make sure to add
configuration for Yii rewrite rules. An example configuration:

	<VirtualHost *:80>
		DocumentRoot "/home/taz/personal/tazrum/web"
		ServerName tazrum.local

		<Directory "/home/taz/personal/tazrum/web">
			Options Indexes FollowSymLinks
			AllowOverride All
			Require all granted
		</Directory>
	</VirtualHost>


### Configure hosts file

Add `127.0.0.1` to your hosts file, named as `tazrum.local`.

Now you should be able to access the application through the following URL:

	http://tazrum.local/
