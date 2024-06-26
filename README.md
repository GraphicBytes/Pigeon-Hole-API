# CLOUD PIGEON HOLE API #

**VERSION**
1.0.0 alpha

**AUTHORS**

  - Darren Morley

**CONTRIBUTING DEVELOPERS**

  - n/a

## ABOUT

Pigeon Hole is a REST-ful API/Microservice.

Pigeon Hole is responsible for handling the following areas of functionality

- Email template management
- Email queue handling
- SMTP Account Management
- SMTP email sending

Pigeon hole attempts to handle email queue handling in a way that offers responsive email receipt, while remaining withing fair-use limits set by SMTP providers.

## DEPLOYMENT

This API is launched via Docker containerization using a `docker-compose.yml` file. Environment files are used to separate deployment environments. The main ENV files and CLI commands are:

*note: Please use the "tools.sh" shell script instead of these commands, see below*

`docker-compose --env-file ./env/dev.env up`

`docker-compose --env-file ./env/stage.env up`

`docker-compose --env-file ./env/production.env up`

## TOOLS SCRIPT

**This repo contains a shell script to help manage this repo and docker container**

`sh tools.sh`

This shell script will give you 12 options

`1. Cancel/Close`

`2. Pull changes`

This option will pull the latest updates for the current git branch

`3. Start/Reboot docker container with dev.env`

This will boot up the API in development mode for beta testing

`4. Start/Reboot docker container with stage.env`

This will boot up the API in staging mode for alpha testing

`5. Start/Reboot docker container with production.env`

This will boot up the API in production mode

`6. View console log output`

This will show the live docker logs output, useful for debugging but are disabled in production mode.

`7. Git push changes to current branch`

This will push changes to the current branch while also offering an option to leave comment.

`8. Git merge Main to Staging`

This will merge the current Main branch into Staging when ready for Alpha testing

`9. Git merge Staging to Production`

This will merge the current Staging branch into Production

`10. Checkout Main branch`

This will switch to the Main branch

`11. Checkout Staging branch`

This will switch to the Staging branch

`12. Checkout Production branch`

This will switch to the Production branch

## MAIN REPO BRANCHES

This API follows a development -> staging -> production flow focused on the following git repo branches

**Main**

Latest beta testing build *(All development work should be done on this branch, or forked and re-merged with this branch before moving onto staging.)* 

**Staging**

Latest alpha testing build

**Production**

Latest production build

## DOCKER STACK

`PHP/APACHE FROM php:8.3.4-apache`

`MariaDB FROM mariadb:11.2.3-jammy`

`MyPHPAdmin FROM phpmyadmin:latest`

## SCALE EXPECTATIONS

**OPTIMAL PERFORMANCE**

Even under heavy load this API will be ok on shared hosting with the following minimum requirements:

- 4 CPU THREADS
- 4 GB RAM
- 250 GB SSD-SPEED STORAGE

## Change Log

### v1.0.0
- Launch with core functionality for core user functions, auth, login, session management as to original spec agreed.