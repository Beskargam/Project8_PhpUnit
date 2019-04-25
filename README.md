# Project8_PhpUnit

Openclasrooms PHP/Symfony project 8 : PhpUnit
 
developper : AureDev
 
Developped with : PHPStorm, WAMP64

languages : html, css, javascript, Symfony, Doctrine, Twig

installation guide :

    Clone the github project
    Create a mysql database and name it "project8_db" (php bin/console doctrine:database:create)
    Update the DATABASE_URL in your .env file
    Run a Doctrine migration to create the tables (php bin/console doctrine:migrations:migrate or php bin/console d:m:m)
    Load a couple of fake articles with the fixtures load (php bin/console doctrine:fixtures:load or php bin/console d:f:l)
    Run the app on your localhost with the Symfony developpement server ! (cd project -> php bin/console server:run)

Codacy badge : [![Codacy Badge](https://api.codacy.com/project/badge/Grade/5a6541e3097a4c2abc34ca3b57f4dd58)](https://www.codacy.com/app/Beskargam/Project8_PhpUnit?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Beskargam/Project8_PhpUnit&amp;utm_campaign=Badge_Grade)
