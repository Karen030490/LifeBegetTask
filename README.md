
## Project Run

In order to test the project run the following commands

- change the DB creadentials in your side in '.env' file.
- php artisan migrate
- php artisan serve


## Cronjob configuration

 - `crontab -e`
 - copy past the following cron command in cronjob
`* * * * * cd {path_to_your/project/directory}} && php artisan schedule:run >> /dev/null 2>&1
 `
 - Please note : you need to change the project path
 - Note please make sure php is avalilable from that directory, otherwise put the real path to the php also
