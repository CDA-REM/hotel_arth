- Need to setup your project on your local machine ?
  - Clone repo with ssh :
    ```
    git clone git@github.com:Michelle-al/hotel_arth.git
    ```
  - In the repo directory, run `npm install` and `composer install` ;
  - The `.env` file is missing : create it and generate a key with the following command.
    ```
    cp .env.example .env
    php artisan key:generate
    ```
  - During development, we're only using sqlite, since it doesn't change anything with Eloquent requests.
    ```
    DB_CONNECTION=sqlite`
    DB_DATABASE=database/db.sqlite
    ```
    *If relative path doesn't work, use absolute path.* 

  - Remember to change your database setup for production:
    ```
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    ```
- Create database

- Create and load your tables:

  ```
  php artisan migrate:fresh --seed
  ```
- To create a link to the Laravel storage : 
  ```
  php artisan storage:link
  ```
- In order to run the site, launch in two terminals
  ```
  php artisan serve
  ```
  ```
  npm run watch
  ```  
- API Uri's naming convention :
  - For this project we have decided to continue using under_score, ex: 
  ```
    Route::get('/home/presentation_video', [PresentationVideoController::class, 'index']);
    Route::put('/home/presentation_video', [PresentationVideoController::class, 'update']);
    ```
  - This is not a problem, but it is recommended to use the kebab-case for readability reasons (because underscores 
    are covered by the blue underlining of link).
  
**Happy coding !**


