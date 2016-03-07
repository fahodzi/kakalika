Kakalika Changelog
===================

v0.3.0 - 2015-12-10
-------------------



v0.2.2 - 2015-06-09
-------------------
- Improved email support
- Relaxed database validation rules for issues to make it easy to add new issues
- Removed debug calls from application

v0.2.1 - 2015-05-29
-------------------
- Users can now watch or unwatch specific issues
- Email addresses cc'd in mails sent to kakalika are automatically made watchers
- Added support for SQLite database
- Issues with missing menus in UI fixed
- A few improvements to Kakalika installer

v0.2.0 - 2015-04-07
-------------------
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

v0.1.5 - 2014-02-24
-------------------
- Added support for attachments on issues and comments.
- Added support for milestones.
- Issues can now be categorized into Components.
- Added a simple sorting function so issues can be sorted on just one property.
- XSS security fixes.
- Projects can now be clicked on the dashboard.
- Forms for capturing issues have been restyled.
- Administration section has been restyled.
- Improved the colour schemes and made them uniform accross the UI. 


v0.1.0 - 2013-10-18 
-------------------
First Public Release
