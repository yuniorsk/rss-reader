# Zadanie

Vytvorte čítačku RSS feedov. Ak má ten istý feed (zhodná URL) viacero používateľov, tak aktualizácia jeho dát prebieha iba raz.

Vytvorte webovú aplikáciu podľa zadania. Pri implementácii sa sústreďte na softvérový návrh, bezpečnosť riešenia, používateľské rozhranie a dátovú udržateľnosť. Zaujíma nás Váš prístup k OOP a čistote kódu.

## Upresňujúce zadanie

- user management
  - voľná registrácia s prihlásením
- používateľ si spravuje svoj zoznam RSS/Atom kanálov
  - pridávanie (ponúknuť používateľovi názov feedu s možnosťou jeho úpravy)
  - mazanie
- zobrazovanie zoznamu príspevkov z používateľových kanálov
  - preklik na príspevok na zdrojovom webe
  - možnosť filtrácie (kanál, vyhľadávanie v titulkoch, ...)
  - stránkovanie
  - možnosť označiť príspevky ako prečítané/neprečítané (jednotlivo aj hromadne)
  - možnosť označiť príspevky špeciálnym flagom (zaujímavé alebo obľúbené)
- systém na aktualizáciu dát z feedov
  - pozor na duplikovanie príspevkov z feedov

## Doplňujúce informácie

- pri tvorbe dizajnu využite Bootstrap (verzia 3 alebo 4)
- použite php ľubovoľný framework (napriklad Yii verzia 1 alebo 2)
- použite databázový server MySQL alebo MariaDB
- zamerajte sa aj na základnú funkčnosť aplikácie (minimálne základná registrácia
užívateľov, pridávanie, zobrazenie zoznamu feedov)

## Spustenie aplikácie (Docker)

- run `docker-compose up -d`
- run `docker-compose exec php php yii migrate`
- visit [localhost](http://localhost)