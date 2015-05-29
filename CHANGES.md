Kakalika Changelog
===================

v0.2.1 - 29th May, 2015
-----------------------
- Users can now watch or unwatch specific issues
- Email addresses cc'd in mails sent to kakalika are automatically made watchers
- Added support for SQLite database
- Issues with missing menus in UI fixed

v0.2.0 - 7th April, 2015
------------------------
- Added support for PostgreSQL database.
- Switched database schema management to the yentu migration tool.
- Organized packages with composer and dropped all git submodules.
- Reworked the user interface. The Create Issue button has been made much more
  consistent and appears everywhere in the application. The issue list has
  also been paginated now.
- Added email integration to allow incorporation of emails into issue management
  workflow. Currently users can send emails to kakalika to create new issues.
  Kakalika handles all attachments and alerts users of changes to issues via
  email.
- A couple of bug fixes.

v0.1.5 - 24th February, 2014
---------------------------
- Added support for attachments on issues and comments.
- Added support for milestones.
- Issues can now be categorized into Components.
- Added a simple sorting function so issues can be sorted on just one property.
- XSS security fixes.
- Projects can now be clicked on the dashboard.
- Forms for capturing issues have been restyled.
- Administration section has been restyled.
- Improved the colour schemes and made them uniform accross the UI. 


v0.1.0 - 18th October, 2013 
---------------------------
First Public Release
