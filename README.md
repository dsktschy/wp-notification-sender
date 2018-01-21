# WP Notification Sender
WP Notification Sender is a WordPress plugin.  
It sends a post request when post status transitions.  
Set target URLs on "Settings" > "Writing" > "Update Services".  
And add the following style to CSS for admin pages.
```css
/* Adjust the margins and paddings */
.wpns-description + .form-table > tbody > tr > td {
  padding: 0 !important;
}
/* Hide the table header of WP Notification Sender */
.wpns-description + .form-table > tbody > tr > th {
  display: none !important;
}
```
