# ReservationProjectV2

## Install Steps
### Windows 11:
Install WSL2 and Ubuntu LTS in Docker enable WSL2 integration and allow the Ubuntu. (Or your Linux version)

Go to your Terminal and run the following commands:
- `git clone https://github.com/devblaze/ReservationProjectV2.git`
- `cd ReservationProjectV2`
- `sail up -d`
- Import the event model to scout `php artisan scout:import`


Add this to your `.env` file:
```dotenv
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://<meilisearch-container-name>:7700/
```
