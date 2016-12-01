# VaporShop
een shop gebaseerd op mijn Basis CMS

## Inhoud
+ [Alles van Base Systeem](https://github.com/powerchaos/base)
+ Ajax shop
+ Ajax Database Edit
+ Afstand Berekening
+ Stock Beheer
+ Clouds Systeem ( punten systeem)
+ Bonus objecten ( met punten )
+ PaymentWall API
+ Afbeeldingen in Database
+ Meta gebaseerd op omschrijving
+ Bestel Geschiedenis
+ 3 bestel statussen ( besteld - betaald - geleverd)
+ Volledige Shop
+ Register check op +18 jaar

## Stock Beheer
+ Stock bepaald de selectie (groen ? rood ? geel ?)
+ -1 op stock betekend niet meer leverbaar
+ 0 op stock betekend dat het kan worden besteld
+ Boven 0 is de resterende hoeveelheid voor die category ( geel ? groen ?)
+ Bestellingen gaan van stock af
+ in winkelmandje toegevoegt gaat van stock af , maar word terug gezet na 1 uur als het niet beseld is
+ Alle combinatie's zijn mogelijk
+ Stock heeft GEEN prijzen (maak nieuw product)


## besellingen
+ Verander de selectie update ook de prijs
+ prijs is gebaseerd op producten en NIET op stock
+ Verschillende text weergave gebaseerd op stock
+ 0 is bestellen , -1 is niet beschikbaar , laatste stuk in winkelmandje ...
+ Promo systeem geintregreerd in de shop

## Bonus Systeem
+ Voeg de % bonus in en de min hoeveelheid punten nodig
+ Bonus punten worden automatisch berekend
+ Punten worden pas toegekent NA betaling
+ Betaling met punten is mogelijk als het in promo staat

## CHECKOUT
+ Ajax gebaseerd
+ Prijs word berekend via ajax request ( ander bestand )
+ Checkout pagina is aleen voor visueel en bevestiging
+ Prijs word aangepast aan de hand van selectie ( jquery )
+ ajax update de pagina na bevestiging bestelling
+ Email word verstuurt als de gebruikersnaam een email is
+ Email word verstuurd naar de shop eigenaar ( bestelling@domain )

## Gebruikers menu
+ Uitloggen
+ Wachtwoord Veranderen
+ Bonus Shop bekijken ( promo items)
+ Bonus Status bekijken ( Hoeveelheid punten nodig voor promo )
+ Gegevens aanpassen ( profiel , inline edit )
+ History bekijken ( bestel status )

## Login / Register
+ Login werkt met gebruikersnaam of email
+ Ajax gebaseerd
+ Register kan uit een popup
+ Register kijkt Datum na
+ Anti Bot knop gebaseerd op random nummer ( met knop ) 

## Andere Zaken
+ Er is nog veel meer om uit te leggen , maar dan kan je beter zien
+ Site is NIET kant en klaar , Aanpassen is nodig

## BESTAND DIE JE MOET AANPASSEN
### /FUNCTIONS/
+ /functions/email.php voor email functie
+ /functions/database.php voor Database ( PDO MariaDB/Mysql)

### /
+ /ping.php Paymentwall Callback en API
+ /.htaccess FORCE SSL
+ /upload en /tmp moet schrijfbaar zijn ( 755 of 777)

### /TEMPLATE/
+ /template/boot/sidebar.php heeft een apparte Category (liquids)
+ /template/boot/css/style.css heeft een Base64 BackGround afbeelding

### /PAGES
+ /pages/admin/upload.php Relative Link aanpassen anders WERKT upload niet
+ /pages/home.php heeft fixed categorie's en Base64 Afbeeldingen
+ /pages/checkout.php Heeft standaard prijsen en selectie voor levering
+ /pages/invoer.php bij register staat er $promo = 50 
+ /pages/merk.php heeft base64 afbeeldingen ( default image)
+ /pages/product.php heeft base64 afbeeldingen ( default image)

### /AJAX
+ /ajax/bestel.php de eigenlijke bestelling text en Paymentwall API
+ /ajax/history.php bestel geschiedenis
+ /ajax/stock.php de text weergave van de stock
+ /ajax/tos.php De tos en contact info en privacy policy

### PAYMENTWALL
+ /ping.php -> Vergeet uw sleutels niet in te vullen
+ /ajax/bestel.php -> Vergeet uw sleutels niet in te vullen

execute de SQL script en je kan beginnen 

gebruiker : admin 
wachtwoord : 123456
