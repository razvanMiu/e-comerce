#### 1. Primitivele functionale ale CD

* ``Memoria M:`` este o matrice de elemente de memorare organizata intr-un spatiu de adresare unic (65536 cuvinte a cate 16 biti fiecare). Citirea si scrierea se fac asincron sub controlul unitatii de comanda
* ``Registrul AM:`` este registrul de adresare a memoriei, ce pastreaza adresa celulei de memorie la care se face acces la un moment dat. Adresa efectiva este memorata in AM selectand, prin decodificare, cuvantul din memorie la care se va face accesul.
* ``Registrele RG:`` reprezinta o memorie rapida, organizata sub forma a 8 registre de cate 16 biti fiecare si se folosesc deoarece timpul de acces la memoria M este relativ mare. Contin unul sau ambii operanzi necesari pentru executia instructiunilor CD. Unele din aceste registre pot fi folosite si pentru calculul adresei efective a operanzilor din memorie.
  - ``BA,BB:`` registre de baza
  - ``XA,XB:`` registre index
  - ``IS:`` utilizat ca indicator pentru adresarea unor structuri de tip stiva
  - ``RA,RB,RC:`` utilizate numai pentru pastrarea operanzilor
* ``Registrul CP:`` este utilizat pentru pastrarea instructiunii ce urmeaza sa se execute dupa terminarea executiei instructiunii curente. CP poate fi:
  - initializat cu o valoare data la initializarea sistemului
  - initializat cu o valoare oarecare prin executia instructiunilor de transfer control
  - incrementat in cazul executiei instructiunilor ce nu specifica transferul la o alta secventa
* ``Unitatea aritmetica locica UAL:`` realizeaza operatiile aritmetice si logice ale calculatorului didactic si este utilizata pentru prelucrarea datelor si pentru calculul adresei efective. Prelucreaza operanzi pe 16 biti reprezentati in cod complementar. Conditiile in care s-a efectuat o operatie UAL sunt pastrate intr-un registru de indicatori IND
* ``Registrele T1,T2:`` sunt registre temporale, folosite pentru a pastra operanzii unei operatii executate in UAL
* ``Indicatorii de conditie IND:`` constituie o grupare a unor bistabili cu functii individuale, pozitionati la executia instructiunilor in functie de rezultatul din UAL
* ``Registrul de instructiuni RI:`` pastreaza codul instructiunii in curs de executie. Continutul sau este decodificat si transmis sectiunii de generare comenzi / verificare stari din CP. In RI se pastreaza informatii necesare pentru selectia registrelor generale in functie de instructiunea in curs de executie.
* ``Magistrala MAG:`` interconecteaza resursele CD si constituie suportul fizic de comunicatie intre aceste resurse. Dimensiunea MAG este de 16 biti si este formata din 16 linii de interconectare, fiind in totalitate pasiva.
* ``AIE:`` intrucat subsistemul de intrare / iesire apare procesorului ca o memorie in care fiecare locatie reprezinta un port asociat unei interfete, ca si in cazul memoriei, este nevoie de un registru de adrese. Acesta va fi folosit pentru a stoca adresa portului cu care se doreste sa se comunice.

#### 2. Instructiuni logice si aritmetice

Unitatea aritmetica logica (UAL) realizeaza operatiile aritmetice si logice ale calculatorului didactic si este utilizata pentru prelucrarea de date si calculul adresei efective.
* ``Instructiuni Logice``
  - ``Logice:``
    - NOT (complement fata de 1 a operandului)
    - AND (efectueaza si logic intre bitii celor doi operanzi)
    - OR
    - XOR
    - TEST
  - ``Deplasare:``
    - SHL/SAL (deplasare logica/aritmetica la stanga)
    - SHR (deplasare logica la dreapta)
    - SAR (deplasare aritmetica la dreapta)
* ``Instructiuni Aritmetice``
  - ``Adunare:``
    - ADD (aduna cuvant)
    - ADC (aduna cuvant si transport)
    - INC (incrementeaza cuvant)
  - ``Scadere:``
    - SUB (scade cuvant)
    - SBB (scade cuvant cu imprumut)
    - DEC (decrementeaza cuvant)
    - NEG (schimba semnul)
    - CMP (compara cuvant)

#### 3. Moduri de adresare
* ``Operandul nu se afla in memorie``
  - Adresare directa:
    - operandul se afla intr-unul din registrii generali
    - MOV RA, RB
  - Adresare imediata:
    - operandul este specificat in instructiune
    - MOV RA, 7
* ``Operandul e specificat doar prin deplasament``
  - Adresare directa:
    - adresa efectiva este specificata in instructiune
    - MOV RA, [7]
  - Adresare indirecta:
    - adresa efectiva se citeste din memorie, din locatia a carei adresa este specificata in instructiune
    - MOV RA, [[7]]
* ``Operandul e specificat prin registre``
  - Adresare indirecta prin registru:
    - adresa efectiva se gaseste intr-unul din registrii BA, BB, XA, XB
    - MOV RA, [BA]
  - Adresare indirecta prin suma de registrii:
    - adresa efectiva se gaseste prin insumare de registru baza cu registru index
    - MOV RA, [BA + XA]
  - Adresare indirecta prin suma de registrii cu autoincrementare
    - MOV RA, [BA + XA +]
* ``Operandul e specificat prin registre si deplasament``
  - Adresare indirecta bazata
  - Adresare indirecta indexata
  - Adresare indirecta bazata si indexata:
    - MOV RA, [BA + XA + depls]

#### 4. Indicatorii de conditie

IND este un registru ce reprezinta un grup de bistabili cu functii individuale, pozitionati la executia instructiunilor in functie de rezultatul din UAL. Acesti indicatori sunt:
* ``T (transport):``
  - setat pe 1 daca in urma unei adunari rezulta un transport dinspre rangul cel mai semnificativ
  - setat pe 1 daca in urma unei scaderi rezulta un imprumut in cel mai semnificativ bit al rezultatului din UAL
* ``S (semn):``
  - setat la valoarea bitului cel mai semnificativ al rezultatului din UAL
* ``Z (zero):``
  - setat pe 1 daca rezultatul din UAL este 0
* ``P (paritate):``
  - setat pe 1 daca rezultatul din UAL contine un numar par de biti egali cu 1
* ``D (depasire):``
  - setat pe 1 daca rezultatul din UAL e un numar pozitiv prea mare sau un numar negativ prea mic

Instructiunile care afecteaza indicatorii de conditie sunt:
  * Aritmetice: ADD, ADC, INC, SUB, SBB, DEC, NEG
  * Logice: AND, OR, XOR, NOT, SHL, SHR, SAR

#### 5. Clasificare memorie

* ``Memorii tampon:`` foarte rapida formata din registrele interne ale unitatii centrale de prelucrare si eventual din memorii "cache" de asemenea continute in unitatea centrala de prelucrare, utilizate pentru a memora instructiunile sau datele care urmeaza sa fie utilizate imediat. Memorarea informatiilor in acest tip de memorii se realizeaza in avans. Aceste memorii sunt de mica capacitate, dar au un timp de acces foarte mic.
* ``Memoria principala a calculatorului:`` este in legatura directa cu unitatea centrala de prelucrare si este o memorie cu acces rapid avand in general o capacitate cu aproximativ un ordin de marime mai mare decat marimea tampon.
* ``Memoria auxiliara (externa):`` este realizata pe baza unor echipamente periferice de tip disc sau banda magnetica, cu capacitate mare de memorare. Se considera ca memoria auxiliara face parte din subsistemul de I/E.

#### 6. Modalitati de transfer date de intrare/iesire

Interfetele de I/E realizeaza adaptarile necesare intre unitatea centrala de prelucrare si echipamentele periferice asigurand si o oarecare independenta functionala a echipamentelor periferice prin degravarea unitatii centrale de prelucrare de anumite functii aferente controlului acestora. Modalitatile de transfer date de I/E sunt:

* ``Transfer programat:`` fiecare cuvant transferat implica participarea unitatii centrale de prelucrare, prin executarea unei secvente de instructiuni reprezentand programul de I/E specific
* ``Acces direct la memorie:`` cuvintele de transferat nu mai trec prin UCP ci sunt transferate direct intre memorie si echipamentele periferice
* ``Canal de I/E:`` un procesor specializat capabil sa execute programe de canal scrise intr-un limbaj masina specializat in operatiile de I/E
* ``Calculator specializat pentru I/E``

#### 7. Resursele principale ale unei interfete de I/E

Are patru componente:
* Registru de date
* Registru de stare
* Registru de comanda
* UC a interfetei

Deobicei un dispozitiv are alocate 3 porturi: unul de date, unul de comenzi si unul de stare.
Prin intermediul portului de stare se trimit si se primesc date de la dispozitiv. Acestea sunt dependente de dispozitiv si ar putea reprezenta datele scrise de o imprimanta sau datele primite de un port serial.
Prin intermediul portului de comenzi se trimit in principal comenzi catre dispozitiv. Acestea pot reprezenta comenzi de pozitionare a capului de citire pentru imprimanta sau de configurare a parametrilor de transmisie pentru un port serial.
Prin intermediul portului de stare se citesc informatii despre starea dispozitivului, care pentru o imprimanta ar putea semnala programului din calculator starea capului de scriere si a tavii de hartie.

#### 8. Principiul de functionare a sistemului de intreruperi
Elementele periferice (EP) sunt mult mai lente decat unitatea centrala de prelucrare (UCP), dar UCP nu trebuie sa il astepte (poate face alte prelucrari in acest timp). Cand EP termina, da o intrerupere la UCP si se trece la rutina de tratare a intreruperii. Aici se afla toate registrele de care este nevoie, sunt trimise in stiva si se verifica daca este operational.
Rutina de tratare a sistemului de intrerupere:
* Salvare context (prin push in stiva a contextului)
* Tratare
* Refacere context (prin pop din stiva a contextului)

#### 9. Caracteristicile principale ale interfetei seriale

Protocol: START - STOP (BIT = 1 STOP, BIT = 0 START), pentru a stii sa transmitem sau nu

Semnale standard:
* DS, DT - spun ca terminalul este operational
* RTS - cere o transmisie
* L1, L2 - ne anunta pe cat transmitem
* ACTINT - activare intreruperile
* RESINT - reseteaza intreruperile
* RESER - reseteaza interfata seriala (cand nu e bitul de paritate avem eroare)
* TxRDY - cand se transmit toti bitii
* RxRDY - iau toti bitii din buffer cand se umple
* OE - overrun error
* FE - nu a venit bitul de stop
* RE - eroare de printare (par/impar)
* STP - 1 sau 2 biti de stop (programat)

Vitea: transferul de date intre EP si calculator are dezavantajul ca necesita interfete complexe si limiteaza viteza de transfer

Nivele de semnal: semnalele ce se transmit pe liniile de date sunt sub forma unor nivele de tensiune in logica negativa:
  - 1 pentru -6V; -12V
  - 0 pentru 6V; 12V
