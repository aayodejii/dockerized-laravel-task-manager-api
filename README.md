# Task Management API

A RESTful API for task management built with Laravel.

## Features

-   CRUD operations for tasks
-   Repository pattern implementation
-   Unit tests
-   Docker containerization
-   RESTful API design
-   Form request validation
-   Database migrations

## Requirements

-   Docker
-   Docker Compose
-   Git

## Installation

1. Clone the repository:

```bash
git clone https://github.com/aayodejii/dockerized-laravel-task-manager-api.git
cd task-management-api
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

6. Run migrations:

```bash
docker compose exec app php artisan migrate
```

7. Run tests:

```bash
docker compose exec app php artisan test
```

## API Documentation

### Endpoints

#### Get All Tasks

```
GET /api/tasks

Response 200:
{
    "data": [
        {
            "id": 1,
            "title": "Task Title",
            "description": "Task Description",
            "status": "pending",
            "due_date": "2024-02-01T00:00:00.000000Z",
            "user_id": 1,
            "created_at": "2024-01-20T00:00:00.000000Z",
            "updated_at": "2024-01-20T00:00:00.000000Z"
        }
    ]
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
    "user_id": 1
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
-   422: Validation Error
-   500: Server Error

## Testing

The API includes comprehensive unit tests covering all endpoints. Run tests using:

```bash
docker-compose exec app php artisan test
```
