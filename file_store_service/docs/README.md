# File Store Service Documentation

Welcome to the documentation for the **File Store Service**. This documentation provides information on setting up, configuring, and using the features of the File Store Service, a web application for storing and managing files.

## Table of Contents

1. [Introduction](#1-introduction)
2. [Getting Started](#2-getting-started)
    - [Clone the Repository](#21-clone-the-repository)
    - [Environment Setup](#22-environment-setup)
    - [Install Dependencies](#23-install-dependencies)
    - [Database Setup](#24-database-setup)
    - [Run Migrations](#25-run-migrations)
    - [Build Frontend](#26-build-frontend)
    - [Start the Server](#27-start-the-server)
3. [Usage](#3-usage)
    - [List Page](#31-list-page)
    - [Create and Edit Page](#32-create-and-edit-page)
4. [Project Structure](#4-project-structure)
5. [Documentation Structure](#5-documentation-structure)
6. [Contributing](#6-contributing)
7. [License](#7-license)

## 1. Introduction

The File Store Service is a web application developed using Laravel for the backend, Vue3 for the frontend, and MySQL or PostgreSQL as the database. It allows users to store and manage files, providing features such as file listing, pagination, search, and CRUD operations.

## 2. Getting Started

Follow these steps to set up and run the File Store Service on your local environment.

### 2.1. Clone the Repository

Clone the repository to your local machine using the following command:

```bash
git clone <repository-url>
```

### 2.2. Environment Setup

Copy the `.env.example` file to `.env` and update the database and other relevant configurations.

```bash
cp .env.example .env
```

### 2.3. Install Dependencies

Install backend and frontend dependencies using Composer and npm:

```bash
composer install
npm install
```

### 2.4. Database Setup

Create a new database and update the database configurations in the `.env` file.

### 2.5. Run Migrations

Run database migrations to create tables:

```bash
php artisan migrate
```

### 2.6. Build Frontend

Build the frontend assets using npm:

```bash
npm run dev
```

### 2.7. Start the Server

Start the Laravel development server:

```bash
php artisan serve
```

Visit `http://localhost` in your browser to access the application.

## 3. Usage

### 3.1. List Page

The List Page displays files in a tabular format with pagination. Users can perform the following actions:

- View file details including name, size, extension, and a preview for images.
- Download the original file.
- Search for files by name.
- Navigate between pages.
- Edit and delete files.

### 3.2. Create and Edit Page

The Create and Edit Page allows users to add or update files. Features include:

- Optional "File Name" field.
- File upload with drag-and-drop functionality.
- Save and Delete buttons with confirmation modals.
- Validation for a maximum file size of 8 megabytes.
- Progress bar indicating file upload status.

## 4. Project Structure

The project structure follows a standard Laravel application layout with additional directories for frontend and documentation:

```plaintext
/laravel_project
|-- /app
|-- /config
|-- /database
|-- /docs                    # Documentation Folder
|-- /frontend                # Vue3 Frontend
|-- /public
|-- /resources
|-- /routes
|-- /tests
|-- /vendor
|-- /...
|-- .env
|-- .gitignore
|-- artisan
|-- composer.json
|-- ...
```

## 5. Documentation Structure

The documentation is organized into sections, each providing information on a specific aspect of the project:

- Introduction
- Getting Started
- Usage
- Project Structure
- Documentation Structure
- Contributing
- License

## 6. Contributing

Contributions to the File Store Service are welcome. Refer to the [Contributing Guidelines](CONTRIBUTING.md) for details on how to contribute.

## 7. License

The File Store Service is open-source software released under the [MIT License](LICENSE). See the [License](LICENSE) file for more details.