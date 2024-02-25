## Installation
    1. Clone the repository with git clone
    2. Copy .env.example file to .env and edit database credentials there
    3. Run composer install
    4. Run php artisan key:generate
    5. Run php artisan migrate

## Project Features
    * Repository design pattern was used to enhance code organization andmaintainability.
    + Response data is transformed and returned using Eloquent resources.
    * Authentication is done by laravel sanctum (verification code afterregister, reset password with email verification).
    * Implemented two user roles (admin, user) using spatie laravel package.
    + User Features: updating his profile, managing his products (create,update, delete), view other users products, products will be displayedwith pagination.Admins can manage users             (delete, add users with a specific role).
    
