# Bierwart
Der Bierwart ist eine Anwendung zum Verwalten von Getränkekassen von Vereinsheimen o.ä.

## Einrichtung

 - `git clone https://github.com/HerrLevin/Bierwart.git`
 - `cd Bierwart`
 - `composer install`
 - sqlite-Datenbank in `database` namens `database.sqlite` erstellen und `default_migration.sql` ausführen
   - alternativ `database.bak.sqlite` in  `database.sqlite` umbenennen
 - `php -S localhost:8000` im Hauptverzeichnis
 - [http://localhost:8000/swagger/](http://localhost:8000/swagger/) aufrufen