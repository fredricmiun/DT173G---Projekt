# DT173G - Webbutveckling III

[Mittuniversitetet](https://www.miun.se/ "Mittuniversitetets Hemsida")

### Moment Projekt

REST API - Webbtjänst

1.  Klasser

    - Database.php
      Ansluter till Databasen med PDO och inte mysqli. Ersätt server, username och password med dina egna anslutningsuppgifter.

    - Cv.php
      Denna klass sköter allt som berör cv:t. Den hämtar all information om den, uppdaterar, lägger till och tar bort innehåll.

    - Join.php
      En engångsfil som tillåter en att skapa en användare för hemsidan.

    - Login.php
      Denna fill skapar en inloggningssession om rätt inloggningsuppgifter anges.

2.  Controller & View

    Två filer - CvController.php & CvView.php

    Dessa två filer har hand om frågor till klassen och tar även hand om svaret som genereras. Svaret är antingen ett "rått" svar eller så behandlas svaret i en av view-funktionerna i CvView-filen.

3.  API-katalogen

    - Dessa filer är vad klientsidan får kontakt med. De är uppbyggda i switch-metoder för lätt urskiljning. Just nu kan utomstående även få kontakt med filen. Ändra \* till din egen URL.

4.  Övrigt

    Config-filen innehåller variabler, autoloader, ob_start() samt session_start();

    Funktions-filen icon.php innehåller en funktion som returnerar en svg-bild. Detta för att svg-grafik ofta har lång syntax, så genom att placera de i funktioner kan vi kalla på dem och hålla ursprungsfilen städad. Argument finns i funktionen för att bestämma storlek & färg.
