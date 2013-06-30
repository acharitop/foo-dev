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

### mdl_profile
* id : 1, name : profile_A, threshold : 0.00
* id : 2, name : profile_B, threshold : 2.50
* id : 3, name : profile_C, threshold : 5.00
* id : 4, name : profile_D, threshold : 7.50

### mdl_profile_sections
* profileid : 1
	* sectionid : 1, ordering : 1
	* sectionid : 2, ordering : 2
* profileid : 2
	* sectionid : 3, ordering : 1
	* sectionid : 4, ordering : 2
* profileid : 3
	* sectionid : 5, ordering : 1
	* sectionid : 6, ordering : 2
* profileid : 4
	* sectionid : 7, ordering : 1
	* sectionid : 8, ordering : 2
