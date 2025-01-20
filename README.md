# Task Management API

A RESTful API for task management built with Laravel.
Note: Users can retrieve, update and delete ONLY their own tasks.

## Features

-   CRUD operations for tasks
-   Repository pattern implementation
-   Unit tests
-   Docker containerization
-   RESTful API design
-   User authentication
-   Request validation
-   Database migrations

## Requirements

-   Docker
-   Docker Compose
-   Git

## Installation

1. Clone the repository:

```bash
git clone https://github.com/aayodejii/dockerized-laravel-task-manager-api.git
cd dockerized-laravel-task-manager-api
```

2. Copy the environment file:

```bash
cp .env.example .env
```

3. Build and run the Docker containers:

```bash
docker compose up -d
```

4. Install dependencies:

```bash
docker compose exec app composer install
```

5. Generate application key:

```bash
docker compose exec app php artisan key:generate
```

6. Run this fo fix a common permission issue

```bash
docker compose exec app chmod -R 777 storage bootstrap/cache
```

7. Run migrations:

```bash
docker compose exec app php artisan migrate
```

8. Run tests:

```bash
docker compose exec app php artisan test
```

## API Documentation

### Endpoints

#### Create a User

```
POST /api/register

Request Body:
{
    "name": "Test User",
    "email": "test4@mail.com",
    "password": "securepassword",
    "password_confirmation": "securepassword"
}

Response 201:
{
    "user": {
        "name": "Test User",
        "email": "test4@mail.com",
        "updated_at": "2025-01-20T18:53:05.000000Z",
        "created_at": "2025-01-20T18:53:05.000000Z",
        "id": 15
    },
    "token": "1|7heZOcaG8KUv5xEwaJn4hnX1qWDBWJjYDzt3H9znd3beee89"
}
```

#### Login a User

```
POST /api/login

Request Body:
{
    "email": "test4@mail.com",
    "password": "securepassword",
}

Response 200:
{
    "user": {
        "id": 15,
        "name": "Test User",
        "email": "test4@mail.com",
        "email_verified_at": null,
        "created_at": "2025-01-20T18:53:05.000000Z",
        "updated_at": "2025-01-20T18:53:05.000000Z"
    },
    "token": "2|PyeyFlPAlDeGZHpqIUf0Ubwhl9Z2KNh2OkyER10S479ebbe7"
}
```

#### Get All Tasks

```
GET /api/tasks

Response 200:
{
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 4,
                "title": "Updated Task",
                "description": "Task Description",
                "status": "completed",
                "due_date": "2024-02-01T00:00:00.000000Z",
                "user_id": 2,
                "created_at": "2025-01-20T16:57:06.000000Z",
                "updated_at": "2025-01-20T17:25:05.000000Z",
                "user": {
                    "id": 2,
                    "name": "Test User",
                    "email": "test1@mail.com",
                    "email_verified_at": null,
                    "created_at": "2025-01-20T15:01:22.000000Z",
                    "updated_at": "2025-01-20T15:01:22.000000Z"
                }
            },
          ...
        ],
        "first_page_url": "http://localhost:8000/api/tasks?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/tasks?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/tasks?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8000/api/tasks",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}


```

#### Create Task

```
POST /api/tasks

Request Body:
{
    "title": "New Task",
    "description": "Task Description",
    "status": "pending",
    "due_date": "2024-02-01",
}

Response 201:
{
    "message": "Task created successfully",
    "data": {
        "id": 1,
        "title": "New Task",
        ...
    }
}
```

#### Get Single Task

```
GET /api/tasks/{id}

Response 200:
{
    "data": {
        "id": 1,
        "title": "Task Title",
        ...
    }
}
```

#### Update Task

```
PUT /api/tasks/{id}

Request Body:
{
    "title": "Updated Task",
    "status": "completed",
    "user_id": 1
}

Response 200:
{
    "message": "Task updated successfully",
    "data": {
        "id": 1,
        "title": "Updated Task",
        ...
    }
}
```

#### Delete Task

```
DELETE /api/tasks/{id}

Response 200:
{
    "message": "Task deleted successfully"
}
```

## Error Handling

The API returns appropriate HTTP status codes:

-   200: Success
-   201: Created
-   400: Bad Request
-   404: Not Found
-   422: 422 Unprocessable Entity/Validation Error
-   500: Server Error

## Testing

The API includes comprehensive unit tests covering all endpoints. Run tests using:

```bash
docker-compose exec app php artisan test
```
