# Setup Project

1. Clone the repository
2. copy the `.env.example` file to `.env` and fill in the necessary values
3. Ensure you have a `YOUTUBE_API_KEY` in your `.env` file
4. Run `sh entrypoints/setup.sh` to setup the project
5. Go to `http://localhost/api/docs` to view the API documentation and test the endpoint or use your preferred API client
6. Run `php artisan schedule:work` to run the scheduler
7. Run `php artisan test` to run the tests
