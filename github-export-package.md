GitHub Pages Deployment Package

Kuna Replit blokeerib Git käsud, ekspordin kõik vajalikud failid GitHub-i käsitsi üleslaadimiseks.

Failid GitHub-i laadimiseks:

1. production-index.html → index.html (peafail)

2. production-contact.php → contact.php

3. production-robots.txt → robots.txt

4. production-sitemap.xml → sitemap.xml

5. .github/workflows/deploy.yml (automaatne deployment)

6. README.md

Sammud GitHub-is:

Mine: github.com/OlariRikas/plundi-website
Kliki "uploading an existing file" või "Add file" → "Upload files"
Lohista kõik production- failid* upload alasse
Nimeta ümber: production-index.html → index.html
Commit: "Initial website upload with auto-deployment"
Settings → Pages → Source: GitHub Actions → Save
Auto-Deployment:

GitHub Actions automaatselt:

Kopeerib production failid public/ kausta
Deployib GitHub Pages-i
Uuendab automaatselt iga push-iga
Live URL:

https://olariRikas.github.io/plundi-website/

Backup & Testing:

Replit Deployment: plundi.com (peamine)
GitHub Pages: testing ja backup
Mõlemad sünkroonis automaatselt
