# Project8_PhpUnit

Openclasrooms PHP/Symfony project 8 : PhpUnit
 
Developper : AureDev
 
Developped with : PHPStorm, WAMP64, PHPUnit, BlackFire

Languages : html, css, javascript, Symfony, Doctrine, Twig

Codacy badge : [![Codacy Badge](https://api.codacy.com/project/badge/Grade/5a6541e3097a4c2abc34ca3b57f4dd58)](https://www.codacy.com/app/Beskargam/Project8_PhpUnit?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Beskargam/Project8_PhpUnit&amp;utm_campaign=Badge_Grade)

Installation guide :
- 
    Clone the github project
    Create a mysql database and name it "project8_db" (php bin/console doctrine:database:create)
    Update the DATABASE_URL in your .env file
    Run a Doctrine migration to create the tables (php bin/console make:migration and php bin/console doctrine:migrations:migrate)
    Load a couple of fake tasks with the fixtures load (php bin/console doctrine:fixtures:load)
    Run the app on your localhost with the Symfony developpement server ! (cd project -> php bin/console server:run)

Good Practices for contributions :
- 
Controllers : 
1. All Controllers belong to themes. UserController belong to User functions, TaskController belong to Task functions, etc.
2. Clean the controllers. A function must be clean and therefor you can make a service callable for a function, DO IT ! (like forms)

Security : 
1. Login is secured with Symfony Guard
2. Some functions are secured with Voters to check user permissions

Tests : 
1. There are no UserFixtures. So if you want to load the successfull tests you need to adapt the tests or create 3 user profiles.
 - pseudotestadmin:horg_hvergelmir@hotmail.com:ROLE_ADMIN
 - pseudotest:zenways@laposte.net:ROLE_USER
 - pseudotest2PhpUnit:auredev@gmx.com:ROLE_ADMIN
 
 CODE FUN !