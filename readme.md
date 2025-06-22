# Audioteka: zadanie rekrutacyjne

## Instalacja

Do uruchomienia wymagany jest `docker`

1. Zbuduj obrazy dockera `docker compose build`
1. Zainstaluj zależności `docker compose run --rm php composer install`.
1. Zainicjalizuj bazę danych `docker compose run --rm php php bin/console doctrine:schema:create`.
1. Zainicjalizuj kolejkę Messengera `docker compose run --rm php php bin/console messenger:setup-transports`.
1. Uruchom serwis za pomocą `docker compose up -d`.

Jeśli wszystko poszło dobrze, serwis powinien być dostępny pod adresem 
[https://localhost](https://localhost).

Przykładowe zapytania (jak komunikować się z serwisem) znajdziesz w [requests.http](./requests.http).

Testy uruchamia polecenie `docker compose run --rm php php bin/phpunit`

## Oryginalne wymagania dotyczące serwisu

W pliku [requirements.pdf](./requirements.pdf) znajdziesz oryginalne wymagania dotyczące serwisu.

## Twoje Zadanie

W pliku [requirements.pdf](./requirements.pdf) znajdziesz scenariusz Twojego zadania.


Powodzenia!


## Aby uruchomić projekt po zmianach:

1. Zbuduj obrazy dockera `docker compose build`
1. Zainstaluj zależności `docker compose run --rm php composer install`.
1. Zainicjalizuj bazę danych jeżeli nie masz jej lokalnie `docker compose run --rm php php bin/console doctrine:database:create`.
1. Uruchom migracje `docker compose run --rm php php bin/console doctrine:migrations:migrate`.
1. Zainicjalizuj kolejkę Messengera `docker compose run --rm php php bin/console messenger:setup-transports`.
1. Uruchom serwis za pomocą `docker compose up -d`.
