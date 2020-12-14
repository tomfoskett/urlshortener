# urlshortener
A basic url shortener

## Setup
To set up the urlshortener app:

1. Create a new database and user with the name of your choice
2. Update the values on lines 6-9 in App/Database.php to match your new database
3. Run the SQL command below to create the database table
4. You're good to go!

### SQL Query
```CREATE TABLE `short_urls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `short_code` varchar(11) NOT NULL,
  `long_url` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
);```
