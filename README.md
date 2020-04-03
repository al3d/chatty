# Chatty - Team chat app as code test for Signable

## Overview
The backend is written in PHP/Laravel framework, the frontend in Nuxt/Vue/JS. The dev environment is built on Docker.

Some additional helper files have been written in the `/bin` directory,
and for brevity, the instructions will be based on those helpers.

## Installation
1. Download [Docker](https://www.docker.com/products/docker-desktop) and make sure you 
   have [Yarn](https://yarnpkg.com/) installed.  
2. Run `./bin/setup-nfs` (you might be prompted for your password.)
3. Run `./bin/up` - this runs the docker environment. The first time, it'll take a 
   while because it downloads and builds the containers.
4. Run `./bin/composer install`
5. Run `./bin/artisan migrate`
6. Run `./bin/artisan db:seed`
7. `cd` into the `nuxt/` folder
8. Run `yarn && yarn dev`
9. Visit `http://localhost:3000`

## Notes
- Emails are sent to a local server, and a web ui can be accessed at `http://localhost:8025`
