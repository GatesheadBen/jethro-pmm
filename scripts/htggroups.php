<?php
/**
 * This script populates some "automatically populated groups" specifically for HTG
 * Ben Leighton 15/10/2017
 */

ini_set('display_errors', 1);
define('JETHRO_ROOT', dirname(dirname(__FILE__)));
set_include_path(get_include_path().PATH_SEPARATOR.JETHRO_ROOT);
if (!is_readable(JETHRO_ROOT.'/conf.php')) {
	trigger_error('Jethro configuration file not found.  You need to copy conf.php.sample to conf.php and edit it before Jethro can run', E_USER_ERROR);
	exit();
}
require_once JETHRO_ROOT.'/conf.php';
define('DB_MODE', 'private');
require_once JETHRO_ROOT.'/include/init.php';
$db = $GLOBALS['db'];

//Add all WF leaders and assistant leaders to "WF leaders..." group
 $SQL = '
     DROP TEMPORARY TABLE IF EXISTS temporary_table;
     DELETE FROM person_group_membership WHERE groupid = "142";
     CREATE TEMPORARY TABLE temporary_table AS SELECT DISTINCT personid, "142" AS groupid, "1" AS membership_status, NOW() AS created
     FROM person_group_membership WHERE groupid IN (130,131,132) AND membership_status IN (3,4);
     INSERT INTO person_group_membership SELECT * FROM temporary_table;
     DROP TEMPORARY TABLE temporary_table;';
 $res = $db->exec($SQL);
echo nl2br("WF Leaders and Assistant Leaders \n");
echo $SQL;
echo nl2br("\n");

//Add all homegroup leaders to "homegroup leaders" group
$SQL = '
    DROP TEMPORARY TABLE IF EXISTS temporary_table;
    DELETE FROM person_group_membership WHERE groupid = "110";
    CREATE TEMPORARY TABLE temporary_table AS SELECT DISTINCT personid, "110" AS groupid, "1" AS membership_status, NOW() AS created
    FROM person_group_membership WHERE groupid IN (133,134,135,136) AND membership_status IN (3,4);
    INSERT INTO person_group_membership SELECT * FROM temporary_table;
    DROP TEMPORARY TABLE temporary_table;';
$res = $db->exec($SQL);
echo nl2br("Homegroup Leaders \n");
echo $SQL;
echo nl2br("\n");

//Add all Music Leaders to "music leaders" group
$SQL = '
    DROP TEMPORARY TABLE IF EXISTS temporary_table;
    DELETE FROM person_group_membership WHERE groupid = "108";
    CREATE TEMPORARY TABLE temporary_table AS SELECT DISTINCT personid, "108" AS groupid, "1" AS membership_status, NOW() AS created
    FROM person_group_membership WHERE groupid IN (90,83,44,80,82,97) AND membership_status IN (3,4);
    INSERT INTO person_group_membership SELECT * FROM temporary_table;
    DROP TEMPORARY TABLE temporary_table;';
$res = $db->exec($SQL);
echo nl2br("Music Leaders \n");
echo $SQL;
echo nl2br("\n");

//Add all WF members to "WF All Members" group
$SQL = '
    DROP TEMPORARY TABLE IF EXISTS temporary_table;
    DELETE FROM person_group_membership WHERE groupid = "109";
    CREATE TEMPORARY TABLE temporary_table AS SELECT DISTINCT personid, "109" AS groupid, "1" AS membership_status, NOW() AS created
    FROM person_group_membership WHERE groupid IN (130,131,132);
    INSERT INTO person_group_membership SELECT * FROM temporary_table;
    DROP TEMPORARY TABLE temporary_table;';
$res = $db->exec($SQL);
echo nl2br("WF Members \n");
echo $SQL;
echo nl2br("\n");
	
//Add all WF Main Leaders to to WF Main Leaders only group
$SQL = '
    DROP TEMPORARY TABLE IF EXISTS temporary_table;
    DELETE FROM person_group_membership WHERE groupid = "95";
    CREATE TEMPORARY TABLE temporary_table AS SELECT DISTINCT personid, "95" AS groupid, "1" AS membership_status, NOW() AS created
    FROM person_group_membership WHERE groupid IN (130,131,132) AND membership_status IN (3);
    INSERT INTO person_group_membership SELECT * FROM temporary_table;
    DROP TEMPORARY TABLE temporary_table;';
$res = $db->exec($SQL);
echo nl2br("WF Main Leaders \n");
echo $SQL;
echo nl2br("\n");

echo "done \n";