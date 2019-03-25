# **Bibliotech** *Progetto biblioteca per l'I.I.S. Rosselli di Aprilia*

Come iniziare
-------------
Visto che probabilmente questa è la prima volta che usate GitHub, 
vi spiegherò velocemente come inizializzare tutto il necessario
per cominciare a programmare in gruppo utilizzando Git e Github.

 - Per prima cosa scaricare Git da questo url:
    [https://git-scm.com/downloads](https://git-scm.com/downloads).<br>
    Eseguire l'installazione per il proprio sistema operativo. Su Windows,
    l'installer installerà anche *Git Bash*.

Usare Git
---------
 + Git è un VCS (Version Control System), cioè un applicativo che ci
    permette di gestire diverse versioni del codice e di mantenere la storia
    delle modifiche che vi abbiamo apportato.<br>
 - Per fare ciò, in Git, i progetti si chiamano repository (repo), e si
    possono creare da terminale, con il comando **init**:
    ```
    mkdir progetto&&cd progetto
    git init
    ```

 - Una volta creata una repository, possiamo aggiungere qualsiasi file alla
    cartella e questo entrerà a fare parte del progetto. Per finalizzare l'aggiunta
    di un file, si usa il comando **add**
    ```
    touch esempio.txt
    echo "Testo di prova" > esempio.txt
    git add esempio.txt
    ```
 - Una volta aggiunto un nuovo file o modificato uno esistente, si può vedere la
    lista dei file modificati e non ancora aggiunti usando il comando `git status`
 - Per condividere le modifiche che effettuiamo al codice, dobbiamo creare le
    commit, una sorta di checkpoint per il nostro codice. Per farlo, prima aggiungiamo
    tutti i file che dobbiamo inserire nella commit con il comando add. <br>Se dobbiamo
    aggiungere tutti i file modificati possiamo utilizzare il comando `git add .`

 - Per evitare di scrivere `git add .` prima di ogni commit, possiamo aggiungere
    la flag *-a* al comando commit per eseguire l'aggiunta dei file modificati
    automaticamente:
    ```
    git commit -am "Messaggio"
    ```
 - Quando siamo pronti ad effettuare una commit, possiamo eseguire il comando:
    ```
    git commit -m "Aggiunto del testo al file di esempio"
    ```
    Per comprendere meglio le modifiche effettuate al codice, è sempre preferibile
    che alla commit sia affiancato un messaggio.

 + Probabilmente, la prima volta che avete provato ad eseguire una commit, vi avrà
    dato un errore. <br>Per risolverlo dovete identificarvi:
    eseguite i seguenti comandi con i vostri dati:
    ```
    git config --global user.name "Peppino Colgrugno"
    git config --global user.email "email@provider"
    ```

Creare un account GitHub
------------------------
Git può funzionare benissimo da solo, ma per permetterti di collaborare
con altri programmatori hai bisogno che la tua repository sia condivisa
e sempre accessibile. Per questo viene in nostro aiuto Github. 

*Github è un sito che permette di condividere repository create con Git.*

 - Per prima cosa dobbiamo creare un account su Github.<br>
    Non bisogna addentrarsi molto per trovare la funzione giusta (si trova
    proprio sull'[homepage](https://www.github.com)).<br>
    Inserire un nome utente, una password e un indirizzo e-mail (non devono
    essere uguali a quelli usati prima con Git)
 - Eseguire i passaggi richiesti (c'è anche un puzzle) e verificare il proprio
    account con l'indirizzo e-mail.
 - L'account dovrebbe essere pienamente funzionante adesso.

Connettersi via SSH
-------------------
La connessione ai server di Github avviene sempre tramite SSH e RSA per
garantire l'identità del mittente (il tuo computer) ed assicurarsi che
nessun impostore possa modificare il tuo codice senza permesso.

 - Aprire il prompt di comandi:
    + Se siete su Linux o su OS X, aprite il Terminale
    + Se siete su Windows, aprite Git Bash
 - Dobbiamo ora generare una chiave RSA. Per farlo utilizzeremo questo comando:
    ```
    ssh-keygen -b 4096
    ```
 - Premere invio finché non smette di chiedervi input.
 - Navigate sulla vostra cartella utente
    + `cd ~` su Linux
    + `cd C:\Users\[nomeutente]` su Windows
 - Navigate nella cartella .ssh
 - Copiate il contenuto del file `id_rsa.pub`.<br>
    Questa è la vostra chiave pubblica: potete darla a chi volete, ma
    state attenti a **non condividere mai id_rsa** senza il .pub, perché 
    quella è invece la vostra chiave privata e non va distribuita.
 - Tornate sul sito di github, andate in *Settings* e *SSH and GPG keys* e
    premete il pulsante *New SSH key*
    oppure utilizzate [questo link](https://github.com/settings/keys/new).
 - Dategli un nome che individui il dispositivo che state usando e incollate
    id_rsa.pub dentro la cassella di testo più grande.
 - Premete il pulsante verde per aggiungere la chiave ed ora dovreste aver
    collegato il vostro computer al vostro account GitHub.

 + Possiamo testare la connessione al server con il comando:
    ```
    ssh -T git@github.com
    ```
    Dovrebbe riportarvi il vostro nome utente:
    ```
    PTY allocation request failed on channel 0
    Hi PeppinoNgrugnito! You've successfully authenticated, but GitHub does not provide shell access.
    Connection to github.com closed.
    ```
 - Siete riusciti a connettervi al server di Github!

Modificare questo progetto
--------------------------
Siamo giunti al momento che stavate aspettando. Come cominicare a 
modificare questo progetto. Per prima cosa, dovreste contattarmi,
così che vi possa aggiungere alla lista dei collaboratori.

Quando vi avrò aggiunto, potrete accettare l'invito seguendo [questo
link](https://github.com/Cicim/bibliotech/invitations)

Intanto cominciate a scaricare il progetto
 - Scegliete una cartella sul vostro dispositivo dove tenere una copia locale
    del codice salvato su GitHub.<br>
    Navigate al suo interno ed eseguite il comando per *clonare* la repository:
    ```
    git clone git@github.com:Cicim/bibliotech.git .
    ```
 - Potete già cominciare ad effettuare le modifiche e ad eseguire dell commit,
    che però non saranno immediatamente visibili online.
 - Per il prossimo passo dovrete essere stati invitati da me, quindi fermatevi
    se ciò non è ancora avvenuto.
 - Se avete ricevuto ed accettato l'invito possiamo eseguire il comando per
    rendere visibili le nostre modifiche a tutti gli altri
    ```
    git push origin master
    ```
    Per non dover scrivere origin e master ogni volta, eseguite questo comando:
    ```
    git push --set-upstream origin master
    ```
    E poi potrete utilizzare sempre il comando `git push`.
 + Per fare l'opposto, cioè scaricare le modifiche che hanno effettuato gli altri,
    utilizzeremo il comando `git pull`

Fine
----
Se siete giunti senza intoppi fino a questo punto, è arrivata l'ora di lavorare
a questo progetto.

Qualche consiglio:
- Visto che si lavora con php, per provare velocemente il codice che stiamo scrivendo,
    inseriamo la repository clonata all'interno degli htdocs di XAMPP.
- Git si integra perfettamente con VS Code. Non dovete imparare tutti quei comandi,
    perché molto probabilmente VS Code li ripropone in veste grafica nel pannello
    di Source Control (Ctrl+Shift+G)
- **Non modificate questo file**<br>
    Al limite potete spostarlo in un altro posto.