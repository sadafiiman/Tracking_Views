# Tracking Views Repository

## Overview

The **Tracking Views Repository** is a dedicated repository for interacting with Redis to track the number of views for different endpoints in a Laravel application. The repository uses Redis sorted sets to store view counts efficiently, allowing us to increment and retrieve view statistics for various routes within the application.

This repository abstracts the logic of interacting with Redis for storing and retrieving endpoint view counts, making it easy to manage the view-tracking system.

## Features

- **Incrementing View Counts**: This repository provides a method to increment the view count for any given endpoint.
- **Fetching View Reports**: It also includes a method to fetch all endpoints with their respective view counts, sorted in descending order by the number of views.
- **Redis Sorted Sets**: The view counts are stored in a Redis sorted set, where the endpoint (URL) is the **member** and the view count is the **score**.

## Redis Sorted Set Usage

- Redis **sorted sets** are ideal for this use case, as they allow for efficient score-based increments and retrievals.
- The sorted set is stored under the Redis key `view-report`, where each **endpoint** (URL) is a **member** of the sorted set, and the corresponding **view count** is the **score** of that member.

## Methods

### `incrementEndpointView(string $endpoint): void`

- **Purpose**: Increments the view count for a given endpoint by 1.
- **Parameters**:
    - `string $endpoint`: The endpoint (URL) for which the view count needs to be incremented.
- **Redis Command**: Uses `zincrby` to increment the score of the member (endpoint) by 1.

#### Example Usage:

```php
$trackingViewsRepository->incrementEndpointView('/home');
