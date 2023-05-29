## Assessment Overview

### Objective
This assessment aims to evaluate your back-end development expertise. You're expected to build a simplified application that allows users to manage shortened URLs. Preferred tech stack includes Laravel or plain PHP. Comprehensive documentation using Docblocks is a requirement for all functionalities.

### Core Features

1. User Registration and Authentication: Users should be able to register and log into the application.
2. Shortened URLs Dashboard: A view should be available to display all the shortened URLs created by a user.
3. CRUD Operations for Shortened URLs: Users must be able to create, edit, and delete shortened URLs.
4. URL Redirection: The system should correctly redirect from the shortened URL to the original target URL.

### Deliverables
- A functional application embodying all of the features mentioned above.
- Detailed instructions on how to run your application.
- Documentation or Docblocks outlining your coding practices and decisions.

### Styling Guidelines
- While styling is optional, incorporating it can potentially earn you extra points.
- You may use styling frameworks, with Laravel Breeze being a recommended option.
- Ensure that all your code compiles without errors.

### Tips
- Consider using Laravel Valet and MySQL for your application.
- MAMP or similar interfaces can be used to manage your database.

### Bonus Objectives
- API CRUD endpoint
- Seeder for URLs and users

## Implementation

In this project, the tools employed include Laravel, Vue, Laravel Breeze for authentication, Laravel Sanctum for API authentication, Laravel Pest for testing, Laravel Valet for local development, and Laravel Pint for Code Style,  MySQL for database management, Docker for application deployment, and Tailwind CSS for styling, and CI/CD with GitHub Actions.

During development, Test-Driven Development (TDD), Domain-Driven Design (DDD), and SOLID principles were followed. To enhance the shortened URL forwarding process, caching was utilized, with Redis serving as the cache resource in Docker-based deployments.

## Setup Instructions

### Prerequisites
- PHP 8.1
- Composer
- MySQL

### Local Environment Setup
#### Step 1: Clone the Repository
```bash
git clone git@github.com:koushamad/Global-Tickets.git
cd Global-Tickets
cp .env.example .env
```
#### Step 2: Set Up Database Credentials
Modify the `.env` file to include your database credentials.

#### Step 3: Install Dependencies and Run Migrations
```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan test
```
#### Step 4: Install npm Dependencies
```bash
npm install
npm build
```

#### Step 5: Start the Server
```bash
valet install
valet links
```

### Docker Setup
#### Step 1: Clone the Repository
```bash
git clone git@github.com:koushamad/Global-Tickets.git
cd Global-Tickets
cp .env.docker .env
```
#### Step 2: Launch Docker
```bash
docker-compose up -d
```
#### Step 3: Wait for Docker to Complete All Tests
![Screenshot 2023-05-29 at 12 47 43 PM](https://github.com/koushamad/Global-Tickets/assets/20081351/3a69ef34-c38f-4cb1-b6ea-2e5c9b3513a1)


## API Documentation

The API uses Laravel Sanctum for authentication. Below is the list of API routes:

- **Base URL**: `/api`

### User Routes

- **Get User Details**

  **Endpoint:** `GET /user`

  **Required Authentication:** Yes

  **Description:** Returns details of the authenticated user.

  **Route Name:** `api.user`

### Short-Link Routes

These routes provide CRUD operations for short-links.

- **Get All Short Links**

  **Endpoint:** `GET /short-links`

  **Required Authentication:** Yes

  **Description:** Retrieves a list of all short-links created by the authenticated user.

  **Route Name:** `api.short-links.index`

- **Get Specific Short Link**

  **Endpoint:** `GET /short-links/{id}`

  **Required Authentication:** Yes

  **Description:** Retrieves details of a specific short link created by the authenticated user.

  **Route Name:** `api.short-links.show`

- **Create Short Link**

  **Endpoint:** `POST /short-links`

  **Required Authentication:** Yes

  **Description:** Creates a new short-link.

  **Route Name:** `api.short-links.store`

- **Update Short Link**

  **Endpoint:** `PUT /short-links/{id}`

  **Required Authentication:** Yes

  **Description:** Updates a specific short-link.

  **Route Name:** `api.short-links.update`

- **Delete Short Link**

  **Endpoint:** `DELETE /short-links/{id}`

  **Required Authentication:** Yes

  **Description:** Deletes a specific short-link.

  **Route Name:** `api.short-links.destroy`

These routes should be prefixed with the base URL to form complete endpoints. For instance, to get the user details,


 the full URL will be `/api/user`.


## Frontend Demo
https://github.com/koushamad/Global-Tickets/assets/20081351/c432b671-de84-473c-be5d-bcf00dd3e3f8

