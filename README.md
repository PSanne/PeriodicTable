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
