<?php
function sql_run($sql, $default_table_prefix = 'pb_') {
    global $dbcharset, $tb_prefix;
    if(mysql_get_server_info() > '4.1' && $dbcharset) {
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=".$dbcharset,$sql);
    }
    if($tb_prefix != $default_table_prefix) $sql = str_replace($default_table_prefix, $tb_prefix, $sql);
    $sql = str_replace("\r", "\n", $sql);
    $sql_content = array();
    $intRunTimes = 0;
    $arrQuery = explode(";\n", trim($sql));
    unset($sql);
    foreach($arrQuery as $query) {
        $sql_content[$num] = '';
        $tmpQuery = explode("\n", trim($query));
        $tmpQuery = array_filter($tmpQuery);
        foreach($tmpQuery as $query) {
            $str1 = substr($query, 0, 1);
            if($str1 != '#' && $str1 != '-') $sql_content[$num] .= $query;
        }
        $intRunTimes++;
    }
    if(is_array($sql_content) && !empty($sql_content)) {
        foreach($sql_content as $sql) {
            if(trim($sql) != '') {
                if(substr($sql, 0, 12) == 'CREATE TABLE') {
                    $name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $sql);
                    mysql_query(createtable($sql, $dbcharset));
                }else{
                    mysql_query($sql);
                }
            }
        }
    } else {
        mysql_query($sql_content);
    }
    return true;
}

function sql_create_table($sql, $dbcharset) {
    $type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
    $type = in_array($type, array('MYISAM', 'HEAP', 'INNODB')) ? $type : 'MYISAM';
    return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
    (mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET={$dbcharset}" : " TYPE=$type");
}
?>