# TODO: Fix Edit Game 400 Bad Request Bug

## Current Status
- Error: 400 Bad Request when fetching game data for editing
- Root cause: Routing strips query string parameters like ?id=7
- App.php parseURL() only handles 'url' parameter, other GET params lost

## Completed Tasks
- [x] Modify public/.htaccess to remove 'url' param and add QSA
- [x] Update app/core/App.php parseURL() to parse REQUEST_URI directly
- [x] Update public/assets/js/admin.js fetch URLs to remove '?url='
- [x] Add debug info to error responses (already in getGame())

## Pending Tasks
- [ ] Test the fix with manual URL testing
- [ ] Verify JavaScript fetch works correctly
