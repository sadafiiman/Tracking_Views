# Tracking Views Repository

## Overview

The **Tracking Views Repository** is responsible for interacting with Redis to track and manage view counts for various application endpoints. The repository uses Redis sorted sets to store and retrieve view statistics efficiently. It abstracts the logic of storing and fetching endpoint view counts, making it easier to manage the view-tracking functionality.

## Running the Application

To get the application running locally, you can use the provided `run.sh` script. This script will handle the setup and ensure the application is ready to serve on `localhost:8000`.

1. **Run the `run.sh` Script**:
   To start the application and wait for it to be ready, run the following command in your terminal:

   [**Run the Application**](./run.sh)

   The script will:
    - IMPORTANT: Set up DNS configurations if needed for Docker.
    - Build and start the Docker containers.
    - Wait for the application to be ready on `localhost:8000`.

---

## Available Routes

Here are the available routes in the application. You can click on them to open in a new tab:

- [**Home**](http://localhost:8000/) : Displays the homepage
- [**Report**](http://localhost:8000/report) : Displays the view report
- [**Hello World**](http://localhost:8000/hello-world) : Displays a simple "Hello World" message.

These routes will trigger specific actions in the application, such as displaying the homepage, generating a view report, and showing a simple "Hello World" message.

---

## Classes Added

### 1. **TrackingViews (Global Middleware)**

This middleware is responsible for tracking the views for each incoming request. It uses the `TrackingViewsRepository` to increment the view count for the endpoint being accessed. The middleware is globally applied to all routes.

- **Purpose**: Track views for each endpoint on every request.
- **Flow**:
    - Extracts the endpoint from the request path.
    - Calls `incrementEndpointView` method from `TrackingViewsRepository` to increment the view count for the given endpoint.

### 2. **TrackingViewsRepository (Repository)**

The `TrackingViewsRepository` class interacts directly with Redis to manage view counts. It provides methods for incrementing the view count of an endpoint and fetching the view reports for all endpoints.

- **Purpose**: Encapsulate the Redis logic for managing endpoint views.
- **Methods**:
    - **incrementEndpointView(string $endpoint): void**: Increments the view count for the provided endpoint using Redis' `zincrby` command.
    - **getAllViewsReport(): array**: Fetches all endpoint view counts from the Redis sorted set `view-report`, ordered by the view count in descending order.

## Flow of Operations

1. **Tracking Views Middleware**:
    - When a request hits the Laravel application, the `TrackingViews` middleware is triggered.
    - The middleware extracts the endpoint from the URL and calls `incrementEndpointView` method in the repository to increment the view count by 1.

2. **TrackingViewsRepository**:
    - The `TrackingViewsRepository` handles the Redis interaction. It stores view counts in a Redis sorted set named `view-report`, where:
        - Each endpoint is a **member**.
        - The view count is the **score**.
    - It uses the Redis command `zincrby` to increment the score of an endpoint, and `zrevrange` to fetch all endpoints sorted by view count.

3. **Fetching Reports**:
    - The `getAllViewsReport` method in the repository can be used to fetch all endpoints along with their respective view counts.
    - The `report` method in the controller returns a JSON response containing the sorted list of endpoints with view counts.

### Redis Sorted Set Usage

- **Sorted Sets** in Redis are used to efficiently store the endpoints and their view counts.
- Redis allows for fast increments (`zincrby`) and retrieving sorted data (`zrevrange`), making it ideal for this use case.

The data is stored under the key `view-report`, where the **member** is the endpoint (URL), and the **score** is the view count for that endpoint.

---
