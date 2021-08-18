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

### To run tests

```bash
make test
```
