# TODO: Fix BASEURL and Routing Issues

## Approved Plan
- Update app/config/config.php: Change BASEURL from 'http://localhost:8000/' to '/'
- Update app/core/App.php: Set $basePath = '' to not remove any path from URL
- Ensure public/.htaccess is correct for routing
- Create public/debug.php for troubleshooting server variables and routing
- Create root .htaccess to redirect /catalog-game/ to /catalog-game/public/ if needed

## Steps
- [x] Update config.php
- [x] Update App.php
- [x] Verify public/.htaccess
- [x] Create debug.php
- [x] Create root .htaccess
- [ ] Test the changes
