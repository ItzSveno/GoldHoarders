# GoldHoarders

## Unser Projekt
Wir möchten eine Web API für eine Bankapplikation erstellen. Dafür benutzen wir PHP mit einer Datenbank. Auf der Datenbank implementieren wir Stored Procedures, Funktionen und Transaktionen. Unsere Funktionen sollte eine Geldüberweisung, Abfrage des Kontostandes, Einloggen, Registrieren, Passwort Ändern und eine Ausgabe der letzten Bewegungen eines Kontos haben. Für jede Funktion sollte eine Stored Procedure erstellt werden und Abfragen wie ob ein Konto genug Geld hat in einer Funktion der Datenbank. Wir wollen die Tabellen User, Konto und Transaktionen haben. Mehr als diese Funktionen sind nicht zu implementieren in diesem Projektzeitraum.

## Unser ERD

![image](https://raw.githubusercontent.com/ItzSveno/GoldHoarders/main/db/ERD.png)

## Vorbedingungen
1 PHP installiert und in der PATH Variable gesetzt
1 Composer installiert und in der PATH Variable gesetzt
1 MariaDB installiert und gestartet
1 (In Fall von Thema1) create_db.sql in mariaDB ausführen um die Datenbank zu erstellen
1 (In Fall von Thema2) php bin/doctrine orm:schema-tool:update --force --dump-sql --complete ausführen um die Datenbank zu erstellen

## Projekt einrichten

### Thema 1
- Unter thema1/config/ die Datei config.php erstellen gemäss config.php.example
- In thema1/ das Befehl `composer install` ausführen

### Thema 2
- Dasselbe wie bei Thema 1

## Hosting
- Entweder unter thema1 oder thema2 das Befehl `php -S localhost:{beliebiger Port}` ausführen

## Architektur

### Thema 1
![thema1](https://raw.githubusercontent.com/ItzSveno/GoldHoarders/main/architecture/thema1_architektur.png)

- config/ enthält die Konfigurationen für die db
- src/Controller/API/ enthält die API Controller
- src/Enums/ enthält die jenigen Enums die wir benutzen
- src/Model/ enthält die Model Klassen und ein Singleton für die Datenbankverbindung

### Thema 2
![thema2](https://raw.githubusercontent.com/ItzSveno/GoldHoarders/main/architecture/thema2_architektur.png)

- bin/ enthält die Doctrine CLI
- config/ enthält die Konfigurationen für die db
- src/Controllers/ enthält die API Controller
- src/Enums/ enthält die jenigen Enums die wir benutzen
- src/Models enthält die ORM Models
- src/ORM enthält den EntityManager und seine Konfigurationen

## Schnittstellen
### /auth
#### /login POST - $email, $password
#### /register POST - $email, $name, $password
#### /logout GET - keine Parameter

### /user
#### /index GET - keine Parameter
#### /show GET - $id
#### /create POST - $email, $name, $password
#### /update POST - $id, $email, $name, $password
#### /delete GET - $id

### /account
#### /index GET - keine Parameter
#### /show GET - $id
#### /create POST - $user_id, $balance, $type
#### /update POST - $id, $user_id, $balance, $type
#### /delete GET - $id

### /transaction
#### /index GET - keine Parameter
#### /indexOfReceiver GET - $receiver_id
#### /indexOfSender GET - $sender_id
#### /show GET - $id
#### /create POST - $from_account_id, $to_account_id, $amount

## Reflektion
Mit wie unser Projekt herausgekommen ist sind wir zufrieden. Wir hatten eigentlich noch geplant die thema3 Aufgabe zu erledigen, nun könnten wir damit nicht beginnen, da wir dafür nicht genügend viel Zeit hatten.
Für nächstes Mal würden wir uns vielleicht die Zeit besser aufteilen, damit wir nicht an den letzten wochen mehr als am Anfang arbeiten müssen.