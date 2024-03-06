## Prerequisites
- PHP >= 8.1
- Composer
- Mailtrap account for testing emails

## Installation
1. **git clone** https://github.com/https://github.com/Loujain-Siddikah/User-ProductManager.git
2. Copy .env.example file to .env and edit database credentials there
3. Install the project dependencies by run **composer install**
4. **cp .env.example .env**
5. update the necessary database configuration and other environment variables in the .env file.
6. Configure Mailtrap in your `.env` file for testing email functionality.
8. Run **php artisan key:generate**
9. Run **php artisan migrate**
10. Run **php artisan serve**

## Project Features
### Repository Design Pattern 
 A repository design pattern is used that separates data access logic from controllers, thus improving code organization, maintainability and scalability.

### Authentication 
- Authentication is done by laravel sanctum.
    #### Registeration
    - register a new user, user cannot access the application until the account is verified.
    #### Verification
    - Users must verify their email addresses before accessing the application.
    - The verification email is sent using Laravel's built-in mail service.
       When a user registers, an event is triggered, and a listener handles sending the verification email to the user.
       The verification code is included in the email.

    #### login
    - Authenticate a user, upon successful login, the API will return an authentication token.
    #### Forgot Password
    - If a user forgets their password, he can request a password reset link by input his email address.
      The user will receive an email with a password reset link.
    #### Reset Password
    - User submits the new password along with the token received in the email.
      
### Request Validation
In this API, I utilize Laravel's built-in validation features to ensure that incoming data meets the specified criteria before processing it. This helps maintain data integrity and security within the application.

### Eloquent API Resources with Pagination
This API utilizes Laravel's Eloquent API Resource for transforming model data into JSON responses, and customize the data returned by API endpoints.
I use Eloquent API resources along with pagination To handle large data sets and improve API performance,So i paginate product response using Laravel's built-in pagination feature. This breaks down the data into smaller, more manageable chunks, making it easier for clients to consume and navigate through the results, and the server doesn't get too occupied with requests.

### Authorization
This API implements authorization using policies and roles, leveraging Spatie's Laravel Permissions package.
I use Laravel's policy system to define authorization logic for individual models or actions. Policies contain methods that determine whether a user is authorized to perform a specific action, such as creating, updating, or deleting a resource.
I use role-based authorization to grant access to certain features or functionalities based on the user's role.

### User Features
User can updating his profile, managing his products (create,update, delete,get), view other users products, show all products in application.

### Admin Features
Admin can manage users(delete, add users with a specific role) and manage products(update, delete).

### Factories and Seeders for Test Data
To facilitate testing and development, this project uses Laravel's factory and seeder functionality to generate fake data.

## Testing with Postman
You can test this project by using Postman. Follow these steps:
1. Download and install Postman from the Postman website.
2. Import the Postman collection by clicking on the "Import" button in Postman and selecting the User-ProductManager/postman_collection/UsersProductsManagementApi.postman_collection.json.
3. Once imported, you will see the collection and its requests in the left sidebar.
4. Configure any necessary environment variables within Postman if required for authentication tokens, base URLs, or other configuration values.
5. Start testing the project by sending requests using the imported collection.

## API documentation
You can look at the API documentation if you don't want to test the API (https://documenter.getpostman.com/view/23277839/2sA2xccFsW)


## ER diagram 
The project's database structure is represented using an Entity-Relationship (ER) diagram. This diagram visually depicts the entities, relationships between them, and attributes of each entity. It provides a comprehensive overview of the database schema, making it easier to understand the data model and relationships within our application. A PDF file containing the diagram has been provided in the User-ProductManager/ER_diagram/user_product_manager_erd.pdf directory.
