-- Inserimento utenti di esempio
-- Password "admin" per ogni utente 
INSERT INTO Utenti (CodFiscale, Nome, Cognome, Email, ViaPzz, NumeroCivico,
    TelefonoCellulare, TelefonoFisso, Validato, CodiceValidazione, DataValidazione,
    Sesso, Password, Citta, DataNascita, Permessi) VALUES
    ('CODFIS00A00A000A', 'Mega', 'Galattico', 'megagalattico@amministratore.wow',
    '', 0, '', NULL, TRUE, 0, '2019-04-09',
    'N', '21232f297a57a5a743894a0e4a801fc3', 1, '2000-00-00', 0),
    ('CODFIS01B01B001B', 'Semplice', 'Bibliotecario', 'semplice@bibliotecario.wow',
    '', 0, '', NULL, TRUE, 0, '2019-04-09',
    'N', '21232f297a57a5a743894a0e4a801fc3', 1, '2000-00-00', 1),
    ('CODFIS02C02C002C', 'Semplice', 'Utente', 'semplice@utente.wow',
    '', 0, '', NULL, TRUE, 0, '2019-04-09',
    'N', '21232f297a57a5a743894a0e4a801fc3', 1, '2000-00-00', 2),
    ('CODFIS03D03D003D', 'NonValidato', 'Utente', 'unval@userbib.wow',
    '', 0, '', NULL, TRUE, 0, '2019-04-09',
    'N', '21232f297a57a5a743894a0e4a801fc3', 1, '2000-00-00', 3);