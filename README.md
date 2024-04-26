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

## Project Structure

The application is structured into four distinct microservices:

- **Battle Service**: Manages the combat aspects of the game, allowing players to engage in battles while searching for secrets.
- **Location Service**: Handles geolocation functionality, enabling the game to place secrets around the world and track player movements.
- **Secret Service**: Responsible for the generation and management of secrets that players find during their adventures.
- **User Service**: Takes care of user authentication, profiles, and progress within the game.

Each microservice is designed to operate independently, communicating with each other via RESTful APIs to create a seamless gaming experience.

## Reference
Based on 'PHP Microservices' book by Carlos Perez Sanchez and Pablo Solar