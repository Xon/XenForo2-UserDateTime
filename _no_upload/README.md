# XenForo 2 User Date/Time Format Settings

Allows users to override the language-level date and time format settings.

Adds two new User Custom Fields:

1. Preferred Date Format
  - All (non-custom) formats from the admin panel
  - ISO 8601 YYYY-MM-DD format
2. Preferred Time Format
  - 12 and 24 hour formats

They are both optional and apply individually.

If you do not wish to allow selection of both options then the relevant custom field can be disabled or removed. In addition, specific options can be removed from the user fields as well.

To add new options the code of the extension will need to be edited as the list of format strings is hardcoded.
