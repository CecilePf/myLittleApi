My Little Api

- git clone
- cd myLittleApi
- composer install
- Update db informations in `.env` (`DATABASE_URL`)
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

Load fixtures (users) :
- php bin/console doctrine:fixtures:load

Generate your own jwt keys :

- mkdir config/jwt
- openssl genrsa -out config/jwt/private.pem -aes256 4096
- openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
- add your passphrase in `.env` (`JWT_PASSPHRASE`)

Run project with `symfony server:start`

You have to authenticate to access resources, please look in `UsersFixtures` to know the identifiers.
With user, you can post a transaction and get the list.
With admin, you can get the users list.

