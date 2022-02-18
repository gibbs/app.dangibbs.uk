# app.dangibbs.uk

[![Test](https://github.com/gibbs/app.dangibbs.uk/actions/workflows/test.yml/badge.svg)](https://github.com/gibbs/app.dangibbs.uk/actions/workflows/test.yml)

[Laravel](https://laravel.com/) server-side application for 
[dangibbs.uk](https://dangibbs.uk/) (static site).

## Development

```bash
# Add to hosts file
echo "127.0.0.1  app.dangibbs.test" | sudo tee -a /etc/hosts >/dev/null

# Install packages
composer install

# Run container via sail
sail up -d
```

## Test

```bash
sail artisan test
```

## Image

```bash
export DOCKER_BUILD_NAME="gibbs/app.dangibbs.uk"
export DOCKER_BUILD_TAG="0.5"
```

### Build

```bash
docker build --no-cache -t ${DOCKER_BUILD_NAME}:${DOCKER_BUILD_TAG} -t ${DOCKER_BUILD_NAME}:latest .
```

### Run

```bash
docker run -it ${DOCKER_BUILD_NAME}:${DOCKER_BUILD_TAG}
```

### Debug

```bash
docker exec -it $(docker ps | grep '${DOCKER_BUILD_NAME}:${DOCKER_BUILD_TAG}' | awk '{ print $1 }') /bin/bash
```
