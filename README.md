# Login_1DV610
Testing credentials:
login: mattias
password: hubbabubba

# Book repository application

## Installation instructions
To install this application you need a server for serving the php-files, and a database to store user credentials and library information. The application is currently made for an SQL database, and you need to provide a config file for your database. 
- Use the template_config.php file. Fill in the information for your database, and change the name to just "config.php". 
- Copy all the php files to your server. (Tested on an apache server run in a Ubuntu 16.04 environment). 
- You're good to go!

## Requirements:
- User should be able to log in (using authentication module from earlier assignment).
- User should be able to add books with a title, an author and a description.
- User should be able to edit a book previously added, and save changes.
- User should be able to delete a book. 

# Use Cases: 

## User case 1: Add new book
### Precondition
User is authenticated.

### Main scenario:
1. Starts when a user is on main page.
2. System presents form to add book, in which system asks for title, author and, optionally, description of book, and a button to add book. 
3. User provides author, title, and a description of the book. 
4. System adds book to the database, and adds it to the list of added books that is shown on the main page. 

### Alternate Scenarios
3a. User does not provide either title or author.
    - System does not add book, and presents user with a message asking them to provide at least author and title. 

## User case 2: Edit existing book
### Precondition
User is authenticated.

### Main scenario:
1. Starts when user clicks on the "edit book" link next to a book in the list on the main page. 
2. System renders a form with fields for title, author, description with the saved information filled out, a read only field with the book id, and option to save change, or delete book. 
3. User makes desired changes and cicks save changes. 
4. System updates book and loads main page with updated information.

### Alternate Scenarios
3a. User removes title and/or author and clicks save changes. 
    - System presents message asking user to fill in at least author and title. 

## User case 3: Delete existing book
### Precondition
User is authenticated.

### Main scenario:
1. Starts when user clicks on the "edit book" link next to a book in the list on the main page. 
2. System renders a form with fields for title, author, description with the saved information filled out, a read only field with the book id, and option to save change, or delete book. 
3. User clicks delete book. 
4. System deletes book and loads main page with remaining books.

# System development status
All main scenarios implemented and tested. Alternate scenarios implemented, but message should be moved to a better location. 
