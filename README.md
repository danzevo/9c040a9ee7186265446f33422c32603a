
# Send mail

Simple project to send email using php & rabbit mq

# Instalation
1. composer install
2. import db in db/db.sql
3. create exchanger in rabbitmq with name : newEmail
4. create queue in rabbitmq with name : email
5. bind exchanger 'newEmail' to queue 'email'
6. run consumer in src/service -> php Receive.php
7. import gotest.postman_collection.json to postman or insomnia

note : enable extension sockets to use rabbitmq in php.ini
