### Evt
---
*This project  is still in development*

REST API interface for an event booking application. Record events, view them, edit and delete them. Its written in Vanilla php and makes use of the OOP paradigm.

To run this application on your local system, you need to have PHP 7 and composer installed. Get them [here](https://www.php.net/downloads.php "here") and [here](https://getcomposer.org/download/ "here") respectively.

Navigate to a directory of choice on your local system and run the following command

```
git clone https://github.com/olamileke/evt.git
```
This will clone this repository onto your local system. Next up, run the following command to navigate into your cloned copy of this repo.
```
cd Evt
```

Then, we need to install all the application dependencies. Do this by running
```
composer require
```
This will install all the application dependencies located in the composer.json file in the application root.  On your local server, create a database named *evt* or whatever name you would like.Then, rename the .env.example file in the application root to .env and do the following

- Set DB_HOST to localhost
- Set DB_NAME to evt or whatever name you set
- Set DB_USERNAME to a username for your local db server
- Set DB_PASSWORD to a valid password for your local db server
- Set SECRET_KEY to a random 32 character string

Next up, we need to setup our local server to point to the front controller located in the /Public directory.
For xampp users, navigate to your  *apache/conf* folder which contains all the configurations for your local apache server. Locate the *httpd.conf*  file and search for the *DocumentRoot*  option.  Set it to the *Public*  folder of your cloned Evt directory. Note that, it needs to be the absolute path to this *Evt/Public* folder.  Reload your server to have the changes take effect.

For wamp users, follow this [guide](https://john-dugan.com/wamp-vhost-setup/ "guide") to find your *httpd.conf*  file.

Finally, open up the *Public/index.php* file to view a list of all the routes for the application. Make use of curl, Postman or any other similar utility to make calls to the API. Make sure to prefix the routes with *http://localhost* like *http://ocalhost/api/v1/signup* or *http://localhost:8080/api/v1/signup* if your local server is running on the 8080 port.
