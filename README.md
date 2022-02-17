# app.dangibbs.uk

[Laravel](https://laravel.com/) server-side application for 
[dangibbs.uk](https://dangibbs.uk/) (static site).

## Test

```bash
sail artisan test

# Alternatively
./vendor/bin/sail artisan test
```

## Build

```bash
docker build --no-cache -t gibbs/app.dangibbs.uk:0.5 .
```

## Run

```bash
docker run -it gibbs/app.dangibbs.uk:0.5

# Debug
docker exec -it $(docker ps | grep 'gibbs/app.dangibbs.uk:0.5' | awk '{ print $1 }') /bin/bash
```
