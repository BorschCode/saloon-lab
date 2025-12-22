# Nexus API Lab 🚀

A dedicated project for mastering **Saloon PHP v3** in Laravel. This repository demonstrates how to transform messy API integrations into clean, maintainable, and testable code.



## 🎯 Learning Objectives

- **Encapsulation**: Moving API logic from Services to Connectors and Requests.
- **Data Integrity**: Implementing Data Transfer Objects (DTOs) for type-safe responses.
- **Resilience**: Using Saloon's built-in Retry and Exception handling plugins.
- **Efficiency**: Implementing request caching and pagination.

## 🛠 Project Structure

```text
app/Http/Integrations/
├── JSONPlaceholder/           # Basic GET/POST exercises
│   ├── Requests/
│   │   ├── GetPostRequest.php
│   │   └── CreatePostRequest.php
│   └── JSONPlaceholderConnector.php
├── WeatherAPI/                # Query parameters & API Key auth
│   └── WeatherConnector.php
└── Messaging/                 # Advanced Body & Header management
    └── WhatsAppConnector.php

```

## 🧪 Implementation Roadmap

### Level 1: The Basics (JSONPlaceholder)

* Create a `Connector` for `https://jsonplaceholder.typicode.com`.
* Create a `GetPostRequest(int $id)` and handle the response.
* Use `AlwaysThrowOnErrors` trait to manage API failures.

### Level 2: DTOs & Typing

* Refactor the `GetPostRequest` to return a `PostDTO` instead of a raw array.
* Implement the `createDtoFromResponse` method.

### Level 3: Authentication & Payloads

* Implement `WhatsAppConnector` using `TokenAuthenticator`.
* Create a `SendMessageRequest` using the `HasBody` trait.
* Organize endpoints into **Request Collections** (e.g., `$connector->messages()->send()`).

## 🚀 Getting Started

1. **Install Dependencies**
```bash
composer require sammyjo20/saloon

```


2. **Run a Request**
```php
$connector = new JSONPlaceholderConnector();
$response = $connector->send(new GetPostRequest(1));

dump($response->dto());

```



## 📚 Key Saloon Traits to Explore

* `AcceptsJson`: Automatically adds the `Accept: application/json` header.
* `AlwaysThrowOnErrors`: Converts 4xx/5xx responses into PHP Exceptions.
* `HasDebugging`: Easily log your outgoing requests to the console.
