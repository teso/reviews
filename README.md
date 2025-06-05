This is a test project "Reviews" that uses DDD and Hexagonal architecture. It's a part of the system that allows our customers to integrate our review widget on their platforms and moderate reviews (left by their customers) using a special application.

The main code is here: `app/Modules`

It's part of the domain. For the whole domain model, look in: `docs/Base Model.puml

To start project:
1. `docker compose up -d`
2. `docker exec -it reviews_php bash` then `php artisan doctrine:schema:create`
3. Import `docs/openapi.yaml` into Postman

To refresh API spec: `vendor/bin/openapi -o docs/openapi.yaml app/`

To use xDebug:
1. Map project directory to remote `/var/www/reviews`
2. Make sure you are listening port `9003`
3. Use IDE key `PHPSTORM`
