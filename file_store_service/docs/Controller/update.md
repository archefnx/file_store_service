## Summary
This code snippet is a method called `update` in the `FilesController` class. It is responsible for updating a file record in the database and handling the uploaded file. The method first retrieves the file record based on the provided ID. It then validates the request data, allowing for the file to be optional. If the file exists in the request, it deletes the previous file associated with the record, updates the record with the new file details, and stores the new file. If the file does not exist in the request, it only updates the name of the file record. Finally, it redirects the user to the index page with a success message.

## Example Usage
```php
$request = new Request([
  'file' => $uploadedFile,
  'name' => 'New File Name',
]);
$id = 1;
$controller = new FilesController();
$response = $controller->update($request, $id);
```

## Code Analysis
### Inputs
- `$request` (Request): The request object containing the file and name data.
- `$id` (integer): The ID of the file record to be updated.
___
### Flow
1. Retrieve the file record based on the provided ID.
2. Validate the request data, allowing for the file to be optional.
3. If the file exists in the request:
   - Delete the previous file associated with the record.
   - Update the file record with the new file details.
   - Store the new file.
4. If the file does not exist in the request, update only the name of the file record.
5. Redirect the user to the index page with a success message.
___
### Outputs
- `$response` (RedirectResponse): The response object redirecting the user to the index page with a success message.
___
