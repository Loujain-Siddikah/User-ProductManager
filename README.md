## Installation
- composer install
* php artisan key:generate
+ php artisan migrate
- php artisan db:seed

## Project Features
1. User Registration and Authentication:
 - Authentication is done by laravel sanctum
 - Users can register using their email or phone number.
 - Email verification using mailtrap server: After registration, users will receive a 4-digits verification code in the case of email registration.
 - Users can change their password and reset teir password with email verification.
2. User Roles:
 - Two roles: User and Admin.
 - Admins have elevated privileges, such as managing users.
3. User Profile Management:
 - Users can view and update their information.
4. Product Management:
 - Users can create, edit, and delete their products.
 - Each product has attributes like name, description, price, and image.
5. Admin Panel:
 - Admins can access an admin panel for user management.
 - Admins can view, delete, users.
 - Admins can view products.

## API Documentation
API documentation is available on Postman:

[View Admin API Documentation on Postman](https://documenter.getpostman.com/view/23277839/2s9YRFVAJM) <br> 
[View Authentication Documentation on Postman](https://documenter.getpostman.com/view/23277839/2s9YRFWASY) <br> 
[View User Documentation on Postman](https://documenter.getpostman.com/view/23277839/2s9YRGw8mX) <br> 
[View Products Documentation on Postman](https://documenter.getpostman.com/view/23277839/2s9YRGw8mc) <br> 
