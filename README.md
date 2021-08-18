# olympic-medal-count-backend

## To run the project locally

There is a makefile to build the docker compose and other operations

### To start the containers

``` bash
make up
```

### To load the dependencies and init the  DB

These commands install all the dependencies needed, run all the migrations and data fixtures for the DB

```bash
make composer install
make migrate
make load
```
### The project URL

The project is reachable at the value inserted in the .env file, for example:
PROJECT_BASE_URL=medal.docker.localhost
will be reachable at
http://medal.docker.localhost
Api
http://medal.docker.localhost/api
traefik dashboard
http://medal.docker.localhost:8080/

### To run tests

```bash
make test
```
