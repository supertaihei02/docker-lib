<?php
/**
 * MySQLi Access Sample
 */

// Set DB config
define("DB_HOST", "mysql");
define("DB_NAME", "db");
define("DB_USER", "root");
define("DB_PASSWD", "password");
define("DB_CHARSET", "utf8");
define("DB_COLLATE", "utf8_unicode_ci");

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
if ($mysqli->connect_error) {
    die($mysqli->connect_error);
} else {
    $mysqli->set_charset("utf8");
}

// Create table
$sqlTbl = sprintf(
    "CREATE TABLE IF NOT EXISTS `test` ( ".
    "`id` int(10) unsigned NOT NULL auto_increment, ".
    "`name` varchar(100) character set utf8 NOT NULL default '', ".
    "PRIMARY KEY (`id`) ".
    ") ENGINE=InnoDB  DEFAULT CHARSET=%s COLLATE=%s;",
    DB_CHARSET,
    DB_COLLATE
);
if ($mysqli->query($sqlTbl) === true) {
    printf("Table created %s.<br/>", $sqlTbl);
} else {
    die("Table create fail: ".$sqlTbl."<br/>".$mysqli->error);
}

// Insert record
$sqlInsert = sprintf("INSERT INTO `test` (`name`) VALUES('Name Sample');");
if ($mysqli->query($sqlInsert) === true) {
    printf("Record created %s.<br/>", $sqlInsert);
} else {
    die("Record create fail:".$sqlInsert."<br/>".$mysqli->error);
}

// Select record
$sqlSelect = sprintf("SELECT `id`, `name` FROM `test`;");
if ($result = $mysqli->query($sqlSelect)) {
    while ($row = $result->fetch_assoc()) {
        printf("id:%s name:%s<br/>", $row["id"], $row["name"]);
    }
    $result->close();
} else {
    die("Select fail:".$sqlSelect."<br/>".$mysqli->error);
}

$mysqli->close();
?>