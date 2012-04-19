To Test a Bundle like being inside a standard Symfony app do the following steps:

How to configure it:
- Copy all the files inside the root Bundle dir

- Edit the file Tests/autoload.php.dist and change the 'Your\\Bundle\Namespace' according to the Namespace of your bundle, also in the line:
$path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 3)
change the number 3 for the number of slashes of your Namespace, in the previous example it is 3.

- Setup .travis.yml and the rest of files for more specific config for your bundle

What does this do?
- Download the dependencies specified in vendor/vendors.php file

- Run a phpunit command which reads the config of phpunit.xml.dist

- Setup the Symfony2 environment configuration specified in Tests/bootstrap.php

- Setup autoload config specified in Tests/autoload.php

- Run the Tests