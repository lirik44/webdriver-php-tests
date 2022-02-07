<?php
$local_config = __DIR__."/consts.local.php";
if(file_exists($local_config))
    include_once($local_config);
const HOST = 'www.w3schools.com/sql/trysql.asp?filename=trysql_select_all';
const HTTP_SCHEMA = 'http://';
const HTTPS_SCHEMA = 'https://';
const LINK_SELENIUM = 'http://localhost:4444/wd/hub';
const BROWSER = 'chrome';
//const BROWSER = 'firefox';