Vertical Direct Chill

Installation
Explain how to set up and install your Laravel project locally. Include any dependencies or prerequisites that users need to install. You can use code blocks to provide command-line instructions.

```bash
# Clone the repository
git clone https://github.com/shalexandeer/Vertical-Direct-Chill.git

# Navigate to the project directory
cd Vertical-Direct-Chill

# Install dependencies
composer install

# Create a copy of the .env file
cp .env.example .env

# open xampp or mysql workbench
1. create database
2. fill the connection needed, makse sure the connection to database is success

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

#install npm
npm install

# Start the development server
php artisan serve

# Start vite bundling
npm run dev

#now you can use the app
username : admin@gmail.com
password : aaa
```
