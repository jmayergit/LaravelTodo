# Development

<a href="https://www.youtube.com/watch?v=I980aPL-NRM">Docker tutorial</a>

### Steps
1) copy .env.example contents to an .env file
2) docker-compose up -d --build
3) docker-compose run --rm artisan migrate
4) docker-compose run --rm artisan db:seed
5) docker-compose run npm run watch
5) http://0.0.0.0:8080/