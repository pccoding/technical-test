queue
=====

A Symfony project created on April 22, 2016, 10:18 am.

Hello David,
Please find my solution to your task attached to this repository
There is a branch name called rp/test where you can find all details related to the task
Before running the project please do an composer update because the application require mandrill library and doctrine/doctrine-migrations-bundle
Also if you could add the bundle new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle() to app kernel

you could run the application from cli using the command from symfony
 - php bin/console demo:processEmails

 Note: the application is not complete as I tried to stay in the limit of 2 hours
