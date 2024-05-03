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
5. Run `docker exec -it sentry sentry upgrade` to create the Sentry tables
6. Log in `http://localhost:9876/auth/login/sentry/` with the user you created in the previous step and create a new project to start tracking your errors/logs.

## Project Structure

The application is structured into four distinct microservices:

- **Battle Service**: This service will be responsible for the users battle, keeping a record of each battle and moving secrets from the loser wallet to the winner
- **Location Service**: To add an extra layer of complexity, we decided to create a service to manage any task related to locations. The main responsibility is to
know where everything is located; for example, if the user service needs to know if there are other players in the area, sending a message with the geolocalization
to this service, the response will tell the User Service who is in the area.
- **Secret Service**: This is one of the core services for our game because it will be responsible for all the secrets stuff.
- **User Service**: The main responsibility of this service is user registration and management. To keep the example small, we will also add extra
functionalities, such as user notifications and secrets wallet management. When an user is created in the User Service, it is added to queue in the Redis service.

Each microservice is designed to operate independently, communicating with each other via RESTful APIs to create a seamless gaming experience.

## Reference
Based on 'PHP Microservices' book by Carlos Perez Sanchez and Pablo Solar