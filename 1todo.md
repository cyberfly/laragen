
use this to get back the hashed password

if (Hash::check('secret', $hashedPassword))
{
    // The passwords match...
}

on second thoughts,

use laravel encryption on db password
https://laravel.com/docs/5.4/encryption

User need to add setting in order to use the database
- create pages for user to add, edit setting
- create dashboard for user to see all the settings that user add aside for their db settings management

Modify the formbuilder
- delete the db form
- use dropdown to select preload from the user settings

http://fideloper.com/laravel-multiple-database-connections

https://laravel.com/docs/5.1/encryption
