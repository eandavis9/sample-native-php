# sample-native-php

I've dockerized this sample app because my localhost wont let me run Apache and Mysql using XAMPP...

# To run, you must have docker installed

1. Go to root directory and run: docker-compose up --build -d
2. Make sure dbdump.sql is imported
3. Run docker exec -it php-apache bash
4. Run composer install
