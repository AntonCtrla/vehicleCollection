# Vehicle Collection Application

This application collects, stores, and displays vehicle data from a remote API. 
The front-end uses Bootstrap for styling and DataTables.js for table views with pagination. 
The back-end is built with PHP 8, and uses MySQL for data storage.

## Installation

### Prerequisites:
1. PHP 8
2. MySQL
3. Composer
4. A web server (e.g., Apache, Nginx)

## Steps:

### Clone the repository:
git clone git@github.com:AntonCtrla/vehicleCollection.git

### Install dependencies using Composer:
composer install

### Set up the database:
1. Create a MySQL database.
2. Import the SQL dump file located at database/vehicle_collection.sql into your database.

## Endpoints

Configured in the **/src/Controllers/RouterController.php**

## License

Free to use