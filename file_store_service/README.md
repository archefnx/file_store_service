# File Store Service

This project is a file storage service implemented using Laravel for the backend, Vue3 (Composition API) for the frontend, and MySQL or PostgreSQL as the database.

## Stack

### Backend (Laravel)
- Laravel framework is used to build the backend.
  
### Frontend
- Vue3 (Composition API) is used for the frontend.
  
### Database
- MySQL or PostgreSQL is used as the database.

## Additional Tools

### Frontend Styling
- You can choose any frontend styling tools such as Bootstrap, Material, Tailwind, etc.

### Optional Tools (Choose one or more)
1. **Inertia.js**
2. **State Management and Routing**
   - Vue: Vuex, Vue Router
   - React: Redux, Redux Toolkit, React Router
3. **HTTP Requests and Utilities**
   - Axios, Lodash
4. **CSS Preprocessors**
   - SASS, SCSS, LESS

## Features to Implement

### 1. List Page
- Display a list of files in a tabular or block format.
- Implement pagination with a limit of 50 records per page.
- Display the following details for each file:
   - User-entered or original filename.
   - File size in megabytes.
   - File extension.
   - Cropped preview (100 x 100) for images.
   - Download link for the original file.
- Show the total number of records and the count on the current page.
- Include links to edit and delete entries.
- Deletion should be confirmed through a modal, removing both the database record and the file in the storage.
- Implement file search by filenames, and maintain search parameters in the browser's query string.

### 2. Create and Edit Page
- Include an optional "File Name" input (type=text).
- Implement a file upload field, required only for new uploads or updating existing files.
- Stylish input[type=file] with drag-and-drop functionality.
- Separate components for the name and file fields.
- Buttons for "Save" and "Delete," with confirmation modals on click.
- For file uploads, implement:
   - Validation for a maximum file size of 8 megabytes.
   - Progress bar showing the file upload status.

## Getting Started

1. Clone the repository.
2. Set up the Laravel environment, database, and migrations.
3. Install frontend dependencies and build the frontend.
4. Run the Laravel development server.

## Usage

- Access the application at `http://localhost`.
- Use the list page to view, search, edit, and delete files.
- Create and edit pages allow adding or updating files.

## Project Structure

```
/file_store_service
|-- /backend                  # Laravel Backend
|-- /frontend                 # Vue3 Frontend
|-- /database                 # Database Migrations
|-- /public                   # Public assets
|-- /resources                # Laravel Resources
|-- /tests                    # PHPUnit Tests
|-- .env.example              # Sample .env file
|-- README.md                 # Project Readme
```

Feel free to adjust the structure and instructions based on your preferences and requirements.