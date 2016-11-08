1. Create a MySQL database
2. Go to phpMyAdmin and Import the file there vezuviy_baza.sql
3. prescribes a MySQL database in two files:

1 \ Domain \ application \ config \ database.php
2- \ subdomain \ application \ config \ database.php
-------------------------------------------------- ------------------------------------------

'Type' => 'mysql', // Skip the
'User' => 'user', // Then write the user name
'Pass' => 'password', // Then write your password
'Host' => 'localhost', // Skip the
'Port' => FALSE, // Skip the
'Socket' => FALSE, // Skip the
'Database' => 'database' // Then write the name of the database

------------------------------ After the changes save the file --------------- ---------------

4. Fill to your main domain that is in the domain folder
5. Create a subdomain or admin can be different and that is sudazh fill in the subdomain folder
6. To enter in the Admin Panel write a subdomain that you created and the site that is like this
. Poddomen.sayt (p, or what have you) Username: Admin Password: Admin

================================================== ==========================================
1. Sign up w1.ru
2. Go to the Settings section -> profile and fill in the fields.
3. Go to the section -> Regional Settings and choose a base currency (Russian Ruble)
4. Go to the section -> Internet store and do all that is shown in the picture (w1.png)
5. After you save the key and purse number in the \ Domain \ a pay \ will be file
(Setmerchant.php) and open it and insert my key and wallet number and the fale
enter their data to a database that pointed to configure the casino.
-------------------------------------------------- ------------------------------------------
$ Dbuname = 'user'; // Then write the user name
$ Dbpass = 'password'; // Here write your password
$ Dbhost = 'localhost'; // Skip
$ Dbname = 'user'; // Then write the user name
-------------------------------------------------- ------------------------------------------