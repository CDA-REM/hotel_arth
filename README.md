# Hotel Arth Landing Page and Reservations
- 
## Need to setup your project on your local machine ?
  - Clone repo with ssh :
    ```
    git clone git@github.com:CDA-REM/hotel_arth.git
    ```
  - In the repo directory, run :
 ```shell
npm install
composer install
```

## Create .env file and generate application key
  - The `.env` file is missing : create it and generate a key with the following command.
    ```
    cp .env.example .env
    php artisan key:generate
    ```
    
## Database
During development, we're only using sqlite, since it doesn't change anything with Eloquent requests.

- Create database : add a new file named db.sqlite in the database folder (database/db.sqlite).

- Update .env file with database type and path :

    ```
    DB_CONNECTION=sqlite`
    DB_DATABASE=database/db.sqlite
    ```
    *If relative path doesn't work, use absolute path.* 


  - If you want to change SGBD, remember to change your database setup for production :
    ```
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    ```



- Create and load your tables:

  ```
  php artisan migrate:fresh --seed
  ```

- To seed Voyager DB tables :
    ```shell
    php artisan db:seed --class=VoyagerDatabaseSeeder
    ```
  
## Create voyager admin
Declare known admin user in Voyager

```shell
php artisan voyager:admin rem@hotel.fr
```

or create new admin user 
```shell
php artisan voyager:admin your@email.com --create
```
## Create a link to the Laravel storage : 
  ```
  php artisan storage:link
  ```
## Run local servers
- Launch in two terminals, or use you IDE run commands
  ```
  php artisan serve
  ```
  ```
  npm run watch
  ```
  
## Good to know

### API Uri's naming convention :

For this project we have decided to continue using under_score, ex: 
```
    Route::get('/home/presentation_video', [PresentationVideoController::class, 'index']);
    Route::put('/home/presentation_video', [PresentationVideoController::class, 'update']);
```

This is not a problem, but it is recommended to use the *kebab-case* syntax for readability reasons (because underscores are covered by the blue underlining of link).

### Cache problems

If certain requests suddenly seem to be blocked without (the "/me" request for example), or if the display does not update or does not conform to the code, consider clearing the caches:

**Laravel configuration/routes/vues**

```shell
php artisan config:cache
php artisan route:cache
php artisan view:clear
```

**VueJS cache**
```shell
npm run dev
```
or

```shell
npm run production
```

**Clear browser cache**

It is also advisable to clear your browser cache.

**Restart dev server**

```shell
php artisan serve
```

**Happy coding !**


