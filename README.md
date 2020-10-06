# XenForo 2 User Date/Time Format Settings

Allows users to override the language-level date and time format settings.

Adds two new User Custom Fields:

1. Preferred Date Format
    - All (non-custom) formats from the admin panel
    - Full-year m/d/y and d/m/y formats
    - ISO 8601 YYYY-MM-DD format
2. Preferred Time Format
    - 12 and 24 hour formats

They are both optional and apply individually. A user who does not select an option will get the setting defined in their selected language for that field.

If you do not wish to allow selection of both options then the relevant custom field can be disabled or removed. In addition, specific options can be removed from the user fields as well without causing problems.

To add new options, the code of the extension will need to be edited as the list of potential format strings is hardcoded. This is due to how multiselect options function, the format string can't be the option value directly and thus needs an option to format string mapping.

Both fields default to on for user registration, as Date/Time formats can be very important to users. This can be safely toggled off in the custom user field settings if that isn't desired.
