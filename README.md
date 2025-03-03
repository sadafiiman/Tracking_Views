# Tracking Views Repository

## Overview

The **Tracking Views Repository** is responsible for interacting with Redis to track and manage view counts for various application endpoints. The repository uses Redis sorted sets to store and retrieve view statistics efficiently. It abstracts the logic of storing and fetching endpoint view counts, making it easier to manage the view-tracking functionality.

## Classes Added

### 1. **TrackingViews (Middleware)**

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

This structure ensures that the tracking system is efficient, scalable, and easy to manage by centralizing Redis interactions within a dedicated repository and keeping the middleware's logic simple and focused on handling the view incrementing functionality.
