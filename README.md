# ReservationProjectV2

ReservationProjectV2 is a web-based event reservation system, offering an interactive interface for creating, managing, and searching for events. The application uses a modern technology stack including Docker, Laravel, Vue.js, and Tailwind CSS, and leverages MeiliSearch for efficient event data handling.

## Features

- **Event Creation**: Users can create events with details like title, description, dates, and location.
- **Seat Map**: Interactive seat map allowing users to arrange seats and tables.
- **Event Search**: Search functionality to quickly find events.
- **Real-Time Notifications**: Notifications for actions such as event creation and deletion.
- **Responsive Design**: Built with Tailwind CSS for a responsive, mobile-friendly user experience.
- **Backend Integration**: Laravel backend for handling business logic, database operations, and API endpoints.


## Getting Started

These instructions will guide you through setting up the project on your local machine for development and testing purposes.

### Prerequisites

- Windows 11 with WSL2 and Ubuntu LTS
- Docker with WSL2 integration
- Git

### Installation Steps

#### Windows 11:

1. **WSL2 and Ubuntu Setup**:
    - Install WSL2 and Ubuntu LTS.
    - Enable Docker WSL2 integration and allow Ubuntu (or your chosen Linux version).

2. **Project Setup**:
    - Open your Terminal and clone the repository:
      ```
      git clone https://github.com/devblaze/ReservationProjectV2.git
      ```
    - Change directory to the project folder:
      ```
      cd ReservationProjectV2
      ```
    - Start the Docker environment with Laravel Sail:
      ```
      sail up -d
      ```
    - Install PHP dependencies:
      ```bash
      composer install
      ```
      Install NPM packages:
      ```bash
      npm install
      ```
      Set up your environment variables in .env file (use .env.example as a template).
      Generate an application key:
      ```bash
      php artisan key:generate
      ```
      Run migrations and seed the database (if applicable):
      ```bash
      php artisan migrate --seed
      ```
    - Start the frontend server:
      ```bash
      npm run dev # In a separate terminal
      ```
    - Import the event model to Laravel Scout:
      ```
      php artisan scout:import
      ```

3. **Environment Configuration**:
    - Add the following lines to your `.env` file:
      ```dotenv
      SCOUT_DRIVER=meilisearch
      MEILISEARCH_HOST=http://<meilisearch-container-name>:7700/
      ```

## Running the Application

To start the application, use the following command:
```bash
sail -up -d
```
The application will be accessible at `http://localhost`.

## Running the Tests
For now we have only end-to-end tests you can download the standalone cypress from [here](https://www.cypress.io/).

Create a new project and place the `eventManagment.cy.js` from the project `/ReservationProjectV2/tests/cypress/e2e`.

## Built With

- [Laravel](https://laravel.com/) - The backend framework used
- [Vue.js](https://vuejs.org/) - Frontend JavaScript framework
- [Tailwind CSS](https://tailwindcss.com/) - CSS framework for styling
- [Docker](https://www.docker.com/) - Containerization platform
- [MeiliSearch](https://www.meilisearch.com/) - Search engine

## Contributing

Please read [CONTRIBUTING.md](https://github.com/devblaze/ReservationProjectV2/CONTRIBUTING.md) for the process for submitting pull requests to us.

## Versioning

For the versions available, see the [tags on this repository](https://github.com/devblaze/ReservationProjectV2/tags).

## Authors

- **Nikolaos Christos Antoniadis** - _Initial work_ - [Nick Antoniadis](https://github.com/devblaze)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

