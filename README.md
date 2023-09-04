Voláno při instalaci, odinstalaci nebo dočasného vypnutí doplňku ze Shoptetu
za URL musí přijít ještě parametr ?addon=<nazev_doplnku> //např. konfigurator:
- addon-install
- addon-paused
- addon-uninstall
- addon-unpaused

Nastavení databáze a hodnoty, které mají být "globálními":
- settings.php

Adresář Functions -
- Funkce pro práci s databází, vyhledávání, zadávání: database.php
- Získání access tokenu:
    - Při instalaci dostaneme oauth access token, ten je trvalý a ukládáme ho v databázi v tabulce shoptet_api
tento kód pak využíváme pro zavolání dočasného přístupového tokenu do Shoptetu, lze vygenerovat maximálně 5 v časovém rozmezí, proto token ukládáme v databázi dokud je platný a odkazujeme se na něj, pokud kód vyprší, tak funkce žádá o nový: getAccessToken.php
- Funkce pro získání dat ze Shoptetu pomocí access tokenu: getData.php
- Funkce pro zadání dat do Shoptetu pomocí access tokenu: (chybí)

Adresář action - Tahle složka už je finální, která by měla všechno zavolat
- GET - dotazujeme se POSTem a posíláme v POSTu hodnoty: URL z dokumentace Shoptet API, eshopId, type (nazev doplňku, např. konfigurator): get.php
- POST: (chybí)

Adresář logs - Zde se ukládají chyby (zatím tam jsou jen chyby vzniklé při instalaci, odinstalaci nebo pauzování doplňku)


Před spuštěním je potřeba upravit:
- settings.php
- addon-install.php - tam je id a secret k Shoptet API partner a pak i URL kam se vrací, to musí odpovídat tomu, kde je nahrán soubor addon-install.php
