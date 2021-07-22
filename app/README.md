# symfony_docker-compose

Symfony5 Application which shows AWS services, possibility to create regular user (not being able to go to route /admin or /api, if you want to register as an admin change 'ROLE_USER' to 'ROLE_ADMIN' in App/src/Controller/RegisterController) and CRUD Service Entity---> created using:

MakeBundle Api-Platform EasyAdminBundle

TO RUN USING DOCKER-COMPOSE

    clone the repository in your local system
    then follow instructions below:

cd symfony_docker_compose/app copy .env.local and rename .env --> insert your mysql container User/Password/Host/Port/db_name/db_version composer update cd ../ --> to enter in symfony_docker_compose docker exec -it php74-container(or the name you decided for your php container) bash php bin/console d:s:u --force visit localhost:8080 (depending on nginx port)
