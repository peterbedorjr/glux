# Glux

A real time chat application using Laravel, Vue, and web sockets.

### Set up

#### Locally
- `npm install` - Install node modules
- `composr install` - Install composer packages
- `php artisan key:generate` - Generate application key
- `php artisan jwt:secret` - Generate JWT secret token

#### Hive
SSH into hive and run the following commands
You might have to update node and npm in hive, I would suggest using NVM, installation can be found [here](https://github.com/nvm-sh/nvm#install--update-script)
Use at least node version 8

- `npm run echo:init` - Initialize laravel-echo-server settings.
    - You'll need to know where the location of your certificates are, if you're using hive they'll be in the `/opt/hive/etc/ssl` directory, you'll need the crt and key file
- `php artisan migrate` - Migrate database tables
- `php artisan db:seed` - Seed with test data
- `npm run echo:start` - Start the laravel echo server
