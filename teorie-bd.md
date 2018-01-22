1. Componente DBMS

	* DDL (Data Definition Language)
		- Permite crearea structurii unei BD, structurii tabelelor si a relatiilor dintre acestea
		- CREATE, ALTER, DELETE TABLE (DDL este netranzictionala (AUTOCOMMIT); o instr corecta are ca efect executia in BD)

	* DML (Data Manipulation Language)
		- Prelucrarea BD si formularea de cereri (interogari)
		- Implementeaza op. ale algebrei relationale (instr. generica SELECT - vizualizare BD in mod read)
		- Structura declarativa, NU procedurala
		- Tranzactionala, instr poate fi revocata: INSERT, UPDATE, DELETE, MERGE (INSERT + UPDATE)

	* VDL (View Data Language)
		- Permite crearea de vederi
		- Vederea similara cu tabelele dar nu este pastrata in BD ca tabela, ci ca definitie
		- In view pot aduce date procesate din BD fara a scrie interogari
		- View -> metoda de securizare BD

	* SDL (Store Data Language)
		-	Comp invizibila utilizatorului
		- Stocarea BD folosind resurse ale SO
		- Precizeaza modul in care este stocata BD pe mem externa
		- tabel=fis. secvential; accesul se face bloc cu bloc(lent)
		- TABLESPACE, EXTEND, SEGMEN, BLOC

	* DCL/DBA (Data Control Language)
		- Specifica rolurile si permisiunile utilizatorilor
		- Utilizata de administratorii BD

2. Particularitati ale BD distribuite (caracteristici)

	*	Spatii de stocare si procesoare multiple, memorie extinsa;
	*	Inglobeaza comp eterogene si in acelati timp autonome;
	*	Date stocate in locatii diverse;
	*	Independenta de o locatie unica;
	*	Utilizatorii nu cunosc locul de stocare;
	*	Au un singur punct de defectare;
	*	Independenta de fragmentare;
	*	Indep de platforma soft;
	*	Indep de hardware;
	*	Indep de alocare;
	*	Redundanta minima si controlata.
	* Tipuri:
		-	omogene: acelasi DBMS la fiecare site
		-	eterogene: diverse DBMS pe siteuri.
	* Implementari:
		-	servere colaborative;
		-	middleware system;

3. Constrangeri (Tipuri, Declarare, descriere) definire si manipulare

	O buna definire a unei BD trebuie sa surprinda relatiile intre tabele si restrictiile privind valorile posibile pentru anumite campuri. Acest obiectiv e atins prin specificarea constrangerilor de integritate.
	Tipuri de constrangeri:
	* Primary Key
		- Un camp sau o asociatie de campuri reprez PK
		- O tabela are un singur PK; se recomanda ca fiecare tabela sa aiba PK
		- PK cheie candidata
		- [CONSTRAINT ntabela_PK] Primary KEY (camp(uri))
	* Foreign Key
		- Un camp este cheie straina si refera o cheie primara a altei tabele sau unique;
		- [CONSTRAINT tabela_FK] REFERENCES tabelaParinte(iddep) FOREIGN KEY(iddep)
	* Not NULL
		- Valoarea campului nu poate fi NULL la nicio inregistrare
	* UNIQUE
		- Impusa oricarui camp prin care nu se accepta valori, diferite de NULL, identice
	* CHECK
		- Valorile posibile ale unui camp (ex: anStudiu integer check(anStudiu between 1 and 4))

4. Operatii unare

	* Se aplica unei singure relatii
	* SELECT
		- Rezultatul contine aceleasi atribute cu relatia initiala
		- Este comutativa
	* PROJECT
		- Selecteaza acele coloane ce corespund listei de atribute specificate
		- Nu este comutativa

5. Relatii/Operatii binare
	* Se aplica asupra a doua relatii:
	*	REUNIUNEA
		- cele 2 relatii trebuie sa aiba acelasi tip de n-upluri conditie (compatib. reuniunii)
		- rezultatul include toate n-uplurile ce sunt in cele 2 multimi fara duplicate
	*	INTERSECTIA
		- rezultatul cuprinde doar n-uplurile ce se gasesc in ambele multimi
	*	DIFERENTA
		- n-uplurile ce se gasesc in multimea din care scadem si nu se gasesc in a2a
	*	PRODUS CARTEZIAN
	 	- se combina fiecare n-uplu a lui R cu fiecare n-uplu a lui S
		- rezultat = R x S => nR * nS n-upluri
	*	JOIN:
		- combinarea n-uplurilor din doua relatii intr-o singura relatie.
		- impune suplimentar o cond de JOIN
		- atribute cu acelasi nume => NATURAL JOIN
		- permite construirea de noi relatii pe baza celor existente;
	* JOIN ADITIONAL:
		- left: pastreaza in rez toate n-uplurile din membrul stang
		- right: ---------------------||---------------- drept
		- full.

6. Tranzactii in BD distribuite si centralizate
Tranzactia este succesiune de operatii SQL-DML care poate fi incheiata prin scrierea in baza sau revocata.
Aceasta poate fi:

  * CENTRALIZATA
		- Inainte de COMMIT (scriere in BD) o tranzactie poate fi revocata partial sau total
		- Toate tranzactiile nefinalizate sunt facute automat COMMIT
		- Intrerupere alimentare => sistemul face ROLLBACK(revocare & deblocare)
		- DBA si DDL nu pot fi vazute ca tranzactii si nu pot fi revocate
		- Se respecta proprietatile ACID:
			- Atomicitate (nu poate fi descompusa)
			- Consistenta (BD isi pastreaza consistenta)
			- Izolare (tranzactia este independenta/izolata)
			- Durabilitate (o tranzactie este durabila)
		- SAVEPOINT - maracrea pct de revenire (ROLLBACK TO [SAVEPOINT] nume);

  * DISTRIBUITE
		-	Tranzactia include una sau mai multe instructiuni care modifica date in doua sau mai multe noduri distincte ale BD distribuite
		- Operatii DML, DDL permise: CREATE TABLE AS SELECT, DELETE, INSERT, LOCK TABLE, SELECT, SELECT FOR UPDATE
		-	Pentru control sunt utilizate COMMIT, ROLLBACK, SAVEPOINT
		-	Arbori de sesiune al nodurilor participante la tranzactie (model ierarhic - descrie relatia dintre sesiuni si rolul lor)
		-	Mult mai complexe decat cele locale
    - Tranzactii in  2 faze (two-phase commit):
				- prepare: nodul initiator cere altor noduri sa asigure commit sau rollback tranzactiei
				- commit: nodul initiator cere tuturor participantilor sa comita tranzactia, daca nu se poate se cere rollback

7. Tipuri de subcereri utilizate
Subcererile intorc:
	* O singura valoare:
	```SQL
	SELECT Nume, Prenume FROM Angajat, Lucreaza
	WHERE Angajat.cnp=Lucreaza.cnp and Ore LIKE (SELECT Max(Ore) From Lucreaza)
	```
	* O coloana (ca o multime):
	```SQL
	SELECT Nume, Prenume FROM Angajat, Lucreaza
	WHERE Angajat.cnp=Lucreaza.cnp and P_nr
	IN (SELECT P_nr FROM Proiect WHERE D_nr=3)
	```
	* O tabela:
		- se utilizeaza operatorul IN astfel WHERE(lista_expr)IN(subcerere)
		- subcereri in HAVING
		- in clauza FROM (tratata ca o tabela temporara)
		- subcereri corelate: rezultatul este dependent de val liniei curente.
		- in clauza  ORDER BY: subcereri corelate ce intorc o singura valoare.
		- pe clauza SELECT: intorc o singura valoare

8. View (Definire si modificare)

	VIEW:
	- Obiecte stocate in BD nematerializate (sunt stocate ca definitie)
	- Similare tabelelor, create ca view si construite pe baza datelor din BD
	- Invocare view determina executarea cerearii SQL => recalcularea vederii => actualizare date
	- Nu definim constrangeri de integritate; sunt doar mostenite de la tabele
	- Definire modalitati de acces date (read only)

	Sintaxa:
	```
	CREATE [OR REPLACE|FORCE|NOFORCE] VIEW Numeview[(lista col)] AS subcerere
	[with check option [constraint Numeview]]
	[with read only [constraint Nume_constrangere]]
	```
	Unde:
		- lista col - coloanele din view
		- OR REPLACE - vederea cu numele asta daca exista este inlocuita
		- FORCE|NOFORCE (default NOFORCE) - la creearea unui view se verifica existenta elementelor invocate. NOFORCE nu face verificarea, se salveaza definitia, dar va genera eroare.
		- with check option - impiedica efectuarea de modificari in BD daca liniile nu sunt regasite prin cererea asociata. (similara cu o constrangere)
		- with read only - nu sunt permise modif ale datelor in view.
		- view nu poate fi revocata prin ROLLBACK deaorece este o cerere DDL

9. Dependente functionale (FD), normalizare (BD):

	* Functionale
		- Se exprima ca o restrictie intre 2 seturi de atribute intr-o BD
		- Se defineste intre subsetul de atribute ale unei relatii indicand faptul ca un subset al atributului este functional dependent de alt atribut
			- Reguli de inferenta (judecata, rationament):
				- Regula de reflexivitate: daca ```X ? Y => FD Y->X```
				- Regula de argumentare: daca ```FD X->Y``` se poate deduce ```FD Xz->Yz si FD Xz->Y```
				- Regula de tranzitivitate: ```FD1 X->Y``` si ```FD2 Y->Z``` ```=>FD3 X->Z```
				- Regula de decompozitie: ```FD X->(A1,A2...An)``` ```=> FD1: X->A1; FD2:X->A2 ..FDn: X->An.```
				- Regula de pseudotranzitivitate:```FD1:X->Y``` ```FD2:YZ->U ==>FD:XZ->U```
				- Regula de reuniune: ```FD1: X->Y, FD2:X->Z ==> FD:X->YZ.```

	* Normalizare
		- Descompunerea schemelor intr-un set de relatii ce satisfac Formele normale
		- Relatie
			- atribut cheie (prime)
			- de descriere (nonprime)
		- Forma normala ofera un schelet formal pentru analiza schemelor bazate pe chei si FD intre atribute
		- FORME:
			- FN primara (FN1): aduce cateva restrictii privind constructia unei scheme relationale. Nu permite relatii in relatii sau relatii ca atribute ale n-uplurilor.
			- FN secundara (FN2): conceptul dependentei functionale complete
				- FD X->Y COMPLETA daca eliminarea oricarui atribut A din X distruge dependenta functionala
				- Daca o relatie nu contine doar dep fct complete ea se normalizeaza prin descompunere in mai multe relatii ce asigura FD completa
			- FN ordin3 (FN3): dependenta functionala tranzitiva

10. Secvente
	- Sunt pastrate in BD, specifica succesiuni de valori ce difera prin pasul de modificare pentru 2 valori succesive.
	- Pot specifica valori de inceput a secventei, valori max, valori min, daca secventa cicleaza
	- SINTAXA:
	```
	CREATE SEQUENCE numesecv
	[INCREMENT BY pas] 				-->pasul poate fi negativ
	[START WITH valinitiala]
	[MAXVALUE valmax]
	[MINVALUE valmin]
	[CYCLE|NOCYCLE] 				   -->ciclarea la atingerea val max sau min;
	[CACHE nrval |NOCACHE] 			-->specif nr urmatoarelor valori calculate.
	```

	- Referirea la secventa se face prin CURRVAL, NEXTVAL
	- Se poate modif prin ALTER SEQUENCE numesecv ...
	- Stergere secventei DROP SEQUENCE numesecv; nu poate fi revocata prin ROLLBACK

11. INDECSI:
	- Indexarea este o metoda de acces logic
	- Structura de cautare rapida utilizata pentru cresterea vitezei de evaluare a cererii;
	- SINTAXA:
	```
	CREATE INDEX numeindex ON tabela (col1 [criteriu], col2[criteriu])
	```
	- Stergere DROP INDEX numeindex
	- Cu autoincrementare
	- Tipuri de indecsi:
		- Index primar realizat pe baza unui atribut cheie la o tabela ordonata dupa campul cheie
		- Index secundar este construit dupa un camp cheie al tabelei de date, insa tabela nu este ordonata dupa acest camp
		- Index de grup
		- Index multinivel atunci cand indexul se trateaza similar cu o tabela la care se construieste index in continuare

12. Indecsi multinivel cu arbori B si B+

	* Arbori B
	Un arbore B de ordin p, construit dupa un camp cheie al fisierului index satisface urmatoarele restrictii:
		-	Fiecare nod intern in arborele B are structura ```<P1,<K1,Pr1>,P2,<K2,PR2>,...,<Kp-1,Prq-1>,Pq>```
			-	cu q<=p, in care Pi este un pointer la un nou nod arbore numit si pointer arbore
			- Pri (pointeri data), pointer catre blocuri in tabela de date ce contin intregistrarea cu cheia K
		- In fiecare nod e indeplinita conditia K1<K2<...<Kq-1
		- Fiecare nod are cel mult p pointeri arbore
		- Fiecare nod exceptand radacina si nodurile frunza au cel putin [p/2] pointeri arbore. Nodul radacina are cel putin doi pointeri
		- Un nod cu q pointeri arbore, q<=p, contine q-1 valori ale campului de indexare, deci q-1 pointeri data
	* Arbori B+
		- Fiecare nod intern are structura ```<P1,K1,P2,K2m,...,Pq-1,Kq-1,Pq>```
		- In fiecare nod este indeplinita conditia K1<K2<...<Kq-1, q<=p
		- Fiecare nod intern are cel mult p pointeri arbore
