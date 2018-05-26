#Simple blog Vue-Symfony

Wymagania
- PHP >= 7.1
- Node >= 8.1

Instalacja

Wykonaj polecenie php setup w folderze główny zainstaluje to większość zależności. Utwórz bazę danych. Następnie skonfiguruj plik .env w folderze back.
Wykona polecania w folderze back
- php bin/console doctrine:migrations:diff
- php bin/console doctrine:migrations:migrate
- php bin/console doctrine:fixtures:load(Do załadowania testowych danych)
- php bin/console server:start
- npm server run(w folderze front)
