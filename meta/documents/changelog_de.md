# Release Notes für IO

## v1.0.3 (2017-03-24)

### Hinzugefügt

- Filtermöglichkeit über Facetten
- Abruf von gerenderten Twig-Templates über REST
- Neue Twig-Funktionen: `trimNewLines` und `formatDateTime` 
- Neue Funktion im **CategoryService**: `getChildren()`
um Unterkategorien zu erhalten

### Geändert

- Aktualisierung und Erweiterung des Routings: Alte Shop-URLs können verarbeitet und in **Ceres** angezeigt werden. Die URL-Struktur wurde zudem optimiert von `/{itemName}/{itemId}/{variationId}` zu `/{category}/{subcategory}/.../{itemName}-{itemId}-{variationId}` 

## v1.0.2 (2017-03-06)

### Behoben

- Fehler beim Aufrufen der Kategorieansicht und der Artikel-Einzelansicht behoben.
- Fehler behoben, bei dem auch Artikel in einer Kategorie auftauchten, die mit dieser nicht verknüpft waren.
- Fehler behoben, bei welchem Routen von anderen Plugins von der 404-Route von IO überschrieben wurden.

## v1.0.1 (2017-02-22)

### Behoben

- Fehler beim Erweitern der Shop-Sprachen behoben. Wenn zusätzliche Sprachdateien im Ordner `resources/lang` [erstellt](https://developers.plentymarkets.com/dev-doc/template-plugins#design-lang) und per [Gulp kompiliert](https://developers.plentymarkets.com/dev-doc/template-plugins#gulp-ceres) wurden, wird das Template nun auch in der gewählten Sprache angezeigt.

## v1.0.0 (2017-02-20)

### Funktionen
**IO** bietet eine Vielzahl an Logikfunktionen für einen plentymarkets Webshop und dient als Schnittstelle zwischen plentymarkets und folgenden Webshop-Seiten:
- Startseite
- Kategorieansicht
- Artikelansicht
- Warenkorb
- Kasse (Checkout)
- Bestellbestätigung
- Login und Registrierung
- Gastbestellung
- **Mein Konto**-Bereich
- statische Seiten (z.B. AGB, Impressum etc.)

Außerdem bietet es eine Funktion um weiteren Content durch Layout-Container nachzuladen.
