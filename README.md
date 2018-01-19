# Tablets E-Comerce web site

## Functionalitati
* Pagina de LOG IN in care utilizatorul se poate autentifica sau poate sa-si creeze un cont nou.
* Afisarea produselor in functie de categoria aleasa (tablete sau smartphone) in pagina principala precum si butoane prin care utilizatorul poate sa:
  * Sorteze produsele dupa pret
  * Restranga cautarea prin selectarea unui range al pretului, brand, OS, CPU, SIM
  * Caute un produs dupa nume
  * Acceseze profilul in care va gasi detalii despre cont precum si istoricul comenzilor
  * Adauge produse in cos avand posibilitatea de a trimite comanda sau sa stearga continutul cosului
* Administratorul are la dispozitie un admin panel in care:
  * Poate verifica comenzile esuate obtinand informatii despre utilizatorul care a trimis comanda precum si data la care a fost trimisa
  * Poate sa vada toate produsele din baza de date
  * Poate sa stearga un produs dupa id
  * Poate sa modifice numele unui utilizator


## Register.php
### Register form

-  Verificam daca username-ul si/sau parola exista

```sql
SELECT username FROM users WHERE username = '$un';
SELECT email FROM users WHERE email = '$em';
```
* Inserare in tabela users

```sql
INSERT INTO users VALUES (default, '$fn', '$ln', '$adr', '$un',  '$em', '$encryptedPw', '$date', '$rights')
```
### Login form
* Verificam daca datele introduse sunt corecte

```sql
SELECT * FROM users WHERE username='$un' AND password='$pw'
```


## Index.php
Adaugarea produselor in cos se face in urmatorul fel:

* Se numara cate tickete (comenzi) sunt in baza de date

```sql
SELECT COUNT(*) as ticketOrder FROM ticket
```
* Se alege o variabila ce ia numarul de tickete + 1 reprezentand ticket-ul user-ului autentificat pe site

```javascript
$query = mysqli_query($con,"SELECT COUNT(*) as ticketOrder FROM ticket");
$row = mysqli_fetch_array($query);
$ticketNumber = $row['ticketOrder'] + 1;
```

### Header.php

* Search (getSearchQuery())

```sql
SELECT id, name, price, path, stoc, device_ID
FROM devices WHERE (`name` LIKE '%".$query."%')
GROUP BY name
```

* Luam numele produselor din cos, pretul precum si suma cantitatilor produselor de acelasi fel

```sql
SELECT D.name, C.price, sum(C.amount) as amount
FROM cart C JOIN devices D ON (C.devices_ID = D.id)
WHERE ticket_ID = '$ticketNumber'
GROUP BY D.name
```

* Verific daca cantitatea excede stocul produselor din Cos

```sql
SELECT C.id,C.ticket_ID,C.devices_ID,sum(C.amount) as amount, C.price FROM cart C
WHERE C.ticket_ID = $ticketNumber
GROUP BY C.devices_ID
HAVING SUM(C.amount) >ALL (SELECT D.stoc
                          FROM devices D
                          WHERE C.devices_ID = D.id)
```

* Modifica stocul produselor comandate: stoc = stoc - suma cantitatilor produselor din cos (tabela cart) grupate dupa id produs unde id produs se afla in cos

```sql
UPDATE devices D
SET stoc = stoc - (SELECT sum(C.amount)
                  FROM cart C
                  WHERE D.id = C.devices_ID AND C.ticket_ID = $ticketNumber group by C.devices_ID)
WHERE D.id in     (SELECT C.devices_ID
                  FROM cart C
                  WHERE C.ticket_ID = $ticketNumber group by C.devices_ID)
```

* Dupa ce comanda a fost trimisa se creaza un ticket care specifica datele comenzii

```sql
INSERT INTO ticket VALUES (DEFAULT, '$idd', '$total', '$date')
```

* Sterge produsele din cos daca comanda a fost anulata sau daca comanda a fost trimisa dar cantitatea comandata nu se afla in stoc

```sql
DELETE FROM cart WHERE ticket_ID = $ticketNumber
```

### Mainview.php
* Am facut un select mare care selecteaza pret, categorii in functie de ce butoane sunt apasate (getQuery($con, $device, $order))

```sql
SELECT D.id,D.name,D.price,D.stoc,D.path,D.device_ID,B.brand,C.CPU,O.OS,S.SIM
FROM devices D
  JOIN brand B
      ON (D.brand_ID = B.id)
  JOIN cpu C
      ON (D.CPU_ID = C.id)
  JOIN os O
      ON (D.OS_ID = O.id)
  JOIN sim S
      ON (D.SIM_ID = S.id)
WHERE D.device_ID = $device AND . $price . $brand . $cpu . $os . $sim . $order

UNDE:
$device = "1" (tablete) | "2" (smartphone)
$price = D.price > $minPrice AND D.price < $maxPrice
$brand = AND B.brand LIKE 'brand'
$cpu = AND C.CPU LIKE 'cpu'
$os = AND O.OS LIKE 'os'
$sim = AND S.SIM LIKE 'sim'
```

### Device.php
* Detalii despre device-ul selectat

```sql
SELECT D.id,D.name,D.diagonala,D.price,D.mem_ram,D.mem_intern,D.path,D.stoc,B.brand,C.CPU,O.OS,S.SIM,CTG.name as deviceName
FROM devices D
  JOIN brand B
      ON (D.brand_ID = B.id)
  JOIN cpu C
      ON (D.CPU_ID = C.id)
  JOIN os O
      ON (D.OS_ID = O.id)
  JOIN sim S
      ON (D.SIM_ID = S.id)
  JOIN category CTG
      ON (D.device_ID = CTG.id)
WHERE D.id = $deviceID
```

* Adauga device in cart

```sql
INSERT INTO cart VALUES (DEFAULT, '$ticket','$id','$amount','$price')
```

### Profile.php

* Selecteaza date despre utilizatorul autentificat

```sql
SELECT U.firstName, U.lastName,U.adresa
FROM users U WHERE U.id = $_SESSION[userID]
```

* Selecteaza comenzile utilizatorului autentificat

```sql
SELECT U.id, U.firstName, U.lastName,U.adresa,T.date,T.total
FROM users U JOIN ticket T ON (T.users_ID = U.id)
WHERE T.total not in (SELECT T1.total from ticket T1 Where T1.total = 0) AND U.id = $ui
```

* Selecteaza produsele din cadrul unei comenzi efectuate de utilizatorul autentificat

```sql
SELECT T.id, sum(C.amount) as amount, C.price * sum(C.amount) as total, D.name
FROM ticket T JOIN cart C ON (C.ticket_ID = T.id) JOIN devices D ON (D.id = C.devices_ID)
WHERE T.users_ID in (SELECT U.id
                    FROM users U
                    WHERE U.id = $ui) AND T.id = $t
GROUP BY T.id,C.devices_ID
```

### Admin-panel.php
* Afiseaza comenzile esuate (comenzi care din cauza ca s-a comandat mai multe produse decat sunt in stoc apar cu total = 0)

```sql
SELECT U.username,T.date
FROM users U JOIN ticket T ON (T.users_ID = U.id)
WHERE T.id in (SELECT T2.id FROM ticket T2 WHERE T2.total = 0)
```

* Afiseaza produsele din baza de date

```sql
SELECT id,name,price,stoc FROM devices
```

* Sterge un produs

```sql
DELETE FROM devices WHERE id = '$id'
```
* Update nume useri

```sql
UPDATE users U
SET firstName = '$fn'
WHERE id = '$id'
```
