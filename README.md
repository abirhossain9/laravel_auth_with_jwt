# laravel_auth_with_jwt

Project setup:

1. Clone the repository
2. Create an env file
3. Copy env.example and paste it on .env file
4. Create an empty database in mySql
5. Update .env files DB_DATABASE, (DB_USERNAME= and DB_PASSWORD=)
6. open terminal and run this command : composer install
7. After that run this command : php artisan jwt:secret
8. Then migration by entering : php artisan migrate
9. Finally run php artisan serve

<p> <h4>challenges encountered :</h4> 
- During the development of this project i had face cors related issue and solved it by creating a custom middleware,
- For handling role permission created a middleware the takes roles as a variadic paremeter so during route creating I can say for which roles the api is accessible   <p>

<p>Making the cookie http-only wasnt possible as it would make the token inaccessible from my react-app end, which wolud make it difficult to make requestes where it would need the token</p>
