curl -s https://laravel.build/ReservationProjectV2 | bash &&
cd ReservationProjectV2 &&
sail up -d &&
sail composer require laravel/breeze --dev &&
sail artisan breeze:install &&
sail composer require inertiajs/inertia-laravel &&
sail npm install &&
sail npm install @inertiajs/vue3 &&
sail composer require laravel/scout &&
sail artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider" &&
sail composer require meilisearch/meilisearch-php http-interop/http-factory-guzzle &&
sail artisan migrate &&
echo -e "\n\033[0;31mDon't forget to add these lines to your vite.config.js file, after the 'defineConfig' line:\n\nserver: {\n    hmr: {\n        host: 'localhost',\n    },\n},\n\033[0m"

