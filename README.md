## About Project

API in PHP using Laravel and Postgres to control event registration registration, with authentication using jwt token as cookie.
Contains the functions of Registration, Login, List Events, Register, Update registration and delete registration

Certainly! Here are some advantages of your system that you can include in your README file:
Advantages of this System

- Efficient Event Registration: This system provides a streamlined and efficient process for event registration. Users can easily sign up for events with minimal effort.
- Secure Authentication: The system implements secure authentication using JWT tokens as cookies. This ensures that user data remains confidential and tamper-proof.
- User-Friendly Registration: Users can register for events with ease. The registration process is user-friendly and straightforward.
- Convenient Login: The login functionality allows registered users to access their accounts securely. It enhances user experience by providing a personalized environment.
- Event Listing: The system offers a feature to list events. This feature helps users discover and choose the events they want to attend.
- Flexible Event Registration: Users can register for multiple events, offering flexibility in event selection.
- Update Registration Information: Users can easily update their registration information, ensuring that their details are always up-to-date.
- Delete Registration: In cases where users need to cancel their event attendance, the system provides a simple way to delete their registration.
- Highly Customizable: The system is built on Laravel, a powerful PHP framework, making it highly customizable and extensible. You can further enhance and adapt it to meet specific project requirements.
- Database Backed by PostgreSQL: The system utilizes PostgreSQL as the database management system. PostgreSQL is known for its reliability and performance, making it a suitable choice for data storage.
- Community Collaboration: The project encourages collaboration and contribution from the developer community. Contributors can help enhance and improve the system's functionality.
- Open Source: This system is open-source, allowing developers to use, modify, and distribute it freely, making it accessible to a wide range of users and projects.

## Requirements
- PHP 8.1.2
- PostgreSQL 15.4

## Run the project
Access the project root folder and run the following command to upload the environment:

vendor/vin/sail up

## API ENDPOINTS

### Register a new user.

**Method:** POST

**URL:** `0.0.0.0:80/api/admin/register`

**JSON BODY:**
```json
{
"name": "Mônica de Souza",
"email": "monica@email.com",
"password": "1234567",
"password_confirm": "1234567"
}
```

### Login

Logs a user in, generating a JWT token and storing it in a cookie.

**Method:** POST

**URL:** `0.0.0.0:80/api/admin/login

**JSON BODY:**
```json
{
"email": "monica@email.com",
"password": "123456"
}
```
### Get user

Displays logged in user data.

**Method:** GET

**URL:** 0.0.0.0:80/api/admin/user

### Logout

Logs the user out, destroying the cookie containing the JWT token.

**Method:** POST

**URL:** 0.0.0.0:80/api/admin/logout

### Update user

Updates the logged in user's name and email.

**Method:** PUT

**URL:** 0.0.0.0:80/api/admin/user/update

**JSON BODY:**
```json
{
    "name": "Mônica de Souza",
    "email": "monica@email.com"
}
```

### Update Password

Updates the logged in user's password.

**Method:** PUT

**URL:** 0.0.0.0:80/api/admin/user/password

**JSON BODY:**
```json
{
    "password": "123456"
}
```

### Enrollment List

Returns a list of registrations made

**Method:** GET

**URL:** 0.0.0.0:80/api/admin/enrollment

### Register a registration

Saves a new record for a new registration.

**Method:** POST

**URL:** 0.0.0.0:80/api/admin/enrollment

**JSON BODY:**
```json
{
    "name": "Mônica de souza",
    "cpf": "34258767890",
    "email": "monica@email.com",
    "event_id": 2
}
```

### Edit Enrollment

Edits the record referring to a registration based on the registration ID entered

**Method:** PUT

**URL:** 0.0.0.0:80/api/admin/enrollment/update/5

**JSON BODY:**
```json
{
    "name": "Mônica de Souza",
    "cpf": "11111111111",
    "email": "monica@email.com",
    "event_id": 3
}
```
### Show Enrollment

Displays details for a specific subscription.

**Method:** GET

**URL:** 0.0.0.0:80/api/admin/enrollment/show/223

### Delete Enrollment

Deletes a registration record, based on the registration id

**Method:** DELETE

**URL:** 0.0.0.0:80/api/admin/enrollment/destroy/19

**JSON BODY:**
```json
{
    "name": "Monica de Souza",
    "cpf": "34258767890",
    "email": "monica@email.com",
    "event_id": 2
}
```
### Filter Enrollment

Returns existing registrations filtered by registered email address

**Method:** GET

**URL:** 0.0.0.0:80/api/admin/enrollment/filter?order_direction=desc&search=m

### Lists existing events.

Lists existing events.

**Method:** GET

**URL:** 0.0.0.0:80/api/admin/enrollment/events

## Version
V 1.0.0

## Authors

- André Emílio | Developer / Systems Analyst | Email: and.emilio@gmail.com

## License

Este projeto está sob a Licença MIT - consulte o arquivo LICENSE.md para obter detalhes.
