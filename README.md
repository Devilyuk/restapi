
# REST API for working with users

This project implements REST API methods:

 - registration
 - authorization
 - search
 - update
 - delete

## Project structure
All the methods listed above are located in the file `api/obj/user.php`.

These methods are called from files with the corresponding names in the `api/user/` section.

To connect the database, you need to edit the `api/conf/db.php` file.

## Technologies used

The server part is written in `php`, a `MySQL` database is used to store user data. Data is transmitted to the server using `JavaScript` - `AJAX` methods in `json` format.

## Description of methods

 - `createUser()` - accept data (name, email, phone and password) and if all fields are filled in, a new entry is added to the database, and the user sees a message about successful registration. Otherwise, an error message is displayed.
 - `auth()` - accepts mail and password from the user. At the beginning, it checks whether there is a user with this mail in the database, if there is, it checks whether the password is entered correctly, if there is no such user, an error message is displayed.
 - `search()` - accepts only one parameter - id and searches the user database by the specified identifier. If such a user exists, it returns his data in json format. If there is no user, it returns an empty result.
 - `updateUser()` - first, it takes one parameter and searches for the user in the database. If the user is found, it displays the form (name, mail, phone) and immediately fills it with data that the user can change and click on the "save" button to transfer data to the server. Finally, the method accepts new data (name, mail, phone) and updates the database entry.
 - `delete()` - accepts the id from the user and deletes the record with the specified ID from the database.

