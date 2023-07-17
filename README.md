# Installation

Clone the project repo or download as zip

Run this command

```bash
composer install
```
Create .env file in the project root folder and copy all the content from .env.example and then paste in the created .env.And then generate the application key with the following command.

```bash
php artisan key:generate
```

Fill with your local database instance username and password and local database name in .env file in the project root folder

```bash
DB_DATABASE="dbname"
DB_USERNAME="username"
DB_PASSWORD="password"
```


    
Then, run the migration command to generate the tables and the test data

```bash
php artisan migrate --seed
```

Now, open command prompt and locate to the project root folder,run this command

```bash
php artisan serve
```

```bash
npm install && npm run dev
```
