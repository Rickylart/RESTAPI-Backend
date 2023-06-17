# RESTAPI-Backend
This is a test backend project with end points - GET &amp; POST. 

# Installation
Clone the project and create a new file .env after copy the .env.development codes into the .env file.
Now run composer install or update
Create new database called sevenz_healthcare_backend and run php artisan migrate to run the table migrations.
Import the postman collections for the https request
For Graphql playground visit /graphiql

# Note
All requests uses token bearer for authencation
To get the token , register a user and login to generate the token
All Authencations are bearer
