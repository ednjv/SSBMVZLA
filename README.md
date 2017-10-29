# SSBMVZLA

This application allows you to see all information about Smash Brothers Melee players in tournament from around Venezuela of which I have register since around 2007
  
## Features:

- Player details (name, nick, state, characters, titles won)
- Current year and career record in sets
- History of sets in tournaments
- Ranking based on the ELO system
- Images of bracket tournaments
- Position of players in tournaments
  
# Requirements
  
- Yii Framework v.1.1.16
- MySQL 5.X
- HTTP Server (Apache recommended)
- PHP >= 5.1.0
- PHP-curl extension
- Composer
  
# Set up

- Clone this repository
- Execute `cd protected/ && composer install`
- Import the .sql in your MySQL
- Serve your project over your HTTP Server
- Replace `.env` file values with the ones you need

# Common issues

- If you get a `Syntax error or access violation: 1055 Expression` follow these steps, edit your MySQL config file `/etc/mysql/conf.d/mysql.cnf` and paste the following at the end of the file:
```
[mysqld]
sql_mode=STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION
```
- If you get permission troubles for the `protected/runtime` folder or the `assets` folder, try to change the owner of those folders to the user that's running the HTTP Server, e.g `chown www-data assets/`


# Contributions

- Any PR is welcome :D
