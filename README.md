<h1 align="center">
  🐘 Finding Secrets
</h1>

<p align="center">
  Welcome to the Finding Secrets repository, a modern PHP 8 project utilizing the Lumen framework. This project is inspired by the concepts presented in the book "PHP Microservices" by Carlos Perez Sanchez and Pablo Solar. Finding Secrets is an engaging location-based game, akin to Pokémon Go, where players traverse the globe to uncover hidden secrets.
</p>

## 🚀 Environment Setup

### 🐳 Needed tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `git clone https://github.com/serodas/finding-secrets-php.git`
3. Move to the project folder: `cd finding-secrets-php`
4. Run the Docker containers: `docker-compose up -d`
5. Run `docker exec -it microservice_secret_php /bin/bash` and run `php artisan migrate` so `php artisan db:seed` to create the tables in the database and seed the secrets table.
5. Run `docker exec -it microservice_user_php /bin/bash` and run `php artisan migrate` so `php artisan db:seed` to create the tables in the database and seed the secrets table.

## Project Structure

The application is structured into four distinct microservices:

- **Battle microservice**: This service will be responsible for the users battle, keeping a record of each battle and moving secrets from the loser wallet to the winner
- **Location microservice**: The main responsibility is to know where everything is located; for example, if the user service needs to know if there are secrets in the area, sending a message with the geolocalization to this service, the response will tell the User Service what secretes are in the area.
- **Secret microservice**: This is one of the core services for our game because it will be responsible for all the secrets stuff.
- **User microservice**: The main responsibility of this service is user registration and management. To keep the example small, we will also add extra
functionalities, such as user notifications and secrets wallet management. When an user is created in the User Service, it is added to queue in the Redis service.

Each microservice is designed to operate independently, communicating with each other via RESTful APIs to create a seamless gaming experience.

## API Paths To Test application
### Battle Microservice
| **Endpoint** | **Role**| **Method** | **Purpose** |
| --- | --- | --- | --- |
| http://localhost:8081/api/v1/battle/duel | | POST | Initiates a duel between two users, userA and UserB, returns the result of the duel |

### Location Microservice
| **Endpoint** | **Role**| **Method** | **Purpose** |
| --- | --- | --- | --- |
| http://localhost:8082/api/v1/locations/secrets | | POST | Returns a list of the closest secrets based on the provided latitude and longitude |

### Secret Microservice
| **Endpoint** | **Role**| **Method** | **Purpose** |
| --- | --- | --- | --- |
| http://localhost:8083/api/v1/secrets | | POST | Creates a new secret with name, latitud, longitude, location_name |
| http://localhost:8083/api/v1/secrets | | GET | Returns a list of all secrets |
| http://localhost:8083/api/v1/secrets/{id} | | GET | Retrieves a specific secret identified by the secret ID |

### User Microservice
| **Endpoint** | **Role**| **Method** | **Purpose** |
| --- | --- | --- | --- |
| http://localhost:8084/api/v1/login | Anyone with a valid username and password | POST | Generates access tokens that can be used in other API calls in this microservice |
| http://localhost:8084/api/v1/users | Anyone with a valid user token | POST | Creates a new user with name, email and password |
| http://localhost:8084/api/v1/users | Anyone with a valid user token | GET | Returns a list of all users |
| http://localhost:8084/api/v1/users/{id}| Anyone with a valid user token | GET | Retrieves a specific user identified by the user ID |
| http://localhost:8084/api/v1/users/{id}/wallet | Anyone with a valid user token | GET | Gets a secret from the user wallet |

## Reference
Based on 'PHP Microservices' book by Carlos Perez Sanchez and Pablo Solar