# Periodensystem der Elemente – interaktiv

Eine eigenständige HTML-App (`index.html`, keine Abhängigkeiten, läuft offline).

## Funktionen
- Alle 118 Elemente, farbig nach Elementgruppe
- Klick auf ein Element: Die Kachel dreht sich um, eine vergrößerte Detailkarte zeigt:
  Atommodell (animiertes Bohr-Modell **oder** Orbitalschema), Elektronenkonfiguration,
  Atommasse, Schmelz- und Siedepunkt (°C und K), Elektronegativität,
  Entdecker, Datum der Entdeckung, wichtige Verbindungen
- Suche nach Name, Symbol oder Ordnungszahl (Enter öffnet das Element)
- Gruppen-Filter über die Legende
- Temperatur-Slider: zeigt, welche Elemente fest, flüssig oder gasförmig sind
- Hell-/Dunkel-Modus (wird gespeichert; per URL erzwingbar: `?theme=light` / `?theme=dark`)
- Tastatur: Pfeiltasten ← → blättern in der Detailkarte, Esc schließt sie

## Einbinden in WordPress
Am einfachsten per `<iframe>` in einem Block „Individuelles HTML“:

```html
<iframe src="URL-ZUR-INDEX.HTML" title="Periodensystem der Elemente"
        style="width:100%;height:900px;border:0;border-radius:12px" loading="lazy"></iframe>
```

Das iframe hält das Design der App und das deines Themes sauber getrennt.

## WordPress-Plugin (empfohlen)
Im Ordner `wordpress-plugin/` liegt ein fertiges Plugin:

1. `wordpress-plugin/periodensystem.zip` in WordPress hochladen
   (Plugins → Installieren → Plugin hochladen) und aktivieren.
2. Auf einer beliebigen Seite den Shortcode einfügen: `[periodensystem]`
   - Standard: volle Seitenbreite, Höhe passt sich automatisch an
   - Optional: `[periodensystem breite="inhalt" theme="hell"]`
     (breite: `voll` oder `inhalt`, theme: `hell` oder `dunkel`)

Nach Änderungen an `index.html` mit `wordpress-plugin/build.sh` die ZIP neu bauen.
