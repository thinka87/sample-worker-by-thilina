# sample-worker-by-thilina

## Technologies
***
A list of technologies used within the project:
* Vanila PHP
* pthreads  (Requires a build of PHP with ZTS (Zend Thread Safety) enabled)
* mysql database
## Run
***
* create a databse and import url_list.sql
* change database configrations in src/DbAccess.php
* For the testing purpose we can reset the data in url_list table , disabling comment in src/JobCaller.php line 21
* run index.php
