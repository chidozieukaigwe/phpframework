# Main
The core codebase (framework logic) sits in the `framework` folder. The application that consumes the framework sits in the `src` folder at the root level.

# Usage
Run `composer install` to download all composer packages. 

`cd` into the `framework` folder and run `composer install` to install all composer packages for the core codebase(framework). You should also run the same command at root level, to bring in the packages for the consuming application. 

# Docker
Install the packages via docker `docker compose exec app composer install`

You can use docker to spin up a container that will run the both applications (core framework and consuming application) with the following command:
`docker compose up -d`

To update the composer packages inside the docker container you use the following command:
`docker compose exec app composer update`.
