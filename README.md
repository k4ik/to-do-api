# To Do API

A simple API for managing tasks, developed with PHP, MySQL and Docker. This API allows you to create, read, update, and delete tasks.

## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/)

## Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/k4ik/to-do-api.git
    cd to-do-api
    ```

2. **Set up environment variables:**

   ```bash
    cp .env.example .env
    ```
3. **Start the application:**
    ```bash
    docker compose up --build
    ```

## Endpoints

The API offers the following endpoints:

### 1. List Tasks

- Method: GET
-  URL: ``http://localhost:8080/tasks``

### 2. Create Task

- **Method:** POST
- **URL:** `http://localhost:8080/tasks`
- **Body:** JSON representing the task structure
  - **Example:** 
    ```json
    {
      "title": "New task",
      "completed": 0
    }
    ```
  - **Note:** Use `0` for **false** and `1` for **true** .to indicate the completion status of the task.

### 3. Update Task

- **Method:** PUT
- **URL:** `http://localhost:8080/tasks/:id`
- **Body:** JSON representing the task structure
  - **Example:** 
    ```json
    {
      "title": "Updated task",
      "completed": 1
    }
    ```
  - **Note:** Use `0` for **false** and `1` for **true** to indicate the completion status of the task.

### 4. Delete Task
- Method: DELETE
- URL: ``http://localhost:8080/tasks/:id``

## Contribution

Contributions are welcome! Feel free to submit a pull request or open an issue.