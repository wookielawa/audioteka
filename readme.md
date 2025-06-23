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

## Uwagi do projektu i dalsze modyfikacje:

1. W drugim zadaniu pokazałem tylko jeden ze sposobów obsługi problemów z asynchronicznością, wykorzystałem już istniejącą bazę, aby zapisać informację o statusie operacji, moglibyśmy również zapisać takie informacje w bazie typu Redis, wykorzystać websockety albo nawet wysłać informację na wcześniej zdefiniowany webhook.
1. W drugim zadaniu najlepiej byłoby część odpowiedzialną za zapisywanie statusu wyodrębnić do osobnej klasy, która implementuje określony interfejs tak, aby zachować zasadę SRP oraz OCP.
1. Również do drugiego zadania założeniem było dodanie nowego endpointu, który za pomocą operation_id pobierałby informację o statusie dodania produktu do koszyka.
1. Co do dalszych modyfikacji to można byłoby poprawić trochę architekturę na bardziej domenową i wykorzystać CQRS do wyodrębnienia operacji odczytu i zapisu. Mamy już w kodzie odseparowaną warstwę zapisu i odczytu w klasach ProductService i ProductProvider, która jest dobrym kierunkiem, dodatkowo spełnia zasadę ISP.
1. Ze względu na brak czasu nie dodałem większej ilości testów.
1. Do edycji produktu wykorzystałem metodę PUT ze względu na małą ilość przesyłanych danych, można byłoby również zastosować metodę PATCH do aktualizacji pojedynczych pól.
1. Do edycji produktu wykorzystałem większą synchroniczność i zwróciłem od razu zmodyfikowany obiekt, gdyby te operacje były bardziej kosztowne to, moglibyśmy również przetwarzać asynchronicznie edycję produktów, podobnie jak dodawanie produktu do koszyka z wykorzystaniem operation_id.
1. W Pull Request odpowiedzialnym za mały refaktor repozytorium dodałem opis z motywacją zmiany oraz dalszych poprawek.
