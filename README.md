1) Create MySQL DB
------------------
*  `mysql -u root -p`
*  `CREATE DATABASE foodev CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;`
*  `GRANT ALL PRIVILEGES ON foodev.* TO foodev@localhost IDENTIFIED BY 'm00dlef00dev';`

2) Create moodle data folder
----------------------------
*  `mkdir /moodle_assets/data_foodev`
*  `chmod 777 /moodle_assets/data_foodev/`

3) Install Moodle
-----------------
Installation folder: /var/www/html/electronics/repos/foo-dev

Installation Info:
*  admin username: acharitop
*  admin password: Foodev2013@

After installation: 
`chown -R root foo-dev/ && chmod -R 775 foo-dev/`

4) Install cronjob
------------------
*  `crontab -u apache -e`
*  Add the following line: `*/15 * * * * /usr/bin/php  /var/www/html/electronics/repos/foo-dev/admin/cli/cron.php >/dev/null`

5) Add code to git repo
-----------------------
*  `cd /var/www/html/electronics/repos/foo-dev`
*  `git init`
*  `git add .`
*  `git commit -m "Clean Moodle 2.5 Stable Installation"`
*  `git remote add origin https://github.com/acharitop/foo-dev.git`
*  `git remote set-url origin ssh://git@github.com/acharitop/foo-dev.git`
*  `git push -u origin master`

SSH pashphrase: acharitop

6) Configuration
----------------

Student Types
+-------------+---------+
| Grade       | Type    |
+-------------+---------+
| [0.0, 2.5]  | A       |
| (2.5, 5.0]  | B       |
| (5.0, 7.5]  | C       |
| (7.5, 10.0] | D       |
+-------------+---------+


