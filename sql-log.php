<?php 
	/*
	Plugin Name: SQL Query Log
	Plugin URI: https://github.com/vizarch/wp-sql-query-log
	Description: Save all SQL queries in log file
	Version: 1.0
	Author: Krzysztof Łuczak
	Author URI: https://luczak.pro
    */

add_action('shutdown', 'sql_logger');
function sql_logger() {
    global $wp;   
    global $wpdb;
    $log_file = fopen(ABSPATH.'/sql_queries.log', 'a');
    $current_url = home_url(add_query_arg(array(), $wp->request));
    fwrite($log_file, "START " . date("d-m-Y H:i:s:u") . " " . $current_url . "\n");
 
    $remove = array("\n");
    foreach($wpdb->queries as $q) {
        $query=str_replace($remove, ' ', $q[0]);
        fwrite($log_file, date("d-m-Y H:i:s:u") . " " . $query . " [$q[1] s]". " [Stack: $q[2]" . "]\n");
    }
    fclose($log_file);
}

?>

