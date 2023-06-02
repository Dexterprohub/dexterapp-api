# Dexterpro API

This repository contains the source code for dexterpro api.

## Basic Setup Guide
1. Ensure that you have [Docker](https://docs.docker.com/get-docker/) installed on your computer. This setup makes use of [Laravel Sail](https://laravel.com/docs/sail).

2. Clone the repository by running the following command:
    ```bash
    git clone git@github.com:Dexterprohub/dexterapp-api.git
    ```

3. Change into the project directory..:
    ```bash
    cd dexterapp-api
    ```
   
4. Create a new .env file by copying the contents of the .env.example file:
    ```bash
    cp .env.example .env
    ```
   
5. Install all necessary PHP and NodeJs dependencies by running the following command:
    ```bash 
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs && yarn install
    ```
   
6. Start the application by running the following command:
    ```bash
    ./vendor/bin/sail up
    ```
   
7. The application should now be running in a Docker container and can be accessed in your web browser at http://localhost

8. To start the application in detached mode, you can run the following command:
    ```bash
     ./vendor/bin/sail up -d
    ```
   
9. To stop the application, you can run the following command:
     ```bash
     ./vendor/bin/sail down
    ```
   
10. To configure a bash alias that allows you to execute sail command easily. You can
create a bash alias on both  [Linux](https://linuxize.com/post/how-to-create-bash-aliases/)
and [Windows](https://dev.to/mhjaafar/git-bash-on-windows-adding-a-permanent-alias-198g) operating system.
    ```bash
    alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
    ```
     
11. Once the bash alias has been configured, you may execute Sail commands by simply typing sail. For example
    ```bash
    # To start the application 
    sail up
    
    # To start the application in detached mode
    sail up -d
    
    # To stop the application
    sail down
    ```

12. You can preview emails in your browser via MailHog web interface at: http://localhost:8025

13. To share your application publicly, you can use the following command:
    ```bash
    sail share
    ```
    
14. To run tests for the application you can use this command:
     ```bash
    sail test
    ```    

## Executing commands
1. `Artisan Commands` - Laravel Artisan commands may be executed using the artisan command.
    ```bash
    sail artisan queue:work
    ```
   
2. `PHP Commands` - PHP commands may be executed using the php command.
    ```bash
    sail php --version

    sail php script.php
    ```
   
3. `Composer Commands` - Composer commands may be executed using the composer command.
    ```bash
    sail composer require laravel/sanctum
    ```
   
4. `Node / NPM Commands` - Node commands may be executed using the node command while NPM commands may be executed using the npm command:
    ```bash
    sail node --version

    sail npm run dev
   
    # To execute npm commands using yarn
    sail yarn dev
    ```