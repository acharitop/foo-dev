#! /usr/bin/env php
<?php
/**
 * Author © 2013 Angelos Charitopoulos
 * 
 * PHP Script that populates the DB Tables of our Moodle plugin
 */

/* Connect to DB */
$db_username = "root";
$db_password = "ChAgg2010@";
$db_host = "localhost";
$db_name = "foodev";

$db_handle = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error());
$selected = mysql_select_db($db_name, $db_handle) or die(mysql_error());
echo "Connected to DB\n";

/* Our Tables */
$course_settings_tbl = "mdl_foo_course_settings";
$profile_tbl = "mdl_profile";
$profile_sections_tbl = "mdl_profile_sections";
$student_profile_tbl = "mdl_student_profile";
$student_sections_tbl = "mdl_student_sections";

/* Initialize  Variables */
$courseID = 3;
$profiles = array(
  array(
    "name" => "profile_A",
    "threshold" => 0.00,
    "sections" => array(1, 2),
  ),
  array(
    "name" => "profile_B",
    "threshold" => 2.50,
    "sections" => array(3, 4),
  ),
  array(
    "name" => "profile_C",
    "threshold" => 5.00,
    "sections" => array(5, 6),
  ),
  array(
    "name" => "profile_D",
    "threshold" => 7.50,
    "sections" => array(7, 8),
  ),
);
$truncate = true;

/* Truncate Plugin Tables */
if ($truncate) {
  $q = "TRUNCATE `{$course_settings_tbl}`";
  mysql_query($q) or die(mysql_error());
  $q = "TRUNCATE `{$profile_tbl}`";
  mysql_query($q) or die(mysql_error());
  $q = "TRUNCATE `{$profile_sections_tbl}`";
  mysql_query($q) or die(mysql_error());
  $q = "TRUNCATE `{$student_profile_tbl}`";
  mysql_query($q) or die(mysql_error());
  $q = "TRUNCATE `{$student_sections_tbl}`";
  mysql_query($q) or die(mysql_error());
}

echo "Initializing tables for course : {$courseID}\n";

$query = "
  SELECT 
    t1.`instance`
  FROM
    `mdl_course_modules` AS t1 
    JOIN `mdl_modules` AS t2 
      ON t1.`module` = t2.`id` 
    JOIN `mdl_course_sections` AS t3 
      ON t1.`section` = t3.`id` 
  WHERE t2.`name` = 'quiz' 
    AND t3.`section` = 0 
    AND t1.`course` = {$courseID}
";
$result = mysql_fetch_assoc(mysql_query($query)) or die(mysql_error());
$quizID = $result["instance"];

$query = "
  INSERT INTO `{$course_settings_tbl}` (`courseid`, `sorting_quizid`)
  VALUES
    ({$courseID}, {$quizID})
";
mysql_query($query) or die(mysql_error());

echo "Populated table : {$course_settings_tbl}.\n";

foreach ($profiles as $p) {
  echo "  Profile : {$p['name']}\n";
  
  $query = "
    INSERT INTO `{$profile_tbl}` (`courseid`, `name`, `threshold`)
    VALUES
      ({$courseID}, '{$p['name']}', {$p['threshold']})
  ";
  mysql_query($query) or die(mysql_error());
  $profileID = mysql_insert_id();
  
  echo "    Created entry in {$profile_tbl}\n";

  foreach ($p["sections"] as $i => $s) {
    $query = "
      SELECT 
        t1.`instance`
      FROM
        `mdl_course_modules` AS t1 
        JOIN `mdl_modules` AS t2 
          ON t1.`module` = t2.`id` 
        JOIN `mdl_course_sections` AS t3 
          ON t1.`section` = t3.`id` 
      WHERE t2.`name` = 'quiz' 
        AND t3.`section` = {$s} 
        AND t1.`course` = {$courseID}
    ";
    $result = mysql_fetch_assoc(mysql_query($query)) or die(mysql_error());
    $quizID = $result["instance"];
    
    $ordering = $i + 1;
    
    $query = "
      INSERT INTO `{$profile_sections_tbl}`
        (`profileid`, `quizid`, `section`, `ordering`)
      VALUES
        ({$profileID}, {$quizID}, {$s}, {$ordering})
    ";
    mysql_query($query) or die(mysql_error());
  }
  
  echo "    Created entries in {$profile_sections_tbl}\n";
}

echo "Populated tables : {$profile_tbl} & {$profile_sections_tbl}.\n";

/* Close the DB connection */
mysql_close($db_handle);
echo "Closed DB connection\n";
?>
