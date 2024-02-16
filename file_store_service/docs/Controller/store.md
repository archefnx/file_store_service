## Summary
This code snippet is a method called `store` inside the `FilesController` class. It is responsible for handling the logic of storing a file that is uploaded by the user.

## Example Usage
```php
$request = new Request();
$request->file = UploadedFile::fake()->create('test.pdf');
$request->name = 'Test File';

$controller = new FilesController();
$response = $controller->store($request);

// Expected output: Redirect to the 'files.index' route with a success message
```

## Code Analysis
### Inputs
- `$request` (Request): The HTTP request object containing the uploaded file and other form data.
___
### Flow
1. Validate the request data, ensuring that the 'file' field is required, is a file, has a maximum size of 20,480 KB, and has a valid file extension (jpeg, png, pdf, doc, docx).
2. Retrieve the uploaded file from the request using the `file` method.
3. Get the original name of the uploaded file using the `getClientOriginalName` method.
4. Create a new `Files` model instance with the provided name, original name, file extension, and file size.
5. Store the uploaded file in the 'public/uploads' directory using the `storeAs` method, with the file name formatted as 'id_originalName'.
6. Redirect the user to the 'files.index' route with a success message.
___
### Outputs
- Redirect response: The user is redirected to the 'files.index' route with a success message indicating that the file was uploaded successfully.
___
