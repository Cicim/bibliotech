/**
 * @author Claudio Cicimurri, 5CI
 * Funzione che trasforma gli elementi selezionati in
 * una combo box con ricerca funzionante
 * 
 * @param {HTMLDivElement} parent Il parent di input e dropdown
 * @param {HTMLInputElement} send L'input box alla quale inviare il risultato
 */
function combobox(parent, send) {
    const cb = parent.children();
    const inp = $(cb[0]);
    const dropdown = $(cb[1]);

    // Aggiungi i trigger necessari
    // Quando l'input box va in focus
    inp.focus(() => 
        // Mostra il dropdown
        dropdown.dropdown('toggle'));

    // Quando premi un tasto nella casella di testo
    inp.keydown(e => {
        // Se il tasto è esc o tab
        if (e.key == 'Escape' || e.key == 'Tab') {
            // Nascondi il dropdown
            dropdown.dropdown('toggle');
            // Togli il focus alla casella di testo
            inp.blur();
            // Ripristina i link cliccati
            cambiaLink('');
        }
    });
    // Quando rilasci un tasto sull'input
    inp.keyup(() => cambiaLink(inp.val()));

    // Quando hai caricato tutti i link
    // Aggiungi la funzione mousedown agli a
    parent.find('a').mousedown(e => {
        // Ottieni il link cliccato
        const link = $(e.target);
        // Ottieni id e descrizione
        const id = link.attr("value");
        const desc = link.text();
        console.log(id, desc);
        // Cambia la descrizione dell'input
        inp.val(desc);
        // Imposta il valore da inviare
        send.val(id);
    });



    function cambiaLink(input) {
        // Calcola il minuscolo dell'input
        input = input.toLowerCase();
        // Scorri attraverso tutti gli a
        parent.find('a').each(function () {
            // Ottieni l'elemento corrente
            const ja = $(this);
            // Mostralo
            ja.show();
            // Ottieni il suo testo
            const testo = ja.text().toLowerCase();

            // Se il testo non matcha la query, nascondi
            if (!testo.match(input))
                ja.hide();
        });
    }

    if(send.val()) {
        inp.val(dropdown.find('a[value=' + send.val() + ']').text());
    }
}