# 📊 Tracking Views System

A lightweight Redis-based analytics system built with Laravel to track and report endpoint usage using Redis Sorted Sets.

---

## 🚀 Overview

This project implements a high-performance view tracking system that automatically records and aggregates endpoint visits in real-time.

It uses:

- Laravel Middleware for automatic tracking
- Redis Sorted Sets for efficient counters and ranking
- Repository pattern for clean data access

Each request is tracked as:
- endpoint → view count (score)


stored in Redis under a sorted set.

---

## 🧱 Architecture

HTTP Request
↓
TrackingViews Middleware
↓
TrackingViewsRepository
↓
Redis Sorted Set (view-report)

---


---

## ⚡ Features

- Automatic endpoint tracking via middleware
- Real-time view counting
- Redis Sorted Set for ranking
- Clean repository abstraction
- JSON reporting endpoint
- Lightweight and scalable design

---

## 🐳 Running the Application

### 1. Start with Docker

```bash
docker compose up --build
```

### 🌐 Available Routes

| Route          | Description           |
| -------------- | --------------------- |
| `/`            | Home page             |
| `/report`      | View analytics report |
| `/hello-world` | Test endpoint         |


---

## 📦 Core Components

1. Middleware: TrackingViews

- Automatically tracks every incoming request.

- Responsibilities :

Extract endpoint from request
Increment view count
Send data to repository

- Flow:

Request → Middleware → Repository → Redis

2. Repository: TrackingViewsRepository

- Handles Redis operations.

-Responsibilities:

- Increment endpoint views
- Fetch ranked reports
- Redis Structure
- Key: view-report

- member = endpoint (/home)
- score  = view count
- Redis Commands Used
- ZINCRBY → increment view count
- ZREVRANGE → fetch ranked data

---

## 📊 Report Endpoint

- Returns ranked endpoint statistics:

```bash
[
{
"endpoint": "/home",
"views": 120
},
{
"endpoint": "/report",
"views": 45
}
]
```
---
## ⚙️ Design Principles

- Separation of concerns
- Middleware-based tracking
- Repository abstraction
- Infrastructure isolation
- High-performance Redis usage

---

## 🚀 Future Improvements

- Time-based analytics (hourly/daily)
- Queue-based tracking (async)
- User/IP tracking
- Rate limiting system
- Admin dashboard (Filament/Vue)
- Distributed Redis scaling


---

## 🧠 Summary

### A lightweight analytics system demonstrating:

- Real-time tracking
- Redis sorted set usage
- Clean Laravel architecture
- Scalable design patterns
