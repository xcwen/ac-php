/* Local Variables: */
/*  (setq ac-php-comm-tags-data-list nil ) */
/*  End: */

<?php
/** @return string */ function apache_getenv ( string $variable , bool $walk_to_top = false  ){}
/** @return string */ function apache_note ( string $note_name , string $note_value = ""  ){}
/** @return bool */ function apache_setenv ( string $variable , string $value , bool $walk_to_top = false  ){}
/** @return bool */ function apc_add ( string $key , mixed $var , int $ttl = 0  ){}
/** @return int */ function apc_bin_dumpfile ( array $files , array $user_vars , string $filename , int $flags = 0 , resource $context = NULL  ){}
/** @return string */ function apc_bin_dump ( array $files = NULL , array $user_vars = NULL  ){}
/** @return bool */ function apc_bin_loadfile ( string $filename , resource $context = NULL , int $flags = 0  ){}
/** @return bool */ function apc_bin_load ( string $data , int $flags = 0  ){}
/** @return array */ function apc_cache_info ( string $cache_type = "" , bool $limited = false  ){}
/** @return bool */ function apc_clear_cache ( string $cache_type = ""  ){}
/** @return mixed */ function apc_compile_file ( string $filename , bool $atomic = true  ){}
/** @return int */ function apc_dec ( string $key , int $step = 1 , bool &$success = null  ){}
/** @return bool */ function apc_define_constants ( string $key , array $constants , bool $case_sensitive = true  ){}
/** @return mixed */ function apc_fetch ( mixed $key , bool &$success = null  ){}
/** @return int */ function apc_inc ( string $key , int $step = 1 , bool &$success = null  ){}
/** @return bool */ function apc_load_constants ( string $key , bool $case_sensitive = true  ){}
/** @return array */ function apc_sma_info ( bool $limited = false  ){}
/** @return bool */ function apc_store ( string $key , mixed $var , int $ttl = 0  ){}
/** @return void */ function apd_clunk ( string $warning , string $delimiter = "<BR />"  ){}
/** @return void */ function apd_croak ( string $warning , string $delimiter = "<BR />"  ){}
/** @return string */ function apd_set_pprof_trace ( string $dump_directory = 'ini_get("apd.dumpdir")' , string $fragment = "pprof"  ){}
/** @return void */ function apd_set_session_trace ( int $debug_level , string $dump_directory = 'ini_get("apd.dumpdir")'  ){}
/** @return array */ function array_change_key_case ( array $array , int $case = CASE_LOWER  ){}
/** @return array */ function array_chunk ( array $array , int $size , bool $preserve_keys = false  ){}
/** @return array */ function array_column ( array $array , mixed $column_key , mixed $index_key = null  ){}
/** @return array */ function array_diff_assoc ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_diff ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_diff_key ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_diff_uassoc ( array $array1 , array $array2 , array $__args__ = null , callable $key_compare_func ){}
/** @return array */ function array_diff_ukey ( array $array1 , array $array2 , array $__args__ = null , callable $key_compare_func ){}
/** @return array */ function array_filter ( array $array , callable $callback , int $flag = 0  ){}
// /** @return array */ function array ( mixed $__args__ = null  ){}
/** @return array */ function array_intersect_assoc ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_intersect ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_intersect_key ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_intersect_uassoc ( array $array1 , array $array2 , array $__args__ = null , callable $key_compare_func ){}
/** @return array */ function array_intersect_ukey ( array $array1 , array $array2 , array $__args__ = null , callable $key_compare_func ){}
/** @return array */ function array_keys ( array $array , mixed $search_value , bool $strict = false  ){}
/** @return array */ function array_map ( callable $callback , array $array1 , array $__args__ = null  ){}
/** @return array */ function array_merge ( array $array1 , array $__args__ = null  ){}
/** @return array */ function array_merge_recursive ( array $array1 , array $__args__ = null  ){}
/** @return bool */ function array_multisort ( array &$array1 , mixed $array1_sort_order = SORT_ASC , mixed $array1_sort_flags = SORT_REGULAR , mixed $__args__ = null  ){}
/** @return int */ function array_push ( array &$array , mixed $value1 , mixed $__args__ = null  ){}
/** @return mixed */ function array_rand ( array $array , int $num = 1  ){}
/** @return mixed */ function array_reduce ( array $array , callable $callback , mixed $initial = NULL  ){}
/** @return array */ function array_replace ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_replace_recursive ( array $array1 , array $array2 , array $__args__ = null  ){}
/** @return array */ function array_reverse ( array $array , bool $preserve_keys = false  ){}
/** @return mixed */ function array_search ( mixed $needle , array $haystack , bool $strict = false  ){}
/** @return array */ function array_slice ( array $array , int $offset , int $length = NULL , bool $preserve_keys = false  ){}
/** @return array */ function array_splice ( array &$input , int $offset , int $length , mixed $replacement ='array()'  ){}
/** @return array */ function array_udiff_assoc ( array $array1 , array $array2 , array $__args__ = null , callable $value_compare_func ){}
/** @return array */ function array_udiff ( array $array1 , array $array2 , array $__args__ = null , callable $value_compare_func ){}
/** @return array */ function array_udiff_uassoc ( array $array1 , array $array2 , array $__args__ = null , callable $value_compare_func , callable $key_compare_func ){}
/** @return array */ function array_uintersect_assoc ( array $array1 , array $array2 , array $__args__ = null , callable $value_compare_func ){}
/** @return array */ function array_uintersect ( array $array1 , array $array2 , array $__args__ = null , callable $value_compare_func ){}
/** @return array */ function array_uintersect_uassoc ( array $array1 , array $array2 , array $__args__ = null , callable $value_compare_func , callable $key_compare_func ){}
/** @return array */ function array_unique ( array $array , int $sort_flags = SORT_STRING  ){}
/** @return int */ function array_unshift ( array &$array , mixed $value1 , mixed $__args__ = null  ){}
/** @return bool */ function array_walk ( array &$array , callable $callback , mixed $userdata = NULL  ){}
/** @return bool */ function array_walk_recursive ( array &$array , callable $callback , mixed $userdata = NULL  ){}
/** @return bool */ function arsort ( array &$array , int $sort_flags = SORT_REGULAR  ){}
/** @return bool */ function asort ( array &$array , int $sort_flags = SORT_REGULAR  ){}
/** @return bool */ function assert ( mixed $assertion , string $description = null  ){}
/** @return mixed */ function assert_options ( int $what , mixed $value = null  ){}
/** @return string */ function base64_decode ( string $data , bool $strict = false  ){}
/** @return string */ function basename ( string $path , string $suffix = null  ){}
/** @return resource */ function bbcode_create ( array $bbcode_initial_tags = NULL  ){}
/** @return bool */ function bbcode_set_flags ( resource $bbcode_container , int $flags , int $mode = BBCODE_SET_FLAGS_SET  ){}
/** @return string */ function bcadd ( string $left_operand , string $right_operand , int $scale = null  ){}
/** @return int */ function bccomp ( string $left_operand , string $right_operand , int $scale = int  ){}
/** @return string */ function bcdiv ( string $left_operand , string $right_operand , int $scale = int  ){}
/** @return string */ function bcmul ( string $left_operand , string $right_operand , int $scale = int  ){}
/** @return bool */ function bcompiler_write_class ( resource $filehandle , string $className , string $extends = null  ){}
/** @return bool */ function bcompiler_write_header ( resource $filehandle , string $write_ver = null  ){}
/** @return string */ function bcpow ( string $left_operand , string $right_operand , int $scale = null  ){}
/** @return string */ function bcpowmod ( string $left_operand , string $right_operand , string $modulus , int $scale = int  ){}
/** @return string */ function bcsqrt ( string $operand , int $scale = null  ){}
/** @return string */ function bcsub ( string $left_operand , string $right_operand , int $scale = int  ){}
/** @return string */ function blenc_encrypt ( string $plaintext , string $encodedfile , string $encryption_key = null  ){}
/** @return mixed */ function bzcompress ( string $source , int $blocksize = 4 , int $workfactor = 0  ){}
/** @return mixed */ function bzdecompress ( string $source , int $small = 0  ){}
/** @return string */ function bzread ( resource $bz , int $length = 1024  ){}
/** @return int */ function bzwrite ( resource $bz , string $data , int $length = null  ){}
/** @Return CairoImageSurface */ function cairo_image_surface_create_for_data ( string $data , int $format , int $width , int $height , int $stride = -1  ){}
/** @return array */ function cal_info ( int $calendar = -1  ){}
/** @return mixed */ function call_user_func ( callable $callback , mixed $parameter , mixed $__args__ = null  ){}
/** @return mixed */ function call_user_method ( string $method_name , object &$obj , mixed $parameter , mixed $__args__ = null  ){}
/** @return bool */ function checkdnsrr ( string $host , string $type = "MX"  ){}
/** @return string */ function chunk_split ( string $body , int $chunklen = 76 , string $end = "\r\n"  ){}
/** @return bool */ function class_alias ( string $original , string $alias , bool $autoload = TRUE  ){}
/** @return bool */ function class_exists ( string $class_name , bool $autoload = true  ){}
/** @return array */ function class_implements ( mixed $class , bool $autoload = true  ){}
/** @return bool */ function classkit_method_add ( string $classname , string $methodname , string $args , string $code , int $flags = CLASSKIT_ACC_PUBLIC  ){}
/** @return bool */ function classkit_method_copy ( string $dClass , string $dMethod , string $sClass , string $sMethod = null  ){}
/** @return bool */ function classkit_method_redefine ( string $classname , string $methodname , string $args , string $code , int $flags = CLASSKIT_ACC_PUBLIC  ){}
/** @return array */ function class_parents ( mixed $class , bool $autoload = true  ){}
/** @return array */ function class_uses ( mixed $class , bool $autoload = true  ){}
/** @return void */ function clearstatcache ( bool $clear_realpath_cache = false , string $filename = null  ){}
/** @return void */ function closedir ( resource $dir_handle = null  ){}
/** @return bool */ function com_event_sink ( variant $comobject , object $sinkobject , mixed $sinkinterface = null  ){}
/** @return variant */ function com_get_active_object ( string $progid , int $code_page = null  ){}
/** @return bool */ function com_load_typelib ( string $typelib_name , bool $case_insensitive = true  ){}
/** @return bool */ function com_message_pump ( int $timeoutms = 0  ){}
/** @return array */ function compact ( mixed $varname1 , mixed $__args__ = null  ){}
/** @return bool */ function com_print_typeinfo ( object $comobject , string $dispinterface , bool $wantsink = false  ){}
/** @return bool */ function copy ( string $source , string $dest , resource $context = null  ){}
/** @return mixed */ function count_chars ( string $string , int $mode = 0  ){}
/** @return int */ function count ( mixed $array_or_countable , int $mode = COUNT_NORMAL  ){}
/** @return bool */ function crack_closedict ( resource $dictionary = null  ){}
/** @return string */ function crypt ( string $str , string $salt = null  ){}
/** @return int */ function cubrid_affected_rows ( resource $conn_identifier = null  ){}
/** @return bool */ function cubrid_bind ( resource $req_identifier , int $bind_index , mixed $bind_value , string $bind_value_type = null  ){}
/** @return string */ function cubrid_client_encoding ( resource $conn_identifier = null  ){}
/** @return bool */ function cubrid_close ( resource $conn_identifier = null  ){}
/** @return resource */ function cubrid_connect ( string $host , int $port , string $dbname , string $userid , string $passwd , bool $new_link = false  ){}
/** @return resource */ function cubrid_connect_with_url ( string $conn_url , string $userid , string $passwd , bool $new_link = false  ){}
/** @return bool */ function cubrid_disconnect ( resource $conn_identifier = null  ){}
/** @return int */ function cubrid_errno ( resource $conn_identifier = null  ){}
/** @return string */ function cubrid_error ( resource $connection = null  ){}
/** @return resource */ function cubrid_execute ( resource $conn_identifier , string $sql , int $option = null  ){}
/** @return array */ function cubrid_fetch_array ( resource $result , int $type = CUBRID_BOTH  ){}
/** @return array */ function cubrid_fetch_assoc ( resource $result , int $type = null  ){}
/** @return object */ function cubrid_fetch_field ( resource $result , int $field_offset = 0  ){}
/** @return mixed */ function cubrid_fetch ( resource $result , int $type = CUBRID_BOTH  ){}
/** @return object */ function cubrid_fetch_object ( resource $result , string $class_name , array $params , int $type = null  ){}
/** @return array */ function cubrid_fetch_row ( resource $result , int $type = null  ){}
/** @return bool */ function cubrid_field_seek ( resource $result , int $field_offset = 0  ){}
/** @return mixed */ function cubrid_get ( resource $conn_identifier , string $oid , mixed $attr = null  ){}
/** @return string */ function cubrid_insert_id ( resource $conn_identifier = null  ){}
/** @return array */ function cubrid_list_dbs ( resource $conn_identifier = null  ){}
/** @return bool */ function cubrid_lob2_bind ( resource $req_identifier , int $bind_index , mixed $bind_value , string $bind_value_type = null  ){}
/** @return resource */ function cubrid_lob2_new ( resource $conn_identifier , string $type = "BLOB"  ){}
/** @return bool */ function cubrid_lob2_seek64 ( resource $lob_identifier , string $offset , int $origin = CUBRID_CURSOR_CURRENT  ){}
/** @return bool */ function cubrid_lob2_seek ( resource $lob_identifier , int $offset , int $origin = CUBRID_CURSOR_CURRENT  ){}
/** @return int */ function cubrid_move_cursor ( resource $req_identifier , int $offset , int $origin = CUBRID_CURSOR_CURRENT  ){}
/** @return resource */ function cubrid_pconnect ( string $host , int $port , string $dbname , string $userid , string $passwd = null  ){}
/** @return resource */ function cubrid_pconnect_with_url ( string $conn_url , string $userid , string $passwd = null  ){}
/** @return bool */ function cubrid_ping ( resource $conn_identifier = null  ){}
/** @return resource */ function cubrid_prepare ( resource $conn_identifier , string $prepare_stmt , int $option = 0  ){}
/** @return int */ function cubrid_put ( resource $conn_identifier , string $oid , string $attr = null , mixed $value ){}
/** @return resource */ function cubrid_query ( string $query , resource $conn_identifier = null  ){}
/** @return string */ function cubrid_real_escape_string ( string $unescaped_string , resource $conn_identifier = null  ){}
/** @return string */ function cubrid_result ( resource $result , int $row , mixed $field = 0  ){}
/** @return array */ function cubrid_schema ( resource $conn_identifier , int $schema_type , string $class_name , string $attr_name = null  ){}
/** @return resource */ function cubrid_unbuffered_query ( string $query , resource $conn_identifier = null  ){}
/** @return mixed */ function curl_getinfo ( resource $ch , int $opt = 0  ){}
/** @return resource */ function curl_init ( string $url = NULL  ){}
/** @return array */ function curl_multi_info_read ( resource $mh , int &$msgs_in_queue = NULL  ){}
/** @return int */ function curl_multi_select ( resource $mh , float $timeout = 1.0  ){}
/** @return array */ function curl_version ( int $age = CURLVERSION_NOW  ){}
/** @return void */ function cyrus_authenticate ( resource $connection , string $mechlist , string $service , string $user , int $minssf , int $maxssf , string $authname , string $password = null  ){}
/** @return resource */ function cyrus_connect ( string $host , string $port , int $flags = null  ){}
/** @return string */ function date ( string $format , int $timestamp = "time()"  ){}
/** @return mixed */ function date_sunrise ( int $timestamp , int $format = SUNFUNCS_RET_STRING , float $latitude = 'ini_get("date.default_latitude")' , float $longitude = 'ini_get("date.default_longitude")' , float $zenith = 'ini_get("date.sunrise_zenith")' , float $gmt_offset = 0  ){}
/** @return mixed */ function date_sunset ( int $timestamp , int $format = SUNFUNCS_RET_STRING , float $latitude = 'ini_get("date.default_latitude")' , float $longitude = 'ini_get("date.default_longitude")' , float $zenith = 'ini_get("date.sunset_zenith")' , float $gmt_offset = 0  ){}
/** @return mixed */ function db2_autocommit ( resource $connection , bool $value = null  ){}
/** @return bool */ function db2_bind_param ( resource $stmt , int $parameter_number , string $variable_name , int $parameter_type , int $data_type = 0 , int $precision = -1 , int $scale = 0  ){}
/** @return resource */ function db2_column_privileges ( resource $connection , string $qualifier , string $schema , string $table_name , string $column_name  ){}
/** @return resource */ function db2_columns ( resource $connection , string $qualifier , string $schema , string $table_name , string $column_name  ){}
/** @return resource */ function db2_connect ( string $database , string $username , string $password , array $options = null  ){}
/** @return string */ function db2_conn_error ( resource $connection = null  ){}
/** @return string */ function db2_conn_errormsg ( resource $connection = null  ){}
/** @return resource */ function db2_exec ( resource $connection , string $statement , array $options = null  ){}
/** @return bool */ function db2_execute ( resource $stmt , array $parameters = null  ){}
/** @return array */ function db2_fetch_array ( resource $stmt , int $row_number = -1  ){}
/** @return array */ function db2_fetch_assoc ( resource $stmt , int $row_number = -1  ){}
/** @return array */ function db2_fetch_both ( resource $stmt , int $row_number = -1  ){}
/** @return object */ function db2_fetch_object ( resource $stmt , int $row_number = -1  ){}
/** @return bool */ function db2_fetch_row ( resource $stmt , int $row_number = null  ){}
/** @return resource */ function db2_pconnect ( string $database , string $username , string $password , array $options = null  ){}
/** @return resource */ function db2_prepare ( resource $connection , string $statement , array $options = null  ){}
/** @return string */ function db2_stmt_error ( resource $stmt = null  ){}
/** @return string */ function db2_stmt_errormsg ( resource $stmt = null  ){}
/** @return resource */ function db2_table_privileges ( resource $connection , string $qualifier , string $schema , string $table_name = null  ){}
/** @return resource */ function db2_tables ( resource $connection , string $qualifier , string $schema , string $table_name , string $table_type  ){}
/** @return array */ function dba_handlers ( bool $full_info = false  ){}
/** @return resource */ function dba_open ( string $path , string $mode , string $handler , mixed $__args__ = null  ){}
/** @return resource */ function dba_popen ( string $path , string $mode , string $handler , mixed $__args__ = null  ){}
/** @return resource */ function dbplus_aql ( string $query , string $server , string $dbpath = null  ){}
/** @return string */ function dbplus_chdir ( string $newdir = null  ){}
/** @return string */ function dbplus_errcode ( int $errno = null  ){}
/** @return resource */ function dbplus_rcreate ( string $name , mixed $domlist , bool $overwrite = null  ){}
/** @return mixed */ function dbplus_rcrtexact ( string $name , resource $relation , bool $overwrite = null  ){}
/** @return mixed */ function dbplus_rcrtlike ( string $name , resource $relation , int $overwrite = null  ){}
/** @return resource */ function dbplus_rquery ( string $query , string $dbpath = null  ){}
/** @return resource */ function dbplus_sql ( string $query , string $server , string $dbpath = null  ){}
/** @return int */ function dbplus_tremove ( resource $relation , array $tuple , array &$current = null  ){}
/** @return int */ function dbx_compare ( array $row_a , array $row_b , string $column_key , int $flags = DBX_CMP_ASC | DBX_CMP_NATIVE  ){}
/** @return object */ function dbx_connect ( mixed $module , string $host , string $database , string $username , string $password , int $persistent = null  ){}
/** @return mixed */ function dbx_query ( object $link_identifier , string $sql_statement , int $flags = null  ){}
/** @return array */ function debug_backtrace ( int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT , int $limit = 0  ){}
/** @return void */ function debug_print_backtrace ( int $options = 0 , int $limit = 0  ){}
/** @return void */ function debug_zval_dump ( mixed $variable , mixed $__args__ = null  ){}
/** @return bool */ function define ( string $name , mixed $value , bool $case_insensitive = false  ){}
/** @return mixed */ function dio_fcntl ( resource $fd , int $cmd , mixed $args = null  ){}
/** @return resource */ function dio_open ( string $filename , int $flags , int $mode = 0  ){}
/** @return string */ function dio_read ( resource $fd , int $len = 1024  ){}
/** @return int */ function dio_seek ( resource $fd , int $pos , int $whence = SEEK_SET  ){}
/** @return int */ function dio_write ( resource $fd , string $data , int $len = 0  ){}
/** @Return Directory */ function dir ( string $directory , resource $context = null  ){}
/** @return array */ function dns_get_record ( string $hostname , int $type = DNS_ANY , array &$authns , array &$addtl , bool &$raw = false  ){}
/** @return int */ function easter_date ( int $year ='date("Y")'  ){}
/** @return int */ function easter_days ( int $year ='date("Y")' , int $method = CAL_EASTER_DEFAULT  ){}
///** @return void */ function echo ( string $arg1 , string $__args__ = null  ){}
/** @return resource */ function eio_busy ( int $delay , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_chmod ( string $path , int $mode , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_chown ( string $path , int $uid , int $gid = -1 , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_close ( mixed $fd , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_custom ( callable $execute , int $pri , callable $callback , mixed $data = NULL  ){}
/** @return resource */ function eio_dup2 ( mixed $fd , mixed $fd2 , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_fallocate ( mixed $fd , int $mode , int $offset , int $length , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_fchmod ( mixed $fd , int $mode , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_fchown ( mixed $fd , int $uid , int $gid = -1 , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_fdatasync ( mixed $fd , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_fstat ( mixed $fd , int $pri , callable $callback , mixed $data = null  ){}
/** @return resource */ function eio_fstatvfs ( mixed $fd , int $pri , callable $callback , mixed $data = null  ){}
/** @return resource */ function eio_fsync ( mixed $fd , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_ftruncate ( mixed $fd , int $offset = 0 , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_futime ( mixed $fd , float $atime , float $mtime , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_grp ( callable $callback , string $data = NULL  ){}
/** @return resource */ function eio_link ( string $path , string $new_path , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_lstat ( string $path , int $pri , callable $callback , mixed $data = NULL  ){}
/** @return resource */ function eio_mkdir ( string $path , int $mode , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_mknod ( string $path , int $mode , int $dev , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_nop ( int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_open ( string $path , int $flags , int $mode , int $pri , callable $callback , mixed $data = NULL  ){}
/** @return resource */ function eio_readahead ( mixed $fd , int $offset , int $length , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_readdir ( string $path , int $flags , int $pri , callable $callback , string $data = NULL  ){}
/** @return resource */ function eio_read ( mixed $fd , int $length , int $offset , int $pri , callable $callback , mixed $data = NULL  ){}
/** @return resource */ function eio_readlink ( string $path , int $pri , callable $callback , string $data = NULL  ){}
/** @return resource */ function eio_realpath ( string $path , int $pri , callable $callback , string $data = NULL  ){}
/** @return resource */ function eio_rename ( string $path , string $new_path , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_rmdir ( string $path , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_seek ( mixed $fd , int $offset , int $whence , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_sendfile ( mixed $out_fd , mixed $in_fd , int $offset , int $length , int $pri , callable $callback , string $data = null  ){}
/** @return resource */ function eio_stat ( string $path , int $pri , callable $callback , mixed $data = NULL  ){}
/** @return resource */ function eio_statvfs ( string $path , int $pri , callable $callback , mixed $data = null  ){}
/** @return resource */ function eio_symlink ( string $path , string $new_path , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_sync_file_range ( mixed $fd , int $offset , int $nbytes , int $flags , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_syncfs ( mixed $fd , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_sync ( int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_truncate ( string $path , int $offset = 0 , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_unlink ( string $path , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_utime ( string $path , float $atime , float $mtime , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return resource */ function eio_write ( mixed $fd , string $str , int $length = 0 , int $offset = 0 , int $pri = EIO_PRI_DEFAULT , callable $callback = NULL , mixed $data = NULL  ){}
/** @return bool */ function enchant_dict_quick_check ( resource $dict , string $word , array &$suggestions = null  ){}
/** @return int */ function ereg ( string $pattern , string $string , array &$regs = null  ){}
/** @return int */ function eregi ( string $pattern , string $string , array &$regs = null  ){}
/** @return bool */ function error_log ( string $message , int $message_type = 0 , string $destination , string $extra_headers = null  ){}
/** @return int */ function error_reporting ( int $level = null  ){}
/** @return bool */ function event_add ( resource $event , int $timeout = -1  ){}
/** @return bool */ function event_base_loopexit ( resource $event_base , int $timeout = -1  ){}
/** @return int */ function event_base_loop ( resource $event_base , int $flags = 0  ){}
/** @return resource */ function event_buffer_new ( resource $stream , mixed $readcb , mixed $writecb , mixed $errorcb , mixed $arg = null  ){}
/** @return bool */ function event_buffer_set_callback ( resource $event , mixed $readcb , mixed $writecb , mixed $errorcb , mixed $arg = null  ){}
/** @return bool */ function event_buffer_write ( resource $bevent , string $data , int $data_size = -1  ){}
/** @return bool */ function event_set ( resource $event , mixed $fd , int $events , mixed $callback , mixed $arg = null  ){}
/** @return bool */ function event_timer_set ( resource $event , callable $callback , mixed $arg = null  ){}
/** @return string */ function exec ( string $command , array &$output , int &$return_var = null  ){}
/** @return array */ function exif_read_data ( string $filename , string $sections = NULL , bool $arrays = false , bool $thumbnail = false  ){}
/** @return string */ function exif_thumbnail ( string $filename , int &$width , int &$height , int &$imagetype = null  ){}
///** @return void */ function exit ( string $status = null  ){}
/** @return int */ function expect_expectl ( resource $expect , array $cases , array &$match = null  ){}
/** @return array */ function explode ( string $delimiter , string $string , int $limit = null  ){}
/** @return int */ function extract ( array &$array , int $flags = EXTR_OVERWRITE , string $prefix = NULL  ){}
/** @return resource */ function fam_open ( string $appname = null  ){}
/** @return reference */ function fann_create_shortcut ( int $num_layers , int $num_neurons1 , int $num_neurons2 , int $__args__ = null  ){}
/** @Return ReturnType */ function fann_create_sparse ( float $connection_rate , int $num_layers , int $num_neurons1 , int $num_neurons2 , int $__args__ = null  ){}
/** @return resource */ function fann_create_standard ( int $num_layers , int $num_neurons1 , int $num_neurons2 , int $__args__ = null  ){}
/** @return int */ function fbsql_affected_rows ( resource $link_identifier = null  ){}
/** @return bool */ function fbsql_autocommit ( resource $link_identifier , bool $OnOff = null  ){}
/** @return int */ function fbsql_blob_size ( string $blob_handle , resource $link_identifier = null  ){}
/** @return bool */ function fbsql_change_user ( string $user , string $password , string $database , resource $link_identifier = null  ){}
/** @return int */ function fbsql_clob_size ( string $clob_handle , resource $link_identifier = null  ){}
/** @return bool */ function fbsql_close ( resource $link_identifier = null  ){}
/** @return bool */ function fbsql_commit ( resource $link_identifier = null  ){}
/** @return resource */ function fbsql_connect ( string $hostname = 'ini_get("fbsql.default_host")' , string $username = 'ini_get("fbsql.default_user")' , string $password = 'ini_get("fbsql.default_password")'  ){}
/** @return string */ function fbsql_create_blob ( string $blob_data , resource $link_identifier = null  ){}
/** @return string */ function fbsql_create_clob ( string $clob_data , resource $link_identifier = null  ){}
/** @return bool */ function fbsql_create_db ( string $database_name , resource $link_identifier , string $database_options = null  ){}
/** @return string */ function fbsql_database ( resource $link_identifier , string $database = null  ){}
/** @return string */ function fbsql_database_password ( resource $link_identifier , string $database_password = null  ){}
/** @return resource */ function fbsql_db_query ( string $database , string $query , resource $link_identifier = null  ){}
/** @return int */ function fbsql_db_status ( string $database_name , resource $link_identifier = null  ){}
/** @return bool */ function fbsql_drop_db ( string $database_name , resource $link_identifier = null  ){}
/** @return int */ function fbsql_errno ( resource $link_identifier = null  ){}
/** @return string */ function fbsql_error ( resource $link_identifier = null  ){}
/** @return array */ function fbsql_fetch_array ( resource $result , int $result_type = null  ){}
/** @return object */ function fbsql_fetch_field ( resource $result , int $field_offset = null  ){}
/** @return string */ function fbsql_field_flags ( resource $result , int $field_offset = null  ){}
/** @return int */ function fbsql_field_len ( resource $result , int $field_offset = null  ){}
/** @return string */ function fbsql_field_name ( resource $result , int $field_index = null  ){}
/** @return bool */ function fbsql_field_seek ( resource $result , int $field_offset = null  ){}
/** @return string */ function fbsql_field_table ( resource $result , int $field_offset = null  ){}
/** @return string */ function fbsql_field_type ( resource $result , int $field_offset = null  ){}
/** @return array */ function fbsql_get_autostart_info ( resource $link_identifier = null  ){}
/** @return string */ function fbsql_hostname ( resource $link_identifier , string $host_name = null  ){}
/** @return int */ function fbsql_insert_id ( resource $link_identifier = null  ){}
/** @return resource */ function fbsql_list_dbs ( resource $link_identifier = null  ){}
/** @return resource */ function fbsql_list_fields ( string $database_name , string $table_name , resource $link_identifier = null  ){}
/** @return resource */ function fbsql_list_tables ( string $database , resource $link_identifier = null  ){}
/** @return string */ function fbsql_password ( resource $link_identifier , string $password = null  ){}
/** @return resource */ function fbsql_pconnect ( string $hostname = 'ini_get("fbsql.default_host")' , string $username = 'ini_get("fbsql.default_user")' , string $password = 'ini_get("fbsql.default_password")'  ){}
/** @return resource */ function fbsql_query ( string $query , resource $link_identifier , int $batch_size = null  ){}
/** @return string */ function fbsql_read_blob ( string $blob_handle , resource $link_identifier = null  ){}
/** @return string */ function fbsql_read_clob ( string $clob_handle , resource $link_identifier = null  ){}
/** @return mixed */ function fbsql_result ( resource $result , int $row , mixed $field = null  ){}
/** @return bool */ function fbsql_rollback ( resource $link_identifier = null  ){}
/** @return bool */ function fbsql_select_db ( string $database_name , resource $link_identifier = null  ){}
/** @return void */ function fbsql_set_characterset ( resource $link_identifier , int $characterset , int $in_out_both = null  ){}
/** @return bool */ function fbsql_start_db ( string $database_name , resource $link_identifier , string $database_options = null  ){}
/** @return bool */ function fbsql_stop_db ( string $database_name , resource $link_identifier = null  ){}
/** @return string */ function fbsql_username ( resource $link_identifier , string $username = null  ){}
/** @return bool */ function fbsql_warnings ( bool $OnOff = null  ){}
/** @return bool */ function fdf_enum_values ( resource $fdf_document , callable $function , mixed $userdata = null  ){}
/** @return string */ function fdf_error ( int $error_code = -1  ){}
/** @return mixed */ function fdf_get_opt ( resource $fdf_document , string $fieldname , int $element = -1  ){}
/** @return mixed */ function fdf_get_value ( resource $fdf_document , string $fieldname , int $which = -1  ){}
/** @return string */ function fdf_get_version ( resource $fdf_document = null  ){}
/** @return string */ function fdf_next_field_name ( resource $fdf_document , string $fieldname = null  ){}
/** @return bool */ function fdf_save ( resource $fdf_document , string $filename = null  ){}
/** @return bool */ function fdf_set_file ( resource $fdf_document , string $url , string $target_frame = null  ){}
/** @return bool */ function fdf_set_value ( resource $fdf_document , string $fieldname , mixed $value , int $isName = null  ){}
/** @return array */ function fgetcsv ( resource $handle , int $length = 0 , string $delimiter = "," , string $enclosure = '"' , string $escape = "\\"  ){}
/** @return string */ function fgets ( resource $handle , int $length = null  ){}
/** @return string */ function fgetss ( resource $handle , int $length , string $allowable_tags = null  ){}
/** @return string */ function file_get_contents ( string $filename , bool $use_include_path = false , resource $context , int $offset = -1 , int $maxlen = null  ){}
/** @return array */ function file ( string $filename , int $flags = 0 , resource $context = null  ){}
/** @return int */ function file_put_contents ( string $filename , mixed $data , int $flags = 0 , resource $context = null  ){}
/** @return mixed */ function filter_input_array ( int $type , mixed $definition , bool $add_empty = true  ){}
/** @return mixed */ function filter_input ( int $type , string $variable_name , int $filter = FILTER_DEFAULT , mixed $options = null  ){}
/** @return mixed */ function filter_var_array ( array $data , mixed $definition , bool $add_empty = true  ){}
/** @return mixed */ function filter_var ( mixed $variable , int $filter = FILTER_DEFAULT , mixed $options = null  ){}
/** @return bool */ function flock ( resource $handle , int $operation , int &$wouldblock = null  ){}
/** @return bool */ function fnmatch ( string $pattern , string $string , int $flags = 0  ){}
/** @return resource */ function fopen ( string $filename , string $mode , bool $use_include_path = false , resource $context = null  ){}
/** @return mixed */ function forward_static_call ( callable $function , mixed $parameter , mixed $__args__ = null  ){}
/** @return int */ function fprintf ( resource $handle , string $format , mixed $args , mixed $__args__ = null  ){}
/** @return int */ function fputcsv ( resource $handle , array $fields , string $delimiter = "," , string $enclosure = '"' , string $escape_char = "\\"  ){}
/** @return mixed */ function fscanf ( resource $handle , string $format , mixed &$__args__ = null  ){}
/** @return int */ function fseek ( resource $handle , int $offset , int $whence = SEEK_SET  ){}
/** @return resource */ function fsockopen ( string $hostname , int $port = -1 , int &$errno , string &$errstr , float $timeout = 'ini_get("default_socket_timeout")'  ){}
/** @return bool */ function ftp_alloc ( resource $ftp_stream , int $filesize , string &$result = null  ){}
/** @return resource */ function ftp_connect ( string $host , int $port = 21 , int $timeout = 90  ){}
/** @return bool */ function ftp_fget ( resource $ftp_stream , resource $handle , string $remote_file , int $mode , int $resumepos = 0  ){}
/** @return bool */ function ftp_fput ( resource $ftp_stream , string $remote_file , resource $handle , int $mode , int $startpos = 0  ){}
/** @return bool */ function ftp_get ( resource $ftp_stream , string $local_file , string $remote_file , int $mode , int $resumepos = 0  ){}
/** @return int */ function ftp_nb_fget ( resource $ftp_stream , resource $handle , string $remote_file , int $mode , int $resumepos = 0  ){}
/** @return int */ function ftp_nb_fput ( resource $ftp_stream , string $remote_file , resource $handle , int $mode , int $startpos = 0  ){}
/** @return int */ function ftp_nb_get ( resource $ftp_stream , string $local_file , string $remote_file , int $mode , int $resumepos = 0  ){}
/** @return int */ function ftp_nb_put ( resource $ftp_stream , string $remote_file , string $local_file , int $mode , int $startpos = 0  ){}
/** @return bool */ function ftp_put ( resource $ftp_stream , string $remote_file , string $local_file , int $mode , int $startpos = 0  ){}
/** @return mixed */ function ftp_rawlist ( resource $ftp_stream , string $directory , bool $recursive = false  ){}
/** @return resource */ function ftp_ssl_connect ( string $host , int $port = 21 , int $timeout = 90  ){}
/** @return int */ function fwrite ( resource $handle , string $string , int $length = null  ){}
/** @return string */ function geoip_database_info ( int $database = GEOIP_COUNTRY_EDITION  ){}
/** @return string */ function geoip_time_zone_by_country_and_region ( string $country_code , string $region_code = null  ){}
/** @return mixed */ function get_browser ( string $user_agent , bool $return_array = false  ){}
/** @return string */ function get_class ( object $object = NULL  ){}
/** @return array */ function getdate ( int $timestamp ='time()'  ){}
/** @return array */ function get_defined_constants ( bool $categorize = false  ){}
/** @return array */ function get_headers ( string $url , int $format = 0  ){}
/** @return array */ function get_html_translation_table ( int $table = HTML_SPECIALCHARS , int $flags = ENT_COMPAT | ENT_HTML401 , string $encoding = "UTF-8"  ){}
/** @return array */ function getimagesizefromstring ( string $imagedata , array &$imageinfo = null  ){}
/** @return array */ function getimagesize ( string $filename , array &$imageinfo = null  ){}
/** @return array */ function get_loaded_extensions ( bool $zend_extensions = false  ){}
/** @return array */ function get_meta_tags ( string $filename , bool $use_include_path = false  ){}
/** @return bool */ function getmxrr ( string $hostname , array &$mxhosts , array &$weight = null  ){}
/** @return array */ function getopt ( string $options , array $longopts = null  ){}
/** @return string */ function get_parent_class ( mixed $object = null  ){}
/** @return array */ function getrusage ( int $who = 0  ){}
/** @return mixed */ function gettimeofday ( bool $return_float = false  ){}
/** @return array */ function glob ( string $pattern , int $flags = 0  ){}
/** @return string */ function gmdate ( string $format , int $timestamp ='time()'  ){}
/** @return int */ function gmmktime ( int $hour ='gmdate("H")' , int $minute ='gmdate("i")' , int $second ='gmdate("s")' , int $month ='gmdate("n")' , int $day ='gmdate("j")' , int $year ='gmdate("Y")' , int $is_dst = -1  ){}
/** @RETURN GMP */ function gmp_div_q ( GMP $a , GMP $b , int $round = GMP_ROUND_ZERO  ){}
/** @return array */ function gmp_div_qr ( GMP $n , GMP $d , int $round = GMP_ROUND_ZERO  ){}
/** @RETURN GMP */ function gmp_div_r ( GMP $n , GMP $d , int $round = GMP_ROUND_ZERO  ){}
/** @RETURN GMP */ function gmp_init ( mixed $number , int $base = 0  ){}
/** @return int */ function gmp_prob_prime ( GMP $a , int $reps = 10  ){}
/** @RETURN GMP */ function gmp_random ( int $limiter = 20  ){}
/** @return void */ function gmp_setbit ( GMP &$a , int $index , bool $bit_on = true  ){}
/** @return string */ function gmp_strval ( GMP $gmpnumber , int $base = 10  ){}
/** @return string */ function gmstrftime ( string $format , int $timestamp ='time()'  ){}
/** @return bool */ function gnupg_addsignkey ( resource $identifier , string $fingerprint , string $passphrase = null  ){}
/** @return array */ function gnupg_verify ( resource $identifier , string $signed_text , string $signature , string &$plaintext = null  ){}
/** @return resource */ function gupnp_context_new ( string $host_ip , int $port = 0  ){}
/** @return bool */ function gupnp_context_timeout_add ( resource $context , int $timeout , mixed $callback , mixed $arg = null  ){}
/** @return bool */ function gupnp_control_point_callback_set ( resource $cpoint , int $signal , mixed $callback , mixed $arg = null  ){}
/** @return bool */ function gupnp_device_action_callback_set ( resource $root_device , int $signal , string $action_name , mixed $callback , mixed $arg = null  ){}
/** @return bool */ function gupnp_service_action_return_error ( resource $action , int $error_code , string $error_description = null  ){}
/** @return mixed */ function gupnp_service_info_get_introspection ( resource $proxy , mixed $callback , mixed $arg = null  ){}
/** @return bool */ function gupnp_service_proxy_add_notify ( resource $proxy , string $value , int $type , mixed $callback , mixed $arg = null  ){}
/** @return bool */ function gupnp_service_proxy_callback_set ( resource $proxy , int $signal , mixed $callback , mixed $arg = null  ){}
/** @return string */ function gzcompress ( string $data , int $level = -1 , int $encoding = ZLIB_ENCODING_DEFLATE  ){}
/** @return string */ function gzdecode ( string $data , int $length = null  ){}
/** @return string */ function gzdeflate ( string $data , int $level = -1 , int $encoding = ZLIB_ENCODING_RAW  ){}
/** @return string */ function gzencode ( string $data , int $level = -1 , int $encoding_mode = FORCE_GZIP  ){}
/** @return array */ function gzfile ( string $filename , int $use_include_path = 0  ){}
/** @return string */ function gzgets ( resource $zp , int $length = null  ){}
/** @return string */ function gzgetss ( resource $zp , int $length , string $allowable_tags = null  ){}
/** @return string */ function gzinflate ( string $data , int $length = 0  ){}
/** @return resource */ function gzopen ( string $filename , string $mode , int $use_include_path = 0  ){}
/** @return int */ function gzseek ( resource $zp , int $offset , int $whence = SEEK_SET  ){}
/** @return string */ function gzuncompress ( string $data , int $length = 0  ){}
/** @return int */ function gzwrite ( resource $zp , string $string , int $length = null  ){}
/** @return string */ function hash_file ( string $algo , string $filename , bool $raw_output = false  ){}
/** @return string */ function hash_final ( resource $context , bool $raw_output = false  ){}
/** @return string */ function hash_hmac_file ( string $algo , string $filename , string $key , bool $raw_output = false  ){}
/** @return string */ function hash_hmac ( string $algo , string $data , string $key , bool $raw_output = false  ){}
/** @return string */ function hash ( string $algo , string $data , bool $raw_output = false  ){}
/** @return resource */ function hash_init ( string $algo , int $options = 0 , string $key = NULL  ){}
/** @return string */ function hash_pbkdf2 ( string $algo , string $password , string $salt , int $iterations , int $length = 0 , bool $raw_output = false  ){}
/** @return bool */ function hash_update_file ( resource $hcontext , string $filename , resource $scontext = NULL  ){}
/** @return int */ function hash_update_stream ( resource $context , resource $handle , int $length = -1  ){}
/** @return void */ function header ( string $string , bool $replace = true , int $http_response_code = null  ){}
/** @return void */ function header_remove ( string $name = null  ){}
/** @return bool */ function headers_sent ( string &$file , int &$line = null  ){}
/** @return string */ function hebrevc ( string $hebrew_text , int $max_chars_per_line = 0  ){}
/** @return string */ function hebrev ( string $hebrew_text , int $max_chars_per_line = 0  ){}
/** @return mixed */ function highlight_file ( string $filename , bool $return = false  ){}
/** @return mixed */ function highlight_string ( string $str , bool $return = false  ){}
/** @return string */ function htmlentities ( string $string , int $flags = ENT_COMPAT | ENT_HTML401 , string $encoding = 'ini_get("default_charset")' , bool $double_encode = true  ){}
/** @return string */ function html_entity_decode ( string $string , int $flags = ENT_COMPAT | ENT_HTML401 , string $encoding = 'ini_get("default_charset")'  ){}
/** @return string */ function htmlspecialchars_decode ( string $string , int $flags = ENT_COMPAT | ENT_HTML401  ){}
/** @return string */ function htmlspecialchars ( string $string , int $flags = ENT_COMPAT | ENT_HTML401 , string $encoding = 'ini_get("default_charset")' , bool $double_encode = true  ){}
/** @return string */ function http_build_query ( mixed $query_data , string $numeric_prefix , string $arg_separator , int $enc_type = PHP_QUERY_RFC1738  ){}
/** @return string */ function http_build_str ( array $query , string $prefix , string $arg_separator = 'ini_get("arg_separator.output")'  ){}
/** @return string */ function http_build_url ( mixed $url , mixed $parts , int $flags = HTTP_URL_REPLACE , array &$new_url = null  ){}
/** @return bool */ function http_cache_etag ( string $etag = null  ){}
/** @return bool */ function http_cache_last_modified ( int $timestamp_or_expires = null  ){}
/** @return string */ function http_date ( int $timestamp = null  ){}
/** @return string */ function http_deflate ( string $data , int $flags = 0  ){}
/** @return string */ function http_get ( string $url , array $options , array &$info = null  ){}
/** @return string */ function http_head ( string $url , array $options , array &$info = null  ){}
/** @return bool */ function http_match_etag ( string $etag , bool $for_range = false  ){}
/** @return bool */ function http_match_modified ( int $timestamp = -1 , bool $for_range = false  ){}
/** @return bool */ function http_match_request_header ( string $header , string $value , bool $match_case = false  ){}
/** @return string */ function http_negotiate_charset ( array $supported , array &$result = null  ){}
/** @return string */ function http_negotiate_content_type ( array $supported , array &$result = null  ){}
/** @return string */ function http_negotiate_language ( array $supported , array &$result = null  ){}
/** @return object */ function http_parse_cookie ( string $cookie , int $flags , array $allowed_extras = null  ){}
/** @return object */ function http_parse_params ( string $param , int $flags = HTTP_PARAMS_DEFAULT  ){}
/** @return string */ function http_persistent_handles_clean ( string $ident = null  ){}
/** @return string */ function http_persistent_handles_ident ( string $ident = null  ){}
/** @return string */ function http_post_data ( string $url , string $data , array $options , array &$info = null  ){}
/** @return string */ function http_post_fields ( string $url , array $data , array $files , array $options , array &$info = null  ){}
/** @return string */ function http_put_data ( string $url , string $data , array $options , array &$info = null  ){}
/** @return string */ function http_put_file ( string $url , string $file , array $options , array &$info = null  ){}
/** @return string */ function http_put_stream ( string $url , resource $stream , array $options , array &$info = null  ){}
/** @return bool */ function http_redirect ( string $url , array $params , bool $session = false , int $status = 0  ){}
/** @return string */ function http_request ( int $method , string $url , string $body , array $options , array &$info = null  ){}
/** @return int */ function http_response_code ( int $response_code = null  ){}
/** @return bool */ function http_send_content_disposition ( string $filename , bool $inline = false  ){}
/** @return bool */ function http_send_content_type ( string $content_type = "application/x-octetstream"  ){}
/** @return bool */ function http_send_last_modified ( int $timestamp ='time()'  ){}
/** @return int */ function http_support ( int $feature = 0  ){}
/** @return void */ function http_throttle ( float $sec , int $bytes = 40960  ){}
/** @RETURN HW_API_Attribute */ function  hwapi_attribute_new ( string $name , string $value = null  ){}
/** @RETURN HW_API  */ function hwapi_hgcsp ( string $hostname , int $port = null  ){}
/** @return bool */ function ibase_add_user ( resource $service_handle , string $user_name , string $password , string $first_name , string $middle_name , string $last_name = null  ){}
/** @return int */ function ibase_affected_rows ( resource $link_identifier = null  ){}
/** @return mixed */ function ibase_backup ( resource $service_handle , string $source_db , string $dest_file , int $options = 0 , bool $verbose = false  ){}
/** @return resource */ function ibase_blob_create ( resource $link_identifier = NULL  ){}
/** @return bool */ function ibase_close ( resource $connection_id = NULL  ){}
/** @return bool */ function ibase_commit ( resource $link_or_trans_identifier = NULL  ){}
/** @return bool */ function ibase_commit_ret ( resource $link_or_trans_identifier = NULL  ){}
/** @return resource */ function ibase_connect ( string $database , string $username , string $password , string $charset , int $buffers , int $dialect , string $role , int $sync = null  ){}
/** @return string */ function ibase_db_info ( resource $service_handle , string $db , int $action , int $argument = 0  ){}
/** @return bool */ function ibase_drop_db ( resource $connection = NULL  ){}
/** @return resource */ function ibase_execute ( resource $query , mixed $bind_arg , mixed $__args__ = null  ){}
/** @return array */ function ibase_fetch_assoc ( resource $result , int $fetch_flag = 0  ){}
/** @return object */ function ibase_fetch_object ( resource $result_id , int $fetch_flag = 0  ){}
/** @return array */ function ibase_fetch_row ( resource $result_identifier , int $fetch_flag = 0  ){}
/** @return mixed */ function ibase_gen_id ( string $generator , int $increment = 1 , resource $link_identifier = NULL  ){}
/** @return bool */ function ibase_maintain_db ( resource $service_handle , string $db , int $action , int $argument = 0  ){}
/** @return bool */ function ibase_modify_user ( resource $service_handle , string $user_name , string $password , string $first_name , string $middle_name , string $last_name = null  ){}
/** @return resource */ function ibase_pconnect ( string $database , string $username , string $password , string $charset , int $buffers , int $dialect , string $role , int $sync = null  ){}
/** @return resource */ function ibase_query ( resource $link_identifier = null , string $query , int $bind_args = null  ){}
/** @return mixed */ function ibase_restore ( resource $service_handle , string $source_file , string $dest_db , int $options = 0 , bool $verbose = false  ){}
/** @return bool */ function ibase_rollback ( resource $link_or_trans_identifier = NULL  ){}
/** @return bool */ function ibase_rollback_ret ( resource $link_or_trans_identifier = NULL  ){}
/** @return resource */ function ibase_set_event_handler ( callable $event_handler , string $event_name1 , string $event_name2 , string $__args__ = null  ){}
/** @return resource */ function ibase_trans ( int $trans_args , resource $link_identifier = null  ){}
/** @return string */ function ibase_wait_event ( string $event_name1 , string $event_name2 , string $__args__ = null  ){}
/** @return mixed */ function iconv_get_encoding ( string $type = "all"  ){}
/** @return array */ function iconv_mime_decode_headers ( string $encoded_headers , int $mode = 0 , string $charset = 'ini_get("iconv.internal_encoding")'  ){}
/** @return string */ function iconv_mime_decode ( string $encoded_header , int $mode = 0 , string $charset = 'ini_get("iconv.internal_encoding")'  ){}
/** @return string */ function iconv_mime_encode ( string $field_name , string $field_value , array $preferences = NULL  ){}
/** @return int */ function iconv_strlen ( string $str , string $charset = 'ini_get("iconv.internal_encoding")'  ){}
/** @return int */ function iconv_strpos ( string $haystack , string $needle , int $offset = 0 , string $charset = 'ini_get("iconv.internal_encoding")'  ){}
/** @return int */ function iconv_strrpos ( string $haystack , string $needle , string $charset = 'ini_get("iconv.internal_encoding")'  ){}
/** @return string */ function iconv_substr ( string $str , int $offset , int $length ='iconv_strlen($str, $charset)' , string $charset = 'ini_get("iconv.internal_encoding")'  ){}
/** @return array */ function id3_get_tag ( string $filename , int $version = ID3_BEST  ){}
/** @return bool */ function id3_remove_tag ( string $filename , int $version = ID3_V1_0  ){}
/** @return bool */ function id3_set_tag ( string $filename , array $tag , int $version = ID3_V1_0  ){}
/** @return int */ function idate ( string $format , int $timestamp ='time()'  ){}
/** @return bool */ function ifx_close ( resource $link_identifier = null  ){}
/** @return resource */ function ifx_connect ( string $database , string $userid , string $password = null  ){}
/** @return string */ function ifx_error ( resource $link_identifier = null  ){}
/** @return string */ function ifx_errormsg ( int $errorcode = null  ){}
/** @return array */ function ifx_fetch_row ( resource $result_id , mixed $position = null  ){}
/** @return int */ function ifx_htmltbl_result ( resource $result_id , string $html_table_options = null  ){}
/** @return resource */ function ifx_pconnect ( string $database , string $userid , string $password = null  ){}
/** @return resource */ function ifx_prepare ( string $query , resource $link_identifier , int $cursor_def = null , mixed $blobidarray ){}
/** @return resource */ function ifx_query ( string $query , resource $link_identifier , int $cursor_type , mixed $blobidarray = null  ){}
/** @return int */ function ignore_user_abort ( string $value = null  ){}
/** @return bool */ function image2wbmp ( resource $image , string $filename , int $threshold = null  ){}
/** @return resource */ function imageaffine ( resource $image , array $affine , array $clip = null  ){}
/** @return array */ function imageaffinematrixget ( int $type , mixed $options = null  ){}
/** @return void */ function imagecolorset ( resource $image , int $index , int $red , int $green , int $blue , int $alpha = 0  ){}
/** @return int */ function imagecolortransparent ( resource $image , int $color = null  ){}
/** @return resource */ function imagecropauto ( resource $image , int $mode = -1 , float $threshold = .5 , int $color = -1  ){}
/** @return bool */ function imagefilter ( resource $image , int $filtertype , int $arg1 , int $arg2 , int $arg3 , int $arg4 = null  ){}
/** @return array */ function imageftbbox ( float $size , float $angle , string $fontfile , string $text , array $extrainfo = null  ){}
/** @return array */ function imagefttext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text , array $extrainfo = null  ){}
/** @return bool */ function imagegd2 ( resource $image , string $filename , int $chunk_size , int $type = IMG_GD2_RAW  ){}
/** @return bool */ function imagegd ( resource $image , string $filename = null  ){}
/** @return bool */ function imagegif ( resource $image , string $filename = null  ){}
/** @return resource */ function imagegrabwindow ( int $window_handle , int $client_area = 0  ){}
/** @return int */ function imageinterlace ( resource $image , int $interlace = 0  ){}
/** @return bool */ function imagejpeg ( resource $image , string $filename , int $quality = null  ){}
/** @return bool */ function imagepng ( resource $image , string $filename , int $quality , int $filters = null  ){}
/** @return array */ function imagepstext ( resource $image , string $text , resource $font_index , int $size , int $foreground , int $background , int $x , int $y , int $space = 0 , int $tightness = 0 , float $angle = 0.0 , int $antialias_steps = 4  ){}
/** @return resource */ function imagerotate ( resource $image , float $angle , int $bgd_color , int $ignore_transparent = 0  ){}
/** @return resource */ function imagescale ( resource $image , int $new_width , int $new_height = -1 , int $mode = IMG_BILINEAR_FIXED  ){}
/** @return bool */ function imagesetinterpolation ( resource $image , int $method = IMG_BILINEAR_FIXED  ){}
/** @return string */ function image_type_to_extension ( int $imagetype , bool $include_dot = TRUE  ){}
/** @return bool */ function imagewbmp ( resource $image , string $filename , int $foreground = null  ){}
/** @return bool */ function imagexbm ( resource $image , string $filename , int $foreground = null  ){}
/** @return bool */ function imap_append ( resource $imap_stream , string $mailbox , string $message , string $options = NULL , string $internal_date = NULL  ){}
/** @return string */ function imap_body ( resource $imap_stream , int $msg_number , int $options = 0  ){}
/** @return bool */ function imap_clearflag_full ( resource $imap_stream , string $sequence , string $flag , int $options = 0  ){}
/** @return bool */ function imap_close ( resource $imap_stream , int $flag = 0  ){}
/** @return bool */ function imap_delete ( resource $imap_stream , int $msg_number , int $options = 0  ){}
/** @return string */ function imap_fetchbody ( resource $imap_stream , int $msg_number , string $section , int $options = 0  ){}
/** @return string */ function imap_fetchheader ( resource $imap_stream , int $msg_number , int $options = 0  ){}
/** @return string */ function imap_fetchmime ( resource $imap_stream , int $msg_number , string $section , int $options = 0  ){}
/** @return array */ function imap_fetch_overview ( resource $imap_stream , string $sequence , int $options = 0  ){}
/** @return object */ function imap_fetchstructure ( resource $imap_stream , int $msg_number , int $options = 0  ){}
/** @return object */ function imap_headerinfo ( resource $imap_stream , int $msg_number , int $fromlength = 0 , int $subjectlength = 0 , string $defaulthost = NULL  ){}
/** @return bool */ function imap_mail_copy ( resource $imap_stream , string $msglist , string $mailbox , int $options = 0  ){}
/** @return bool */ function imap_mail ( string $to , string $subject , string $message , string $additional_headers = NULL , string $cc = NULL , string $bcc = NULL , string $rpath = NULL  ){}
/** @return bool */ function imap_mail_move ( resource $imap_stream , string $msglist , string $mailbox , int $options = 0  ){}
/** @return resource */ function imap_open ( string $mailbox , string $username , string $password , int $options = 0 , int $n_retries = 0 , array $params = NULL  ){}
/** @return bool */ function imap_reopen ( resource $imap_stream , string $mailbox , int $options = 0 , int $n_retries = 0  ){}
/** @return object */ function imap_rfc822_parse_headers ( string $headers , string $defaulthost = "UNKNOWN"  ){}
/** @return bool */ function imap_savebody ( resource $imap_stream , mixed $file , int $msg_number , string $part_number = "" , int $options = 0  ){}
/** @return array */ function imap_search ( resource $imap_stream , string $criteria , int $options = SE_FREE , string $charset = NIL  ){}
/** @return bool */ function imap_setflag_full ( resource $imap_stream , string $sequence , string $flag , int $options = NIL  ){}
/** @return array */ function imap_sort ( resource $imap_stream , int $criteria , int $reverse , int $options = 0 , string $search_criteria = NULL , string $charset = NIL  ){}
/** @return array */ function imap_thread ( resource $imap_stream , int $options = SE_FREE  ){}
/** @return mixed */ function imap_timeout ( int $timeout_type , int $timeout = -1  ){}
/** @return bool */ function imap_undelete ( resource $imap_stream , int $msg_number , int $flags = 0  ){}
/** @return bool */ function import_request_variables ( string $types , string $prefix = null  ){}
/** @return bool */ function in_array ( mixed $needle , array $haystack , bool $strict = FALSE  ){}
/** @return resource */ function ingres_connect ( string $database , string $username , string $password , array $options = null  ){}
/** @return int */ function ingres_errno ( resource $link = null  ){}
/** @return string */ function ingres_error ( resource $link = null  ){}
/** @return string */ function ingres_errsqlstate ( resource $link = null  ){}
/** @return bool */ function ingres_execute ( resource $result , array $params , string $types = null  ){}
/** @return array */ function ingres_fetch_array ( resource $result , int $result_type = null  ){}
/** @return object */ function ingres_fetch_object ( resource $result , int $result_type = null  ){}
/** @return bool */ function ingres_next_error ( resource $link = null  ){}
/** @return resource */ function ingres_pconnect ( string $database , string $username , string $password , array $options = null  ){}
/** @return mixed */ function ingres_query ( resource $link , string $query , array $params , string $types = null  ){}
/** @return mixed */ function ingres_unbuffered_query ( resource $link , string $query , array $params , string $types = null  ){}
/** @return array */ function ini_get_all ( string $extension , bool $details = true  ){}
/** @return bool */ function interface_exists ( string $interface_name , bool $autoload = true  ){}
/** @return int */ function intval ( mixed $var , int $base = 10  ){}
/** @return mixed */ function iptcembed ( string $iptcdata , string $jpeg_file_name , int $spool = 0  ){}
/** @return bool */ function is_a ( object $object , string $class_name , bool $allow_string = FALSE  ){}
/** @return bool */ function is_callable ( callable $name , bool $syntax_only = false , string &$callable_name = null  ){}
///** @return bool */ function isset ( mixed $var , mixed $__args__ = null  ){}
/** @return bool */ function is_subclass_of ( mixed $object , string $class_name , bool $allow_string = TRUE  ){}
/** @return int */ function iterator_apply ( Traversable $iterator , callable $function , array $args = null  ){}
/** @return array */ function iterator_to_array ( Traversable $iterator , bool $use_keys = true  ){}
/** @return mixed */ function jddayofweek ( int $julianday , int $mode = CAL_DOW_DAYNO  ){}
/** @return string */ function jdtojewish ( int $juliandaycount , bool $hebrew = false , int $fl = 0  ){}
/** @return mixed */ function json_decode ( string $json , bool $assoc = false , int $depth = 512 , int $options = 0  ){}
/** @return string */ function json_encode ( mixed $value , int $options = 0 , int $depth = 512  ){}
/** @return bool */ function kadm5_create_principal ( resource $handle , string $principal , string $password , array $options = null  ){}
/** @return bool */ function krsort ( array &$array , int $sort_flags = SORT_REGULAR  ){}
/** @return bool */ function ksort ( array &$array , int $sort_flags = SORT_REGULAR  ){}
/** @return bool */ function ldap_bind ( resource $link_identifier , string $bind_rdn = NULL , string $bind_password = NULL  ){}
/** @return resource */ function ldap_connect ( string $hostname = NULL , int $port = 389  ){}
/** @return bool */ function ldap_control_paged_result ( resource $link , int $pagesize , bool $iscritical = false , string $cookie = ""  ){}
/** @return bool */ function ldap_control_paged_result_response ( resource $link , resource $result , string &$cookie , int &$estimated = null  ){}
/** @return string */ function ldap_escape ( string $value , string $ignore , int $flags = null  ){}
/** @return resource */ function ldap_list ( resource $link_identifier , string $base_dn , string $filter , array $attributes , int $attrsonly , int $sizelimit , int $timelimit , int $deref = null  ){}
/** @return bool */ function ldap_parse_result ( resource $link , resource $result , int &$errcode , string &$matcheddn , string &$errmsg , array &$referrals = null  ){}
/** @return resource */ function ldap_read ( resource $link_identifier , string $base_dn , string $filter , array $attributes , int $attrsonly , int $sizelimit , int $timelimit , int $deref = null  ){}
/** @return bool */ function ldap_sasl_bind ( resource $link , string $binddn = NULL , string $password = NULL , string $sasl_mech = NULL , string $sasl_realm = NULL , string $sasl_authc_id = NULL , string $sasl_authz_id = NULL , string $props = NULL  ){}
/** @return resource */ function ldap_search ( resource $link_identifier , string $base_dn , string $filter , array $attributes , int $attrsonly , int $sizelimit , int $timelimit , int $deref = null  ){}
/** @return bool */ function libxml_disable_entity_loader ( bool $disable = true  ){}
/** @return bool */ function libxml_use_internal_errors ( bool $use_errors = false  ){}
///** @return array */ function list ( mixed $var1 , mixed $__args__ = null  ){}
/** @return array */ function localtime ( int $timestamp ='time()' , bool $is_associative = false  ){}
/** @return float */ function log ( float $arg , float $base = M_E  ){}
/** @return string */ function ltrim ( string $str , string $character_mask = null  ){}
/** @return bool */ function mail ( string $to , string $subject , string $message , string $additional_headers , string $additional_parameters = null  ){}
/** @return string */ function mailparse_msg_extract_part_file ( resource $mimemail , mixed $filename , callable $callbackfunc = null  ){}
/** @return void */ function mailparse_msg_extract_part ( resource $mimemail , string $msgbody , callable $callbackfunc = null  ){}
/** @return string */ function mailparse_msg_extract_whole_part_file ( resource $mimemail , string $filename , callable $callbackfunc = null  ){}
/** @return resource */ function maxdb_embedded_connect ( string $dbname = null  ){}
/** @return bool */ function maxdb_server_init ( array $server , array $groups = null  ){}
/** @return bool */ function mb_check_encoding ( string $var = NULL , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_convert_case ( string $str , int $mode , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_convert_encoding ( string $str , string $to_encoding , mixed $from_encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_convert_kana ( string $str , string $option = "KV" , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_convert_variables ( string $to_encoding , mixed $from_encoding , mixed &$vars , mixed &$__args__ = null  ){}
/** @return string */ function mb_decode_numericentity ( string $str , array $convmap , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_detect_encoding ( string $str , mixed $encoding_list ='mb_detect_order()' , bool $strict = false  ){}
/** @return mixed */ function mb_detect_order ( mixed $encoding_list ='mb_detect_order()'  ){}
/** @return string */ function mb_encode_mimeheader ( string $str , string $charset ='mb_internal_encoding()' , string $transfer_encoding = "B" , string $linefeed = "\r\n" , int $indent = 0  ){}
/** @return string */ function mb_encode_numericentity ( string $str , array $convmap , string $encoding ='mb_internal_encoding()' , bool $is_hex = FALSE  ){}
/** @return int */ function mb_ereg ( string $pattern , string $string , array $regs = null  ){}
/** @return int */ function mb_eregi ( string $pattern , string $string , array $regs = null  ){}
/** @return string */ function mb_eregi_replace ( string $pattern , string $replace , string $string , string $option = "msri"  ){}
/** @return bool */ function mb_ereg_match ( string $pattern , string $string , string $option = "msr"  ){}
/** @return string */ function mb_ereg_replace_callback ( string $pattern , callable $callback , string $string , string $option = "msr"  ){}
/** @return string */ function mb_ereg_replace ( string $pattern , string $replacement , string $string , string $option = "msr"  ){}
/** @return bool */ function mb_ereg_search ( string $pattern , string $option = "ms"  ){}
/** @return bool */ function mb_ereg_search_init ( string $string , string $pattern , string $option = "msr"  ){}
/** @return array */ function mb_ereg_search_pos ( string $pattern , string $option = "ms"  ){}
/** @return array */ function mb_ereg_search_regs ( string $pattern , string $option = "ms"  ){}
/** @return mixed */ function mb_get_info ( string $type = "all"  ){}
/** @return mixed */ function mb_http_input ( string $type = ""  ){}
/** @return mixed */ function mb_http_output ( string $encoding ='mb_http_output()'  ){}
/** @return mixed */ function mb_internal_encoding ( string $encoding ='mb_internal_encoding()'  ){}
/** @return mixed */ function mb_language ( string $language ='mb_language()'  ){}
/** @return bool */ function mb_parse_str ( string $encoded_string , array &$result = null  ){}
/** @return mixed */ function mb_regex_encoding ( string $encoding ='mb_regex_encoding()'  ){}
/** @return string */ function mb_regex_set_options ( string $options ='mb_regex_set_options()'  ){}
/** @return bool */ function mb_send_mail ( string $to , string $subject , string $message , string $additional_headers = NULL , string $additional_parameter = NULL  ){}
/** @return array */ function mb_split ( string $pattern , string $string , int $limit = -1  ){}
/** @return string */ function mb_strcut ( string $str , int $start , int $length = NULL , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_strimwidth ( string $str , int $start , int $width , string $trimmarker = "" , string $encoding ='mb_internal_encoding()'  ){}
/** @return int */ function mb_stripos ( string $haystack , string $needle , int $offset = 0 , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_stristr ( string $haystack , string $needle , bool $before_needle = false , string $encoding ='mb_internal_encoding()'  ){}
/** @return mixed */ function mb_strlen ( string $str , string $encoding ='mb_internal_encoding()'  ){}
/** @return int */ function mb_strpos ( string $haystack , string $needle , int $offset = 0 , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_strrchr ( string $haystack , string $needle , bool $part = false , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_strrichr ( string $haystack , string $needle , bool $part = false , string $encoding ='mb_internal_encoding()'  ){}
/** @return int */ function mb_strripos ( string $haystack , string $needle , int $offset = 0 , string $encoding ='mb_internal_encoding()'  ){}
/** @return int */ function mb_strrpos ( string $haystack , string $needle , int $offset = 0 , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_strstr ( string $haystack , string $needle , bool $before_needle = false , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_strtolower ( string $str , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_strtoupper ( string $str , string $encoding ='mb_internal_encoding()'  ){}
/** @return int */ function mb_strwidth ( string $str , string $encoding ='mb_internal_encoding()'  ){}
/** @return mixed */ function mb_substitute_character ( mixed $substrchar ='mb_substitute_character()'  ){}
/** @return int */ function mb_substr_count ( string $haystack , string $needle , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mb_substr ( string $str , int $start , int $length = NULL , string $encoding ='mb_internal_encoding()'  ){}
/** @return string */ function mcrypt_cbc ( int $cipher , string $key , string $data , int $mode , string $iv = null  ){}
/** @return string */ function mcrypt_create_iv ( int $size , int $source = MCRYPT_DEV_URANDOM  ){}
/** @return string */ function mcrypt_decrypt ( string $cipher , string $key , string $data , string $mode , string $iv = null  ){}
/** @return string */ function mcrypt_encrypt ( string $cipher , string $key , string $data , string $mode , string $iv = null  ){}
/** @return array */ function mcrypt_list_algorithms ( string $lib_dir = 'ini_get("mcrypt.algorithms_dir")'  ){}
/** @return array */ function mcrypt_list_modes ( string $lib_dir = 'ini_get("mcrypt.modes_dir")'  ){}
/** @return int */ function mcrypt_module_get_algo_block_size ( string $algorithm , string $lib_dir = null  ){}
/** @return int */ function mcrypt_module_get_algo_key_size ( string $algorithm , string $lib_dir = null  ){}
/** @return array */ function mcrypt_module_get_supported_key_sizes ( string $algorithm , string $lib_dir = null  ){}
/** @return bool */ function mcrypt_module_is_block_algorithm ( string $algorithm , string $lib_dir = null  ){}
/** @return bool */ function mcrypt_module_is_block_algorithm_mode ( string $mode , string $lib_dir = null  ){}
/** @return bool */ function mcrypt_module_is_block_mode ( string $mode , string $lib_dir = null  ){}
/** @return bool */ function mcrypt_module_self_test ( string $algorithm , string $lib_dir = null  ){}
/** @return string */ function md5_file ( string $filename , bool $raw_output = false  ){}
/** @return string */ function md5 ( string $str , bool $raw_output = false  ){}
/** @return int */ function memory_get_peak_usage ( bool $real_usage = false  ){}
/** @return int */ function memory_get_usage ( bool $real_usage = false  ){}
/** @return string */ function metaphone ( string $str , int $phonemes = 0  ){}
/** @return string */ function mhash ( int $hash , string $data , string $key = null  ){}
/** @return mixed */ function microtime ( bool $get_as_float = false  ){}
/** @return bool */ function mkdir ( string $pathname , int $mode = 0777 , bool $recursive = false , resource $context = null  ){}
/** @return int */ function mktime ( int $hour ='date("H")' , int $minute ='date("i")' , int $second ='date("s")' , int $month ='date("n")' , int $day ='date("j")' , int $year ='date("Y")' , int $is_dst = -1  ){}
/** @return bool */ function msession_create ( string $session , string $classname , string $data = null  ){}
/** @return string */ function msession_plugin ( string $session , string $val , string $param = null  ){}
/** @return int */ function msession_timeout ( string $session , int $param = null  ){}
/** @return string */ function msession_uniq ( int $param , string $classname , string $data = null  ){}
/** @return resource */ function msg_get_queue ( int $key , int $perms = 0666  ){}
/** @return bool */ function msg_receive ( resource $queue , int $desiredmsgtype , int &$msgtype , int $maxsize , mixed &$message , bool $unserialize = true , int $flags = 0 , int &$errorcode = null  ){}
/** @return bool */ function msg_send ( resource $queue , int $msgtype , mixed $message , bool $serialize = true , bool $blocking = true , int &$errorcode = null  ){}
/** @return bool */ function msql_close ( resource $link_identifier = null  ){}
/** @return resource */ function msql_connect ( string $hostname = null  ){}
/** @return bool */ function msql_create_db ( string $database_name , resource $link_identifier = null  ){}
/** @return resource */ function msql_db_query ( string $database , string $query , resource $link_identifier = null  ){}
/** @return bool */ function msql_drop_db ( string $database_name , resource $link_identifier = null  ){}
/** @return array */ function msql_fetch_array ( resource $result , int $result_type = null  ){}
/** @return object */ function msql_fetch_field ( resource $result , int $field_offset = 0  ){}
/** @return resource */ function msql_list_dbs ( resource $link_identifier = null  ){}
/** @return resource */ function msql_list_fields ( string $database , string $tablename , resource $link_identifier = null  ){}
/** @return resource */ function msql_list_tables ( string $database , resource $link_identifier = null  ){}
/** @return resource */ function msql_pconnect ( string $hostname = null  ){}
/** @return resource */ function msql_query ( string $query , resource $link_identifier = null  ){}
/** @return string */ function msql_result ( resource $result , int $row , mixed $field = null  ){}
/** @return bool */ function msql_select_db ( string $database_name , resource $link_identifier = null  ){}
/** @return bool */ function mssql_bind ( resource $stmt , string $param_name , mixed &$var , int $type , bool $is_output = false , bool $is_null = false , int $maxlen = -1  ){}
/** @return bool */ function mssql_close ( resource $link_identifier = null  ){}
/** @return resource */ function mssql_connect ( string $servername , string $username , string $password , bool $new_link = false  ){}
/** @return mixed */ function mssql_execute ( resource $stmt , bool $skip_results = false  ){}
/** @return array */ function mssql_fetch_array ( resource $result , int $result_type = MSSQL_BOTH  ){}
/** @return object */ function mssql_fetch_field ( resource $result , int $field_offset = -1  ){}
/** @return int */ function mssql_field_length ( resource $result , int $offset = -1  ){}
/** @return string */ function mssql_field_name ( resource $result , int $offset = -1  ){}
/** @return string */ function mssql_field_type ( resource $result , int $offset = -1  ){}
/** @return string */ function mssql_guid_string ( string $binary , bool $short_format = false  ){}
/** @return resource */ function mssql_init ( string $sp_name , resource $link_identifier = null  ){}
/** @return resource */ function mssql_pconnect ( string $servername , string $username , string $password , bool $new_link = false  ){}
/** @return mixed */ function mssql_query ( string $query , resource $link_identifier , int $batch_size = 0  ){}
/** @return bool */ function mssql_select_db ( string $database_name , resource $link_identifier = null  ){}
/** @return void */ function mt_srand ( int $seed = null  ){}
/** @return int */ function mysql_affected_rows ( resource $link_identifier = NULL  ){}
/** @return string */ function mysql_client_encoding ( resource $link_identifier = NULL  ){}
/** @return bool */ function mysql_close ( resource $link_identifier = NULL  ){}
/** @return resource */ function mysql_connect ( string $server = 'ini_get("mysql.default_host")' , string $username = 'ini_get("mysql.default_user")' , string $password = 'ini_get("mysql.default_password")' , bool $new_link = false , int $client_flags = 0  ){}
/** @return bool */ function mysql_create_db ( string $database_name , resource $link_identifier = NULL  ){}
/** @return string */ function mysql_db_name ( resource $result , int $row , mixed $field = NULL  ){}
/** @return resource */ function mysql_db_query ( string $database , string $query , resource $link_identifier = NULL  ){}
/** @return bool */ function mysql_drop_db ( string $database_name , resource $link_identifier = NULL  ){}
/** @return int */ function mysql_errno ( resource $link_identifier = NULL  ){}
/** @return string */ function mysql_error ( resource $link_identifier = NULL  ){}
/** @return array */ function mysql_fetch_array ( resource $result , int $result_type = MYSQL_BOTH  ){}
/** @return object */ function mysql_fetch_field ( resource $result , int $field_offset = 0  ){}
/** @return object */ function mysql_fetch_object ( resource $result , string $class_name , array $params = null  ){}
/** @return string */ function mysql_get_host_info ( resource $link_identifier = NULL  ){}
/** @return int */ function mysql_get_proto_info ( resource $link_identifier = NULL  ){}
/** @return string */ function mysql_get_server_info ( resource $link_identifier = NULL  ){}
/** @return string */ function mysql_info ( resource $link_identifier = NULL  ){}
/** @return int */ function mysql_insert_id ( resource $link_identifier = NULL  ){}
/** @return resource */ function mysql_list_dbs ( resource $link_identifier = NULL  ){}
/** @return resource */ function mysql_list_fields ( string $database_name , string $table_name , resource $link_identifier = NULL  ){}
/** @return resource */ function mysql_list_processes ( resource $link_identifier = NULL  ){}
/** @return resource */ function mysql_list_tables ( string $database , resource $link_identifier = NULL  ){}
/** @return bool */ function mysqlnd_memcache_set ( mixed $mysql_connection , Memcached $memcache_connection , string $pattern , callback $callback = null  ){}
/** @return bool */ function mysqlnd_ms_set_qos ( mixed $connection , int $service_level , int $service_level_option , mixed $option_value = null  ){}
/** @return int */ function mysqlnd_ms_xa_begin ( mixed $connection , string $gtrid , int $timeout = null  ){}
/** @return int */ function mysqlnd_ms_xa_gc ( mixed $connection , string $gtrid , boolean $ignore_max_retries = null  ){}
/** @return bool */ function mysqlnd_uh_set_connection_proxy ( MysqlndUhConnection &$connection_proxy , mysqli &$mysqli_connection = null  ){}
/** @return resource */ function mysql_pconnect ( string $server = 'ini_get("mysql.default_host")' , string $username = 'ini_get("mysql.default_user")' , string $password = 'ini_get("mysql.default_password")' , int $client_flags = 0  ){}
/** @return bool */ function mysql_ping ( resource $link_identifier = NULL  ){}
/** @return mixed */ function mysql_query ( string $query , resource $link_identifier = NULL  ){}
/** @return string */ function mysql_real_escape_string ( string $unescaped_string , resource $link_identifier = NULL  ){}
/** @return string */ function mysql_result ( resource $result , int $row , mixed $field = 0  ){}
/** @return bool */ function mysql_select_db ( string $database_name , resource $link_identifier = NULL  ){}
/** @return bool */ function mysql_set_charset ( string $charset , resource $link_identifier = NULL  ){}
/** @return string */ function mysql_stat ( resource $link_identifier = NULL  ){}
/** @return int */ function mysql_thread_id ( resource $link_identifier = NULL  ){}
/** @return resource */ function mysql_unbuffered_query ( string $query , resource $link_identifier = NULL  ){}
/** @return int */ function ncurses_waddstr ( resource $window , string $str , int $n = null  ){}
/** @return int */ function newt_centered_window ( int $width , int $height , string $title = null  ){}
/** @return resource */ function newt_checkbox ( int $left , int $top , string $text , string $def_value , string $seq = null  ){}
/** @return void */ function newt_checkbox_tree_add_item ( resource $checkboxtree , string $text , mixed $data , int $flags , int $index , int $__args__ = null  ){}
/** @return resource */ function newt_checkbox_tree ( int $left , int $top , int $height , int $flags = null  ){}
/** @return resource */ function newt_checkbox_tree_multi ( int $left , int $top , int $height , string $seq , int $flags = null  ){}
/** @return resource */ function newt_entry ( int $left , int $top , int $width , string $init_value , int $flags = null  ){}
/** @return void */ function newt_entry_set ( resource $entry , string $value , bool $cursor_at_end = null  ){}
/** @return resource */ function newt_form ( resource $vert_bar , string $help , int $flags = null  ){}
/** @return void */ function newt_form_watch_fd ( resource $form , resource $stream , int $flags = null  ){}
/** @return resource */ function newt_grid_h_close_stacked ( int $element1_type , resource $element1 , int $__args__ , resource $__args__ = null  ){}
/** @return resource */ function newt_grid_h_stacked ( int $element1_type , resource $element1 , int $__args__ , resource $__args__ = null  ){}
/** @return void */ function newt_grid_set_field ( resource $grid , int $col , int $row , int $type , resource $val , int $pad_left , int $pad_top , int $pad_right , int $pad_bottom , int $anchor , int $flags = null  ){}
/** @return resource */ function newt_grid_v_close_stacked ( int $element1_type , resource $element1 , int $__args__ , resource $__args__ = null  ){}
/** @return resource */ function newt_grid_v_stacked ( int $element1_type , resource $element1 , int $__args__ , resource $__args__ = null  ){}
/** @return resource */ function newt_listbox ( int $left , int $top , int $height , int $flags = null  ){}
/** @return resource */ function newt_listitem ( int $left , int $top , string $text , bool $is_default , resouce $prev_item , mixed $data , int $flags = null  ){}
/** @return int */ function newt_open_window ( int $left , int $top , int $width , int $height , string $title = null  ){}
/** @return void */ function newt_push_help_line ( string $text = null  ){}
/** @return resource */ function newt_radiobutton ( int $left , int $top , string $text , bool $is_default , resource $prev_button = null  ){}
/** @return void */ function newt_resize_screen ( bool $redraw = null  ){}
/** @return resource */ function newt_textbox ( int $left , int $top , int $width , int $height , int $flags = null  ){}
/** @return resource */ function newt_textbox_reflowed ( int $left , int $top , char $text , int $width , int $flex_down , int $flex_up , int $flags = null  ){}
/** @return resource */ function newt_vertical_scrollbar ( int $left , int $top , int $height , int $normal_colorset , int $thumb_colorset = null  ){}
/** @return int */ function newt_win_choice ( string $title , string $button1_text , string $button2_text , string $format , mixed $args , mixed $__args__ = null  ){}
/** @return int */ function newt_win_entries ( string $title , string $text , int $suggested_width , int $flex_down , int $flex_up , int $data_width , array &$items , string $button1 , string $__args__ = null  ){}
/** @return int */ function newt_win_menu ( string $title , string $text , int $suggestedWidth , int $flexDown , int $flexUp , int $maxListHeight , array $items , int &$listItem , string $button1 , string $__args__ = null  ){}
/** @return void */ function newt_win_message ( string $title , string $button_text , string $format , mixed $args , mixed $__args__ = null  ){}
/** @return int */ function newt_win_ternary ( string $title , string $button1_text , string $button2_text , string $button3_text , string $format , mixed $args , mixed $__args__ = null  ){}
/** @return string */ function nl2br ( string $string , bool $is_xhtml = true  ){}
/** @return string */ function number_format ( float $number , int $decimals = 0  ){}
/** @return string */ function oauth_get_sbs ( string $http_method , string $uri , array $request_parameters = null  ){}
/** @return array */ function ob_get_status ( bool $full_status  = FALSE  ){}
/** @return void */ function ob_implicit_flush ( int $flag = true  ){}
/** @return bool */ function ob_start ( callable $output_callback = NULL , int $chunk_size = 0 , int $flags = PHP_OUTPUT_HANDLER_STDFLAGS  ){}
/** @return string */ function ob_tidyhandler ( string $input , int $mode = null  ){}
/** @return bool */ function oci_bind_array_by_name ( resource $statement , string $name , array &$var_array , int $max_table_length , int $max_item_length = -1 , int $type = SQLT_AFC  ){}
/** @return bool */ function oci_bind_by_name ( resource $statement , string $bv_name , mixed &$variable , int $maxlength = -1 , int $type = SQLT_CHR  ){}
/** @return resource */ function oci_connect ( string $username , string $password , string $connection_string , string $character_set , int $session_mode = null  ){}
/** @return bool */ function oci_define_by_name ( resource $statement , string $column_name , mixed &$variable , int $type = SQLT_CHR  ){}
/** @return array */ function oci_error ( resource $resource = null  ){}
/** @return bool */ function oci_execute ( resource $statement , int $mode = OCI_COMMIT_ON_SUCCESS  ){}
/** @return int */ function oci_fetch_all ( resource $statement , array &$output , int $skip = 0 , int $maxrows = -1 , int $flags = OCI_FETCHSTATEMENT_BY_COLUMN + OCI_ASSOC  ){}
/** @return array */ function oci_fetch_array ( resource $statement , int $mode = null  ){}
/** @return bool */ function oci_lob_copy ( OCI_Lob $lob_to , OCI_Lob $lob_from , int $length = 0  ){}
/** @RETURN OCI_Collection */ function oci_new_collection ( resource $connection , string $tdo , string $schema = NULL  ){}
/** @return resource */ function oci_new_connect ( string $username , string $password , string $connection_string , string $character_set , int $session_mode = null  ){}
/** @RETURN OCI_Lob */ function oci_new_descriptor ( resource $connection , int $type = OCI_DTYPE_LOB  ){}
/** @return resource */ function oci_pconnect ( string $username , string $password , string $connection_string , string $character_set , int $session_mode = null  ){}
/** @return mixed */ function odbc_autocommit ( resource $connection_id , bool $OnOff = false  ){}
/** @return resource */ function odbc_columns ( resource $connection_id , string $qualifier , string $schema , string $table_name , string $column_name = null  ){}
/** @return resource */ function odbc_connect ( string $dsn , string $user , string $password , int $cursor_type = null  ){}
/** @return string */ function odbc_error ( resource $connection_id = null  ){}
/** @return string */ function odbc_errormsg ( resource $connection_id = null  ){}
/** @return resource */ function odbc_exec ( resource $connection_id , string $query_string , int $flags = null  ){}
/** @return bool */ function odbc_execute ( resource $result_id , array $parameters_array = null  ){}
/** @return array */ function odbc_fetch_array ( resource $result , int $rownumber = null  ){}
/** @return int */ function odbc_fetch_into ( resource $result_id , array &$result_array , int $rownumber = null  ){}
/** @return object */ function odbc_fetch_object ( resource $result , int $rownumber = null  ){}
/** @return bool */ function odbc_fetch_row ( resource $result_id , int $row_number = null  ){}
/** @return resource */ function odbc_gettypeinfo ( resource $connection_id , int $data_type = null  ){}
/** @return resource */ function odbc_pconnect ( string $dsn , string $user , string $password , int $cursor_type = null  ){}
/** @return int */ function odbc_result_all ( resource $result_id , string $format = null  ){}
/** @return resource */ function odbc_tables ( resource $connection_id , string $qualifier , string $owner , string $name , string $types = null  ){}
/** @return array */ function opcache_get_status ( boolean $get_scripts = TRUE  ){}
/** @return boolean */ function opcache_invalidate ( string $script , boolean $force = FALSE  ){}
/** @return resource */ function openal_device_open ( string $device_desc = null  ){}
/** @return resource */ function opendir ( string $path , resource $context = null  ){}
/** @return bool */ function openssl_csr_export ( resource $csr , string &$out , bool $notext = true  ){}
/** @return bool */ function openssl_csr_export_to_file ( resource $csr , string $outfilename , bool $notext = true  ){}
/** @return resource */ function openssl_csr_get_public_key ( mixed $csr , bool $use_shortnames = true  ){}
/** @return array */ function openssl_csr_get_subject ( mixed $csr , bool $use_shortnames = true  ){}
/** @return mixed */ function openssl_csr_new ( array $dn , resource &$privkey , array $configargs , array $extraattribs = null  ){}
/** @return resource */ function openssl_csr_sign ( mixed $csr , mixed $cacert , mixed $priv_key , int $days , array $configargs , int $serial = 0  ){}
/** @return string */ function openssl_decrypt ( string $data , string $method , string $password , int $options = 0 , string $iv = ""  ){}
/** @return string */ function openssl_digest ( string $data , string $method , bool $raw_output = false  ){}
/** @return string */ function openssl_encrypt ( string $data , string $method , string $password , int $options = 0 , string $iv = ""  ){}
/** @return array */ function openssl_get_cipher_methods ( bool $aliases = false  ){}
/** @return array */ function openssl_get_md_methods ( bool $aliases = false  ){}
/** @return bool */ function openssl_open ( string $sealed_data , string &$open_data , string $env_key , mixed $priv_key_id , string $method = null  ){}
/** @return string */ function openssl_pbkdf2 ( string $password , string $salt , int $key_length , int $iterations , string $digest_algorithm = null  ){}
/** @return bool */ function openssl_pkcs12_export ( mixed $x509 , string &$out , mixed $priv_key , string $pass , array $args = null  ){}
/** @return bool */ function openssl_pkcs12_export_to_file ( mixed $x509 , string $filename , mixed $priv_key , string $pass , array $args = null  ){}
/** @return bool */ function openssl_pkcs7_decrypt ( string $infilename , string $outfilename , mixed $recipcert , mixed $recipkey = null  ){}
/** @return bool */ function openssl_pkcs7_encrypt ( string $infile , string $outfile , mixed $recipcerts , array $headers , int $flags = 0 , int $cipherid = OPENSSL_CIPHER_RC2_40  ){}
/** @return bool */ function openssl_pkcs7_sign ( string $infilename , string $outfilename , mixed $signcert , mixed $privkey , array $headers , int $flags = PKCS7_DETACHED , string $extracerts = null  ){}
/** @return mixed */ function openssl_pkcs7_verify ( string $filename , int $flags , string $outfilename , array $cainfo , string $extracerts , string $content = null  ){}
/** @return bool */ function openssl_pkey_export ( mixed $key , string &$out , string $passphrase , array $configargs = null  ){}
/** @return bool */ function openssl_pkey_export_to_file ( mixed $key , string $outfilename , string $passphrase , array $configargs = null  ){}
/** @return resource */ function openssl_pkey_get_private ( mixed $key , string $passphrase = ""  ){}
/** @return resource */ function openssl_pkey_new ( array $configargs = null  ){}
/** @return bool */ function openssl_private_decrypt ( string $data , string &$decrypted , mixed $key , int $padding = OPENSSL_PKCS1_PADDING  ){}
/** @return bool */ function openssl_private_encrypt ( string $data , string &$crypted , mixed $key , int $padding = OPENSSL_PKCS1_PADDING  ){}
/** @return bool */ function openssl_public_decrypt ( string $data , string &$decrypted , mixed $key , int $padding = OPENSSL_PKCS1_PADDING  ){}
/** @return bool */ function openssl_public_encrypt ( string $data , string &$crypted , mixed $key , int $padding = OPENSSL_PKCS1_PADDING  ){}
/** @return string */ function openssl_random_pseudo_bytes ( int $length , bool &$crypto_strong = null  ){}
/** @return int */ function openssl_seal ( string $data , string &$sealed_data , array &$env_keys , array $pub_key_ids , string $method = null  ){}
/** @return bool */ function openssl_sign ( string $data , string &$signature , mixed $priv_key_id , mixed $signature_alg = OPENSSL_ALGO_SHA1  ){}
/** @return string */ function openssl_spki_new ( resource &$privkey , string &$challenge , int $algorithm = 0  ){}
/** @return int */ function openssl_verify ( string $data , string $signature , mixed $pub_key_id , mixed $signature_alg = OPENSSL_ALGO_SHA1  ){}
/** @return int */ function openssl_x509_checkpurpose ( mixed $x509cert , int $purpose , array $cainfo ='array()' , string $untrustedfile = null  ){}
/** @return bool */ function openssl_x509_export ( mixed $x509 , string &$output , bool $notext = TRUE  ){}
/** @return bool */ function openssl_x509_export_to_file ( mixed $x509 , string $outfilename , bool $notext = TRUE  ){}
/** @return bool */ function openssl_x509_fingerprint ( mixed $x509 , string $hash_algorithm = "sha1" , bool $raw_output = FALSE  ){}
/** @return array */ function openssl_x509_parse ( mixed $x509cert , bool $shortnames = true  ){}
/** @return string */ function pack ( string $format , mixed $args , mixed $__args__ = null  ){}
/** @return array */ function parse_ini_file ( string $filename , bool $process_sections = false , int $scanner_mode = INI_SCANNER_NORMAL  ){}
/** @return array */ function parse_ini_string ( string $ini , bool $process_sections = false , int $scanner_mode = INI_SCANNER_NORMAL  ){}
/** @return array */ function parsekit_compile_file ( string $filename , array &$errors , int $options = PARSEKIT_QUIET  ){}
/** @return array */ function parsekit_compile_string ( string $phpcode , array &$errors , int $options = PARSEKIT_QUIET  ){}
/** @return void */ function parse_str ( string $str , array &$arr = null  ){}
/** @return mixed */ function parse_url ( string $url , int $component = -1  ){}
/** @return void */ function passthru ( string $command , int &$return_var = null  ){}
/** @return string */ function password_hash ( string $password , integer $algo , array $options = null  ){}
/** @return boolean */ function password_needs_rehash ( string $hash , integer $algo , array $options = null  ){}
/** @return mixed */ function pathinfo ( string $path , int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME  ){}
/** @return bool */ function pcntl_exec ( string $path , array $args , array $envs = null  ){}
/** @return int */ function pcntl_getpriority ( int $pid ='getmypid()' , int $process_identifier = PRIO_PROCESS  ){}
/** @return bool */ function pcntl_setpriority ( int $priority , int $pid ='getmypid()' , int $process_identifier = PRIO_PROCESS  ){}
/** @return bool */ function pcntl_signal ( int $signo , callable_int $handler , bool $restart_syscalls = true  ){}
/** @return bool */ function pcntl_sigprocmask ( int $how , array $set , array &$oldset = null  ){}
/** @return int */ function pcntl_sigtimedwait ( array $set , array &$siginfo , int $seconds = 0 , int $nanoseconds = 0  ){}
/** @return int */ function pcntl_sigwaitinfo ( array $set , array &$siginfo = null  ){}
/** @return int */ function pcntl_wait ( int &$status , int $options = 0  ){}
/** @return int */ function pcntl_waitpid ( int $pid , int &$status , int $options = 0  ){}
/** @return resource */ function pfsockopen ( string $hostname , int $port = -1 , int &$errno , string &$errstr , float $timeout = 'ini_get("default_socket_timeout")'  ){}
/** @return string */ function pg_client_encoding ( resource $connection = null  ){}
/** @return bool */ function pg_close ( resource $connection = null  ){}
/** @return resource */ function pg_connect ( string $connection_string , int $connect_type = null  ){}
/** @return int */ function pg_connect_poll ( resource $connection = null  ){}
/** @return array */ function pg_convert ( resource $connection , string $table_name , array $assoc_array , int $options = 0  ){}
/** @return bool */ function pg_copy_from ( resource $connection , string $table_name , array $rows , string $delimiter , string $null_as = null  ){}
/** @return array */ function pg_copy_to ( resource $connection , string $table_name , string $delimiter , string $null_as = null  ){}
/** @return string */ function pg_dbname ( resource $connection = null  ){}
/** @return mixed */ function pg_delete ( resource $connection , string $table_name , array $assoc_array , int $options = PGSQL_DML_EXEC  ){}
/** @return bool */ function pg_end_copy ( resource $connection = null  ){}
/** @return string */ function pg_escape_bytea ( resource $connection = null , string $data ){}
/** @return string */ function pg_escape_identifier ( resource $connection = null , string $data ){}
/** @return string */ function pg_escape_literal ( resource $connection = null , string $data ){}
/** @return string */ function pg_escape_string ( resource $connection = null , string $data ){}
/** @return resource */ function pg_execute ( resource $connection = null , string $stmtname , array $params ){}
/** @return array */ function pg_fetch_all_columns ( resource $result , int $column = 0  ){}
/** @return array */ function pg_fetch_array ( resource $result , int $row , int $result_type = PGSQL_BOTH  ){}
/** @return array */ function pg_fetch_assoc ( resource $result , int $row = null  ){}
/** @return object */ function pg_fetch_object ( resource $result , int $row , int $result_type = PGSQL_ASSOC  ){}
/** @return array */ function pg_fetch_row ( resource $result , int $row = null  ){}
/** @return mixed */ function pg_field_table ( resource $result , int $field_number , bool $oid_only = false  ){}
/** @return array */ function pg_get_notify ( resource $connection , int $result_type = null  ){}
/** @return resource */ function pg_get_result ( resource $connection = null  ){}
/** @return string */ function pg_host ( resource $connection = null  ){}
/** @return mixed */ function pg_insert ( resource $connection , string $table_name , array $assoc_array , int $options = PGSQL_DML_EXEC  ){}
/** @return string */ function pg_last_error ( resource $connection = null  ){}
/** @return int */ function pg_lo_create ( resource $connection , mixed $object_id = null  ){}
/** @return bool */ function pg_lo_export ( resource $connection = null , int $oid , string $pathname ){}
/** @return int */ function pg_lo_import ( resource $connection = null , string $pathname , mixed $object_id = null  ){}
/** @return string */ function pg_lo_read ( resource $large_object , int $len = 8192  ){}
/** @return bool */ function pg_lo_seek ( resource $large_object , int $offset , int $whence = PGSQL_SEEK_CUR  ){}
/** @return int */ function pg_lo_write ( resource $large_object , string $data , int $len = null  ){}
/** @return array */ function pg_meta_data ( resource $connection , string $table_name , bool $extended = null  ){}
/** @return string */ function pg_options ( resource $connection = null  ){}
/** @return string */ function pg_parameter_status ( resource $connection = null , string $param_name ){}
/** @return resource */ function pg_pconnect ( string $connection_string , int $connect_type = null  ){}
/** @return bool */ function pg_ping ( resource $connection = null  ){}
/** @return int */ function pg_port ( resource $connection = null  ){}
/** @return resource */ function pg_prepare ( resource $connection = null , string $stmtname , string $query ){}
/** @return bool */ function pg_put_line ( resource $connection = null , string $data ){}
/** @return resource */ function pg_query ( resource $connection = null , string $query ){}
/** @return resource */ function pg_query_params ( resource $connection = null , string $query , array $params ){}
/** @return mixed */ function pg_result_status ( resource $result , int $type = PGSQL_STATUS_LONG  ){}
/** @return mixed */ function pg_select ( resource $connection , string $table_name , array $assoc_array , int $options = PGSQL_DML_EXEC  ){}
/** @return int */ function pg_set_client_encoding ( resource $connection = null , string $encoding ){}
/** @return int */ function pg_set_error_verbosity ( resource $connection = null , int $verbosity ){}
/** @return bool */ function pg_trace ( string $pathname , string $mode = "w" , resource $connection = null  ){}
/** @return string */ function pg_tty ( resource $connection = null  ){}
/** @return bool */ function pg_untrace ( resource $connection = null  ){}
/** @return mixed */ function pg_update ( resource $connection , string $table_name , array $data , array $condition , int $options = PGSQL_DML_EXEC  ){}
/** @return array */ function pg_version ( resource $connection = null  ){}
/** @return bool */ function php_check_syntax ( string $filename , string &$error_message = null  ){}
/** @return bool */ function phpcredits ( int $flag = CREDITS_ALL  ){}
/** @return bool */ function phpinfo ( int $what = INFO_ALL  ){}
/** @return string */ function php_uname ( string $mode = "a"  ){}
/** @return string */ function phpversion ( string $extension = null  ){}
/** @return bool */ function posix_access ( string $file , int $mode = POSIX_F_OK  ){}
/** @return bool */ function posix_mknod ( string $pathname , int $mode , int $major = 0 , int $minor = 0  ){}
/** @return mixed */ function preg_filter ( mixed $pattern , mixed $replacement , mixed $subject , int $limit = -1 , int &$count = null  ){}
/** @return array */ function preg_grep ( string $pattern , array $input , int $flags = 0  ){}
/** @return int */ function preg_match_all ( string $pattern , string $subject , array &$matches , int $flags = PREG_PATTERN_ORDER , int $offset = 0  ){}
/** @return int */ function preg_match ( string $pattern , string $subject , array &$matches , int $flags = 0 , int $offset = 0  ){}
/** @return string */ function preg_quote ( string $str , string $delimiter = NULL  ){}
/** @return mixed */ function preg_replace_callback ( mixed $pattern , callable $callback , mixed $subject , int $limit = -1 , int &$count = null  ){}
/** @return mixed */ function preg_replace ( mixed $pattern , mixed $replacement , mixed $subject , int $limit = -1 , int &$count = null  ){}
/** @return array */ function preg_split ( string $pattern , string $subject , int $limit = -1 , int $flags = 0  ){}
/** @return int */ function printf ( string $format , mixed $args , mixed $__args__ = null  ){}
/** @return mixed */ function print_r ( mixed $expression , bool $return = false  ){}
/** @return resource */ function proc_open ( string $cmd , array $descriptorspec , array &$pipes , string $cwd , array $env , array $other_options = null  ){}
/** @return bool */ function proc_terminate ( resource $process , int $signal = 15  ){}
/** @return int */ function ps_add_bookmark ( resource $psdoc , string $text , int $parent = 0 , int $open = 0  ){}
/** @return int */ function ps_findfont ( resource $psdoc , string $fontname , string $encoding , bool $embed = false  ){}
/** @return string */ function ps_get_parameter ( resource $psdoc , string $name , float $modifier = null  ){}
/** @return float */ function ps_get_value ( resource $psdoc , string $name , float $modifier = null  ){}
/** @return int */ function ps_makespotcolor ( resource $psdoc , string $name , int $reserved = 0  ){}
/** @return bool */ function ps_open_file ( resource $psdoc , string $filename = null  ){}
/** @return int */ function ps_open_image_file ( resource $psdoc , string $type , string $filename , string $stringparam , int $intparam = 0  ){}
/** @return int */ function pspell_config_create ( string $language , string $spelling , string $jargon , string $encoding = null  ){}
/** @return int */ function pspell_new ( string $language , string $spelling , string $jargon , string $encoding , int $mode = 0  ){}
/** @return int */ function pspell_new_personal ( string $personal , string $language , string $spelling , string $jargon , string $encoding , int $mode = 0  ){}
/** @return int */ function ps_show_boxed ( resource $psdoc , string $text , float $left , float $bottom , float $width , float $height , string $hmode , string $feature = null  ){}
/** @return array */ function ps_string_geometry ( resource $psdoc , string $text , int $fontid = 0 , float $size = 0.0  ){}
/** @return float */ function ps_stringwidth ( resource $psdoc , string $text , int $fontid = 0 , float $size = 0.0  ){}
/** @return string */ function ps_symbol_name ( resource $psdoc , int $ord , int $fontid = 0  ){}
/** @return float */ function ps_symbol_width ( resource $psdoc , int $ord , int $fontid = 0 , float $size = 0.0  ){}
/** @return array */ function px_get_record ( resource $pxdoc , int $num , int $mode = 0  ){}
/** @return array */ function px_get_schema ( resource $pxdoc , int $mode = 0  ){}
/** @return bool */ function px_put_record ( resource $pxdoc , array $record , int $recpos = -1  ){}
/** @return array */ function px_retrieve_record ( resource $pxdoc , int $num , int $mode = 0  ){}
/** @return bool */ function radius_put_addr ( resource $radius_handle , int $type , string $addr , int $options = 0 , int $tag = null  ){}
/** @return bool */ function radius_put_attr ( resource $radius_handle , int $type , string $value , int $options = 0 , int $tag = null  ){}
/** @return bool */ function radius_put_int ( resource $radius_handle , int $type , int $value , int $options = 0 , int $tag = null  ){}
/** @return bool */ function radius_put_string ( resource $radius_handle , int $type , string $value , int $options = 0 , int $tag = null  ){}
/** @return bool */ function radius_put_vendor_attr ( resource $radius_handle , int $vendor , int $type , string $value , int $options = 0 , int $tag = null  ){}
/** @return bool */ function radius_put_vendor_int ( resource $radius_handle , int $vendor , int $type , int $value , int $options = 0 , int $tag = null  ){}
/** @return bool */ function radius_put_vendor_string ( resource $radius_handle , int $vendor , int $type , string $value , int $options = 0 , int $tag = null  ){}
/** @return array */ function range ( mixed $start , mixed $end , number $step = 1  ){}
/** @return string */ function readdir ( resource $dir_handle = null  ){}
/** @return int */ function readfile ( string $filename , bool $use_include_path = false , resource $context = null  ){}
/** @return int */ function readgzfile ( string $filename , int $use_include_path = 0  ){}
/** @return string */ function readline ( string $prompt = null  ){}
/** @return mixed */ function readline_info ( string $varname , string $newvalue = null  ){}
/** @return bool */ function readline_read_history ( string $filename = null  ){}
/** @return bool */ function readline_write_history ( string $filename = null  ){}
/** @return void */ function register_shutdown_function ( callable $callback , mixed $parameter , mixed $__args__ = null  ){}
/** @return bool */ function register_tick_function ( callable $function , mixed $arg , mixed $__args__ = null  ){}
/** @return bool */ function rename ( string $oldname , string $newname , resource $context = null  ){}
/** @return void */ function rewinddir ( resource $dir_handle = null  ){}
/** @return bool */ function rmdir ( string $dirname , resource $context = null  ){}
/** @return float */ function round ( float $val , int $precision = 0 , int $mode = PHP_ROUND_HALF_UP  ){}
/** @return int */ function rrd_first ( string $file , int $raaindex = 0  ){}
/** @return bool */ function rrd_restore ( string $xml_file , string $rrd_file , array $options = null  ){}
/** @return bool */ function rsort ( array &$array , int $sort_flags = SORT_REGULAR  ){}
/** @return string */ function rtrim ( string $str , string $character_mask = null  ){}
/** @return bool */ function runkit_import ( string $filename , int $flags = RUNKIT_IMPORT_CLASS_METHODS  ){}
/** @return bool */ function runkit_method_add ( string $classname , string $methodname , string $args , string $code , int $flags = RUNKIT_ACC_PUBLIC  ){}
/** @return bool */ function runkit_method_copy ( string $dClass , string $dMethod , string $sClass , string $sMethod = null  ){}
/** @return bool */ function runkit_method_redefine ( string $classname , string $methodname , string $args , string $code , int $flags = RUNKIT_ACC_PUBLIC  ){}
/** @return mixed */ function runkit_sandbox_output_handler ( object $sandbox , mixed $callback = null  ){}
/** @return array */ function scandir ( string $directory , int $sorting_order = SCANDIR_SORT_ASCENDING , resource $context = null  ){}
/** @return resource */ function sem_get ( int $key , int $max_acquire = 1 , int $perm = 0666 , int $auto_release = 1  ){}
/** @return int */ function session_cache_expire ( string $new_cache_expire = null  ){}
/** @return string */ function session_cache_limiter ( string $cache_limiter = null  ){}
/** @return string */ function session_id ( string $id = null  ){}
/** @return string */ function session_module_name ( string $module = null  ){}
/** @return string */ function session_name ( string $name = null  ){}
/** @return bool */ function session_pgsql_add_error ( int $error_level , string $error_message = null  ){}
/** @return array */ function session_pgsql_get_error ( bool $with_error_message = false  ){}
/** @return bool */ function session_regenerate_id ( bool $delete_old_session = false  ){}
/** @return bool */ function session_register ( mixed $name , mixed $__args__ = null  ){}
/** @return string */ function session_save_path ( string $path = null  ){}
/** @return void */ function session_set_cookie_params ( int $lifetime , string $path , string $domain , bool $secure = false , bool $httponly = false  ){}
/** @return bool */ function session_set_save_handler ( callable $open , callable $close , callable $read , callable $write , callable $destroy , callable $gc , callable $create_sid = null  ){}
/** @return bool */ function setcookie ( string $name , string $value , int $expire = 0 , string $path , string $domain , bool $secure = false , bool $httponly = false  ){}
/** @return mixed */ function set_error_handler ( callable $error_handler , int $error_types = E_ALL | E_STRICT  ){}
/** @return string */ function setlocale ( int $category , string $locale , string $__args__ = null  ){}
/** @return bool */ function setrawcookie ( string $name , string $value , int $expire = 0 , string $path , string $domain , bool $secure = false , bool $httponly = false  ){}
/** @return string */ function sha1_file ( string $filename , bool $raw_output = false  ){}
/** @return string */ function sha1 ( string $str , bool $raw_output = false  ){}
/** @return resource */ function shm_attach ( int $key , int $memsize , int $perm = 0666  ){}
/** @return int */ function similar_text ( string $first , string $second , float &$percent = null  ){}
/** @Return SimpleXMLElement */ function simplexml_import_dom ( DOMNode $node , string $class_name = "SimpleXMLElement"  ){}
/** @Return SimpleXMLElement */ function simplexml_load_file ( string $filename , string $class_name = "SimpleXMLElement" , int $options = 0 , string $ns = "" , bool $is_prefix = false  ){}
/** @Return SimpleXMLElement */ function simplexml_load_string ( string $data , string $class_name = "SimpleXMLElement" , int $options = 0 , string $ns = "" , bool $is_prefix = false  ){}
/** @return string */ function snmp2_get ( string $host , string $community , string $object_id , string $timeout = 1000000 , string $retries = 5  ){}
/** @return string */ function snmp2_getnext ( string $host , string $community , string $object_id , string $timeout = 1000000 , string $retries = 5  ){}
/** @return array */ function snmp2_real_walk ( string $host , string $community , string $object_id , string $timeout = 1000000 , string $retries = 5  ){}
/** @return bool */ function snmp2_set ( string $host , string $community , string $object_id , string $type , string $value , string $timeout = 1000000 , string $retries = 5  ){}
/** @return array */ function snmp2_walk ( string $host , string $community , string $object_id , string $timeout = 1000000 , string $retries = 5  ){}
/** @return string */ function snmp3_get ( string $host , string $sec_name , string $sec_level , string $auth_protocol , string $auth_passphrase , string $priv_protocol , string $priv_passphrase , string $object_id , string $timeout = 1000000 , string $retries = 5  ){}
/** @return string */ function snmp3_getnext ( string $host , string $sec_name , string $sec_level , string $auth_protocol , string $auth_passphrase , string $priv_protocol , string $priv_passphrase , string $object_id , string $timeout = 1000000 , string $retries = 5  ){}
/** @return array */ function snmp3_real_walk (  string $host  ,  string $sec_name  ,  string $sec_level  ,  string $auth_protocol  ,  string $auth_passphrase  ,  string $priv_protocol  ,  string $priv_passphrase  ,  string $object_id  ,  string $timeout  = 1000000  ,  string $retries  = 5   ){}
/** @return bool */ function snmp3_set ( string $host , string $sec_name , string $sec_level , string $auth_protocol , string $auth_passphrase , string $priv_protocol , string $priv_passphrase , string $object_id , string $type , string $value , int $timeout = 1000000 , int $retries = 5  ){}
/** @return array */ function snmp3_walk ( string $host , string $sec_name , string $sec_level , string $auth_protocol , string $auth_passphrase , string $priv_protocol , string $priv_passphrase , string $object_id , string $timeout = 1000000 , string $retries = 5  ){}
/** @return string */ function snmpget ( string $hostname , string $community , string $object_id , int $timeout = 1000000 , int $retries = 5  ){}
/** @return string */ function snmpgetnext ( string $host , string $community , string $object_id , int $timeout = 1000000 , int $retries = 5  ){}
/** @return array */ function snmprealwalk ( string $host , string $community , string $object_id , int $timeout = 1000000 , int $retries = 5  ){}
/** @return bool */ function snmpset ( string $host , string $community , string $object_id , string $type , mixed $value , int $timeout = 1000000 , int $retries = 5  ){}
/** @return array */ function snmpwalk ( string $hostname , string $community , string $object_id , int $timeout = 1000000 , int $retries = 5  ){}
/** @return array */ function snmpwalkoid ( string $hostname , string $community , string $object_id , int $timeout = 1000000 , int $retries = 5  ){}
/** @return bool */ function socket_bind ( resource $socket , string $address , int $port = 0  ){}
/** @return void */ function socket_clear_error ( resource $socket = null  ){}
/** @return bool */ function socket_connect ( resource $socket , string $address , int $port = 0  ){}
/** @return resource */ function socket_create_listen ( int $port , int $backlog = 128  ){}
/** @return bool */ function socket_getpeername ( resource $socket , string &$address , int &$port = null  ){}
/** @return bool */ function socket_getsockname ( resource $socket , string &$addr , int &$port = null  ){}
/** @return int */ function socket_last_error ( resource $socket = null  ){}
/** @return bool */ function socket_listen ( resource $socket , int $backlog = 0  ){}
/** @return string */ function socket_read ( resource $socket , int $length , int $type = PHP_BINARY_READ  ){}
/** @return int */ function socket_recvfrom ( resource $socket , string &$buf , int $len , int $flags , string &$name , int &$port = null  ){}
/** @return int */ function socket_recvmsg ( resource $socket , string $message , int $flags = null  ){}
/** @return int */ function socket_select ( array &$read , array &$write , array &$except , int $tv_sec , int $tv_usec = 0  ){}
/** @return int */ function socket_sendto ( resource $socket , string $buf , int $len , int $flags , string $addr , int $port = 0  ){}
/** @return bool */ function socket_shutdown ( resource $socket , int $how = 2  ){}
/** @return int */ function socket_write ( resource $socket , string $buffer , int $length = 0  ){}
/** @return bool */ function sort ( array &$array , int $sort_flags = SORT_REGULAR  ){}
/** @return string */ function spl_autoload_extensions ( string $file_extensions = null  ){}
/** @return void */ function spl_autoload ( string $class_name , string $file_extensions ='spl_autoload_extensions()'  ){}
/** @return bool */ function spl_autoload_register ( callable $autoload_function , bool $throw = true , bool $prepend = false  ){}
/** @return array */ function split ( string $pattern , string $string , int $limit = -1  ){}
/** @return array */ function spliti ( string $pattern , string $string , int $limit = -1  ){}
/** @return string */ function sprintf ( string $format , mixed $args , mixed $__args__ = null  ){}
/** @return array */ function sqlite_array_query ( resource $dbhandle , string $query , int $result_type = SQLITE_BOTH , bool $decode_binary = true  ){}
/** @return mixed */ function sqlite_column ( resource $result , mixed $index_or_name , bool $decode_binary = true  ){}
/** @return void */ function sqlite_create_aggregate ( resource $dbhandle , string $function_name , callable $step_func , callable $finalize_func , int $num_args = -1  ){}
/** @return void */ function sqlite_create_function ( resource $dbhandle , string $function_name , callable $callback , int $num_args = -1  ){}
/** @return array */ function sqlite_current ( resource $result , int $result_type = SQLITE_BOTH , bool $decode_binary = true  ){}
/** @return bool */ function sqlite_exec ( resource $dbhandle , string $query , string &$error_msg = null  ){}
/** @Return SQLiteDatabase */ function sqlite_factory ( string $filename , int $mode = 0666 , string &$error_message = null  ){}
/** @return array */ function sqlite_fetch_all ( resource $result , int $result_type = SQLITE_BOTH , bool $decode_binary = true  ){}
/** @return array */ function sqlite_fetch_array ( resource $result , int $result_type = SQLITE_BOTH , bool $decode_binary = true  ){}
/** @return array */ function sqlite_fetch_column_types ( string $table_name , resource $dbhandle , int $result_type = SQLITE_ASSOC  ){}
/** @return object */ function sqlite_fetch_object ( resource $result , string $class_name , array $ctor_params , bool $decode_binary = true  ){}
/** @return string */ function sqlite_fetch_single ( resource $result , bool $decode_binary = true  ){}
/** @return resource */ function sqlite_open ( string $filename , int $mode = 0666 , string &$error_message = null  ){}
/** @return resource */ function sqlite_popen ( string $filename , int $mode = 0666 , string &$error_message = null  ){}
/** @return resource */ function sqlite_query ( resource $dbhandle , string $query , int $result_type = SQLITE_BOTH , string &$error_msg = null  ){}
/** @return array */ function sqlite_single_query ( resource $db , string $query , bool $first_row_only , bool $decode_binary = null  ){}
/** @return resource */ function sqlite_unbuffered_query ( resource $dbhandle , string $query , int $result_type = SQLITE_BOTH , string &$error_msg = null  ){}
/** @return resource */ function sqlsrv_connect ( string $serverName , array $connectionInfo = null  ){}
/** @return mixed */ function sqlsrv_errors ( int $errorsOrWarnings = null  ){}
/** @return array */ function sqlsrv_fetch_array ( resource $stmt , int $fetchType , int $row , int $offset = null  ){}
/** @return mixed */ function sqlsrv_fetch ( resource $stmt , int $row , int $offset = null  ){}
/** @return mixed */ function sqlsrv_fetch_object ( resource $stmt , string $className , array $ctorParams , int $row , int $offset = null  ){}
/** @return mixed */ function sqlsrv_get_field ( resource $stmt , int $fieldIndex , int $getAsType = null  ){}
/** @return mixed */ function sqlsrv_prepare ( resource $conn , string $sql , array $params , array $options = null  ){}
/** @return mixed */ function sqlsrv_query ( resource $conn , string $sql , array $params , array $options = null  ){}
/** @return void */ function srand ( int $seed = null  ){}
/** @return mixed */ function sscanf ( string $str , string $format , mixed &$__args__ = null  ){}
/** @return bool */ function ssh2_auth_hostbased_file ( resource $session , string $username , string $hostname , string $pubkeyfile , string $privkeyfile , string $passphrase , string $local_username = null  ){}
/** @return bool */ function ssh2_auth_pubkey_file ( resource $session , string $username , string $pubkeyfile , string $privkeyfile , string $passphrase = null  ){}
/** @return resource */ function ssh2_connect ( string $host , int $port = 22 , array $methods , array $callbacks = null  ){}
/** @return resource */ function ssh2_exec ( resource $session , string $command , string $pty , array $env , int $width = 80 , int $height = 25 , int $width_height_type = SSH2_TERM_UNIT_CHARS  ){}
/** @return string */ function ssh2_fingerprint ( resource $session , int $flags = SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX  ){}
/** @return bool */ function ssh2_publickey_add ( resource $pkey , string $algoname , string $blob , bool $overwrite = false , array $attributes = null  ){}
/** @return bool */ function ssh2_scp_send ( resource $session , string $local_file , string $remote_file , int $create_mode = 0644  ){}
/** @return bool */ function ssh2_sftp_mkdir ( resource $sftp , string $dirname , int $mode = 0777 , bool $recursive = false  ){}
/** @return resource */ function ssh2_shell ( resource $session , string $term_type = "vanilla" , array $env , int $width = 80 , int $height = 25 , int $width_height_type = SSH2_TERM_UNIT_CHARS  ){}
/** @return float */ function stats_standard_deviation ( array $a , bool $sample = false  ){}
/** @return float */ function stats_variance ( array $a , bool $sample = false  ){}
/** @return int */ function strcspn ( string $str1 , string $str2 , int $start , int $length = null  ){}
/** @return resource */ function stream_context_create ( array $options , array $params = null  ){}
/** @return resource */ function stream_context_get_default ( array $options = null  ){}
/** @return int */ function stream_copy_to_stream ( resource $source , resource $dest , int $maxlength = -1 , int $offset = 0  ){}
/** @return bool */ function stream_encoding ( resource $stream , string $encoding = null  ){}
/** @return resource */ function stream_filter_append ( resource $stream , string $filtername , int $read_write , mixed $params = null  ){}
/** @return resource */ function stream_filter_prepend ( resource $stream , string $filtername , int $read_write , mixed $params = null  ){}
/** @return string */ function stream_get_contents ( resource $handle , int $maxlength = -1 , int $offset = -1  ){}
/** @return string */ function stream_get_line ( resource $handle , int $length , string $ending = null  ){}
/** @return int */ function stream_select ( array &$read , array &$write , array &$except , int $tv_sec , int $tv_usec = 0  ){}
/** @return bool */ function stream_set_timeout ( resource $stream , int $seconds , int $microseconds = 0  ){}
/** @return resource */ function stream_socket_accept ( resource $server_socket , float $timeout = 'ini_get("default_socket_timeout")' , string &$peername = null  ){}
/** @return resource */ function stream_socket_client ( string $remote_socket , int &$errno , string &$errstr , float $timeout = 'ini_get("default_socket_timeout")' , int $flags = STREAM_CLIENT_CONNECT , resource $context = null  ){}
/** @return mixed */ function stream_socket_enable_crypto ( resource $stream , bool $enable , int $crypto_type , resource $session_stream = null  ){}
/** @return string */ function stream_socket_recvfrom ( resource $socket , int $length , int $flags = 0 , string &$address = null  ){}
/** @return int */ function stream_socket_sendto ( resource $socket , string $data , int $flags = 0 , string $address = null  ){}
/** @return resource */ function stream_socket_server ( string $local_socket , int &$errno , string &$errstr , int $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN , resource $context = null  ){}
/** @return bool */ function stream_wrapper_register ( string $protocol , string $classname , int $flags  = 0  ){}
/** @return string */ function strftime ( string $format , int $timestamp ='time()'  ){}
/** @return array */ function str_getcsv ( string $input , string $delimiter = "," , string $enclosure = '"' , string $escape = "\\"  ){}
/** @return mixed */ function stripos ( string $haystack , string $needle , int $offset = 0  ){}
/** @return string */ function strip_tags ( string $str , string $allowable_tags = null  ){}
/** @return mixed */ function str_ireplace ( mixed $search , mixed $replace , mixed $subject , int &$count = null  ){}
/** @return string */ function stristr ( string $haystack , mixed $needle , bool $before_needle = false  ){}
/** @return string */ function str_pad ( string $input , int $pad_length , string $pad_string = " " , int $pad_type = STR_PAD_RIGHT  ){}
/** @return mixed */ function strpos ( string $haystack , mixed $needle , int $offset = 0  ){}
/** @return mixed */ function str_replace ( mixed $search , mixed $replace , mixed $subject , int &$count = null  ){}
/** @return int */ function strripos ( string $haystack , string $needle , int $offset = 0  ){}
/** @return int */ function strrpos ( string $haystack , string $needle , int $offset = 0  ){}
/** @return array */ function str_split ( string $string , int $split_length = 1  ){}
/** @return int */ function strspn ( string $subject , string $mask , int $start , int $length = null  ){}
/** @return string */ function strstr ( string $haystack , mixed $needle , bool $before_needle = false  ){}
/** @return int */ function strtotime ( string $time , int $now ='time()'  ){}
/** @return mixed */ function str_word_count ( string $string , int $format = 0 , string $charlist = null  ){}
/** @return int */ function substr_compare ( string $main_str , string $str , int $offset , int $length , bool $case_insensitivity = false  ){}
/** @return int */ function substr_count ( string $haystack , string $needle , int $offset = 0 , int $length = null  ){}
/** @return string */ function substr ( string $string , int $start , int $length = null  ){}
/** @return mixed */ function substr_replace ( mixed $string , mixed $replacement , mixed $start , mixed $length = null  ){}
/** @return bool */ function svn_add ( string $path , bool $recursive = true , bool $force = false  ){}
/** @return array */ function svn_blame ( string $repository_url , int $revision_no = SVN_REVISION_HEAD  ){}
/** @return string */ function svn_cat ( string $repos_url , int $revision_no = null  ){}
/** @return bool */ function svn_checkout ( string $repos , string $targetpath , int $revision , int $flags = 0  ){}
/** @return array */ function svn_commit ( string $log , array $targets , bool $recursive = true  ){}
/** @return bool */ function svn_delete ( string $path , bool $force = false  ){}
/** @return bool */ function svn_export ( string $frompath , string $topath , bool $working_copy = true , int $revision_no = -1  ){}
/** @return array */ function svn_log ( string $repos_url , int $start_revision , int $end_revision , int $limit = 0 , int $flags = SVN_DISCOVER_CHANGED_PATHS | SVN_STOP_ON_COPY  ){}
/** @return array */ function svn_ls ( string $repos_url , int $revision_no = SVN_REVISION_HEAD , bool $recurse = false , bool $peg = false  ){}
/** @return bool */ function svn_mkdir ( string $path , string $log_message = null  ){}
/** @return resource */ function svn_repos_create ( string $path , array $config , array $fsconfig = null  ){}
/** @return bool */ function svn_revert ( string $path , bool $recursive = false  ){}
/** @return array */ function svn_status ( string $path , int $flags = 0  ){}
/** @return int */ function svn_update ( string $path , int $revno = SVN_REVISION_HEAD , bool $recurse = true  ){}
/** @return int */ function sybase_affected_rows ( resource $link_identifier = null  ){}
/** @return bool */ function sybase_close ( resource $link_identifier = null  ){}
/** @return resource */ function sybase_connect ( string $servername , string $username , string $password , string $charset , string $appname , bool $new = false  ){}
/** @return object */ function sybase_fetch_field ( resource $result , int $field_offset = -1  ){}
/** @return object */ function sybase_fetch_object ( resource $result , mixed $object = null  ){}
/** @return resource */ function sybase_pconnect ( string $servername , string $username , string $password , string $charset , string $appname = null  ){}
/** @return mixed */ function sybase_query ( string $query , resource $link_identifier = null  ){}
/** @return bool */ function sybase_select_db ( string $database_name , resource $link_identifier = null  ){}
/** @return bool */ function sybase_set_message_handler ( callable $handler , resource $link_identifier = null  ){}
/** @return resource */ function sybase_unbuffered_query ( string $query , resource $link_identifier , bool $store_result = null  ){}
/** @return string */ function system ( string $command , int &$return_var = null  ){}
/** @return bool */ function taint ( string &$string , string $__args__ = null  ){}
/** @return bool */ function tcpwrap_check ( string $daemon , string $address , string $user , bool $nodns = false  ){}
/** @return string */ function timezone_name_from_abbr ( string $abbr , int $gmtOffset = -1 , int $isdst = -1  ){}
/** @return bool */ function touch ( string $filename , int $time ='time()' , int $atime = null  ){}
/** @return array */ function trader_adosc ( array $high , array $low , array $close , array $volume , integer $fastPeriod , integer $slowPeriod = null  ){}
/** @return array */ function trader_adx ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_adxr ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_apo ( array $real , integer $fastPeriod , integer $slowPeriod , integer $mAType = null  ){}
/** @return array */ function trader_aroon ( array $high , array $low , integer $timePeriod = null  ){}
/** @return array */ function trader_aroonosc ( array $high , array $low , integer $timePeriod = null  ){}
/** @return array */ function trader_atr ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_bbands ( array $real , integer $timePeriod , float $nbDevUp , float $nbDevDn , integer $mAType = null  ){}
/** @return array */ function trader_beta ( array $real0 , array $real1 , integer $timePeriod = null  ){}
/** @return array */ function trader_cci ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_cdlabandonedbaby ( array $open , array $high , array $low , array $close , float $penetration = null  ){}
/** @return array */ function trader_cdldarkcloudcover ( array $open , array $high , array $low , array $close , float $penetration = null  ){}
/** @return array */ function trader_cdleveningdojistar ( array $open , array $high , array $low , array $close , float $penetration = null  ){}
/** @return array */ function trader_cdleveningstar ( array $open , array $high , array $low , array $close , float $penetration = null  ){}
/** @return array */ function trader_cdlmathold ( array $open , array $high , array $low , array $close , float $penetration = null  ){}
/** @return array */ function trader_cdlmorningdojistar ( array $open , array $high , array $low , array $close , float $penetration = null  ){}
/** @return array */ function trader_cdlmorningstar ( array $open , array $high , array $low , array $close , float $penetration = null  ){}
/** @return array */ function trader_cmo ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_correl ( array $real0 , array $real1 , integer $timePeriod = null  ){}
/** @return array */ function trader_dema ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_dx ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_ema ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_kama ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_linearreg_angle ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_linearreg ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_linearreg_intercept ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_linearreg_slope ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_macdext ( array $real , integer $fastPeriod , integer $fastMAType , integer $slowPeriod , integer $slowMAType , integer $signalPeriod , integer $signalMAType = null  ){}
/** @return array */ function trader_macdfix ( array $real , integer $signalPeriod = null  ){}
/** @return array */ function trader_macd ( array $real , integer $fastPeriod , integer $slowPeriod , integer $signalPeriod = null  ){}
/** @return array */ function trader_ma ( array $real , integer $timePeriod , integer $mAType = null  ){}
/** @return array */ function trader_mama ( array $real , float $fastLimit , float $slowLimit = null  ){}
/** @return array */ function trader_mavp ( array $real , array $periods , integer $minPeriod , integer $maxPeriod , integer $mAType = null  ){}
/** @return array */ function trader_max ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_maxindex ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_mfi ( array $high , array $low , array $close , array $volume , integer $timePeriod = null  ){}
/** @return array */ function trader_midpoint ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_midprice ( array $high , array $low , integer $timePeriod = null  ){}
/** @return array */ function trader_min ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_minindex ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_minmax ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_minmaxindex ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_minus_di ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_minus_dm ( array $high , array $low , integer $timePeriod = null  ){}
/** @return array */ function trader_mom ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_natr ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_plus_di ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_plus_dm ( array $high , array $low , integer $timePeriod = null  ){}
/** @return array */ function trader_ppo ( array $real , integer $fastPeriod , integer $slowPeriod , integer $mAType = null  ){}
/** @return array */ function trader_roc ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_rocp ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_rocr100 ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_rocr ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_rsi ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_sarext ( array $high , array $low , float $startValue , float $offsetOnReverse , float $accelerationInitLong , float $accelerationLong , float $accelerationMaxLong , float $accelerationInitShort , float $accelerationShort , float $accelerationMaxShort = null  ){}
/** @return array */ function trader_sar ( array $high , array $low , float $acceleration , float $maximum = null  ){}
/** @return array */ function trader_sma ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_stddev ( array $real , integer $timePeriod , float $nbDev = null  ){}
/** @return array */ function trader_stochf ( array $high , array $low , array $close , integer $fastK_Period , integer $fastD_Period , integer $fastD_MAType = null  ){}
/** @return array */ function trader_stoch ( array $high , array $low , array $close , integer $fastK_Period , integer $slowK_Period , integer $slowK_MAType , integer $slowD_Period , integer $slowD_MAType = null  ){}
/** @return array */ function trader_stochrsi ( array $real , integer $timePeriod , integer $fastK_Period , integer $fastD_Period , integer $fastD_MAType = null  ){}
/** @return array */ function trader_sum ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_t3 ( array $real , integer $timePeriod , float $vFactor = null  ){}
/** @return array */ function trader_tema ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_trima ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_trix ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_tsf ( array $real , integer $timePeriod = null  ){}
/** @return array */ function trader_ultosc ( array $high , array $low , array $close , integer $timePeriod1 , integer $timePeriod2 , integer $timePeriod3 = null  ){}
/** @return array */ function trader_var ( array $real , integer $timePeriod , float $nbDev = null  ){}
/** @return array */ function trader_willr ( array $high , array $low , array $close , integer $timePeriod = null  ){}
/** @return array */ function trader_wma ( array $real , integer $timePeriod = null  ){}
/** @return bool */ function trait_exists ( string $traitname , bool $autoload = null  ){}
/** @return bool */ function trigger_error ( string $error_msg , int $error_type = E_USER_NOTICE  ){}
/** @return string */ function trim ( string $str , string $character_mask = " \t\n\r\0\x0B"  ){}
/** @return string */ function ucwords ( string $str ,  string $delimiters = " \t\r\n\f\v"   ){}
/** @return resource */ function udm_alloc_agent ( string $dbaddr , string $dbmode = null  ){}
/** @return int */ function umask ( int $mask = null  ){}
/** @return string */ function uniqid ( string $prefix = "" , bool $more_entropy = false  ){}
/** @return int */ function unixtojd ( int $timestamp ='time()'  ){}
/** @return bool */ function unlink ( string $filename , resource $context = null  ){}
///** @return void */ function unset ( mixed $var , mixed $__args__ = null  ){}
/** @return bool */ function untaint ( string &$string , string $__args__ = null  ){}
/** @return void */ function uopz_compose ( string $name , array $classes , array $methods , array $properties , int $flags = null  ){}
/** @return void */ function uopz_function ( string $class , string $function , Closure $handler , int $modifiers = null  ){}
/** @return bool */ function use_soap_error_handler ( bool $handler = true  ){}
/** @return void */ function var_dump ( mixed $expression , mixed $__args__ = null  ){}
/** @return mixed */ function var_export ( mixed $expression , bool $return = false  ){}
/** @return int */ function variant_cmp ( mixed $left , mixed $right , int $lcid , int $flags = null  ){}
/** @return mixed */ function version_compare ( string $version1 , string $version2 , string $operator = null  ){}
/** @return bool */ function vpopmail_add_domain_ex ( string $domain , string $passwd , string $quota , string $bounce , bool $apop = null  ){}
/** @return bool */ function vpopmail_add_user ( string $user , string $domain , string $password , string $gecos , bool $apop = null  ){}
/** @return bool */ function vpopmail_auth_user ( string $user , string $domain , string $password , string $apop = null  ){}
/** @return bool */ function vpopmail_passwd ( string $user , string $domain , string $password , bool $apop = null  ){}
/** @return bool */ function wddx_add_vars ( resource $packet_id , mixed $var_name , mixed $__args__ = null  ){}
/** @return resource */ function wddx_packet_start ( string $comment = null  ){}
/** @return string */ function wddx_serialize_value ( mixed $var , string $comment = null  ){}
/** @return string */ function wddx_serialize_vars ( mixed $var_name , mixed $__args__ = null  ){}
/** @return int */ function win32_continue_service ( string $servicename , string $machine = null  ){}
/** @return mixed */ function win32_create_service ( array $details , string $machine = null  ){}
/** @return mixed */ function win32_delete_service ( string $servicename , string $machine = null  ){}
/** @return int */ function win32_pause_service ( string $servicename , string $machine = null  ){}
/** @return array */ function win32_ps_stat_proc ( int $pid = 0  ){}
/** @return mixed */ function win32_query_service_status ( string $servicename , string $machine = null  ){}
/** @return bool */ function win32_set_service_status ( int $status , int $checkpoint = 0  ){}
/** @return int */ function win32_start_service ( string $servicename , string $machine = null  ){}
/** @return int */ function win32_stop_service ( string $servicename , string $machine = null  ){}
/** @return array */ function wincache_fcache_fileinfo ( bool $summaryonly = false  ){}
/** @return bool */ function wincache_lock ( string $key , bool $isglobal = false  ){}
/** @return array */ function wincache_ocache_fileinfo ( bool $summaryonly = false  ){}
/** @return bool */ function wincache_refresh_if_changed ( array $files = NULL  ){}
/** @return array */ function wincache_rplist_fileinfo ( bool $summaryonly = false  ){}
/** @return array */ function wincache_scache_info ( bool $summaryonly = false  ){}
/** @return bool */ function wincache_ucache_add ( string $key , mixed $value , int $ttl = 0  ){}
/** @return mixed */ function wincache_ucache_dec ( string $key , int $dec_by = 1 , bool &$success = null  ){}
/** @return mixed */ function wincache_ucache_get ( mixed $key , bool &$success = null  ){}
/** @return mixed */ function wincache_ucache_inc ( string $key , int $inc_by = 1 , bool &$success = null  ){}
/** @return array */ function wincache_ucache_info ( bool $summaryonly = false , string $key = NULL  ){}
/** @return bool */ function wincache_ucache_set ( mixed $key , mixed $value , int $ttl = 0  ){}
/** @return string */ function wordwrap ( string $str , int $width = 75 , string $break = "\n" , bool $cut = false  ){}
/** @return string */ function xattr_get ( string $filename , string $name , int $flags = 0  ){}
/** @return array */ function xattr_list ( string $filename , int $flags = 0  ){}
/** @return bool */ function xattr_remove ( string $filename , string $name , int $flags = 0  ){}
/** @return bool */ function xattr_set ( string $filename , string $name , string $value , int $flags = 0  ){}
/** @return bool */ function xattr_supported ( string $filename , int $flags = 0  ){}
/** @return bool */ function xdiff_file_diff ( string $old_file , string $new_file , string $dest , int $context = 3 , bool $minimal = false  ){}
/** @return mixed */ function xdiff_file_patch ( string $file , string $patch , string $dest , int $flags = DIFF_PATCH_NORMAL  ){}
/** @return string */ function xdiff_string_diff ( string $old_data , string $new_data , int $context = 3 , bool $minimal = false  ){}
/** @return mixed */ function xdiff_string_merge3 ( string $old_data , string $new_data1 , string $new_data2 , string &$error = null  ){}
/** @return string */ function xdiff_string_patch ( string $str , string $patch , int $flags , string &$error = null  ){}
/** @return void */ function xhprof_enable ( int $flags = 0 , array $options = null  ){}
/** @return int */ function xml_parse ( resource $parser , string $data , bool $is_final = false  ){}
/** @return int */ function xml_parse_into_struct ( resource $parser , string $data , array &$values , array &$index = null  ){}
/** @return resource */ function xml_parser_create ( string $encoding = null  ){}
/** @return resource */ function xml_parser_create_ns ( string $encoding , string $separator = ":"  ){}
/** @return mixed */ function xmlrpc_decode ( string $xml , string $encoding = "iso-8859-1"  ){}
/** @return mixed */ function xmlrpc_decode_request ( string $xml , string &$method , string $encoding = null  ){}
/** @return string */ function xmlrpc_encode_request ( string $method , mixed $params , array $output_options = null  ){}
/** @return string */ function xmlrpc_server_call_method ( resource $server , string $xml , mixed $user_data , array $output_options = null  ){}
/** @return bool */ function yaml_emit_file ( string $filename , mixed $data , int $encoding = YAML_ANY_ENCODING , int $linebreak = YAML_ANY_BREAK , array $callbacks = null  ){}
/** @return string */ function yaml_emit ( mixed $data , int $encoding = YAML_ANY_ENCODING , int $linebreak = YAML_ANY_BREAK , array $callbacks = null  ){}
/** @return mixed */ function yaml_parse_file ( string $filename , int $pos = 0 , int &$ndocs , array $callbacks = null  ){}
/** @return mixed */ function yaml_parse ( string $input , int $pos = 0 , int &$ndocs , array $callbacks = null  ){}
/** @return mixed */ function yaml_parse_url ( string $url , int $pos = 0 , int &$ndocs , array $callbacks = null  ){}
/** @return mixed */ function yaz_connect ( string $zurl , mixed $options = null  ){}
/** @return int */ function yaz_hits ( resource $id , array &$searchresult = null  ){}
/** @return void */ function yaz_scan ( resource $id , string $type , string $startterm , array $flags = null  ){}
/** @return array */ function yaz_scan_result ( resource $id , array &$result = null  ){}
/** @return mixed */ function yaz_wait ( array &$options = null  ){}
/** @return bool */ function zip_entry_open ( resource $zip , resource $zip_entry , string $mode = null  ){}
/** @return string */ function zip_entry_read ( resource $zip_entry , int $length = 1024  ){}
/** @return string */ function zlib_decode ( string $data , string $max_decoded_len = null  ){}
/** @return string */ function zlib_encode ( string $data , string $encoding , string $level = -1  ){}
/** @return number */ function abs(mixed $number){}
/** @return float */ function acos(float $arg){}
/** @return float */ function acosh(float $arg){}
/** @return string */ function addcslashes(string $str,string $charlist){}
/** @return string */ function addslashes(string $str){}
/** @return bool */ function apache_child_terminate(){}
/** @return array */ function apache_get_modules(){}
/** @return string */ function apache_get_version(){}
/** @return object */ function apache_lookup_uri(string $filename){}
/** @return array */ function apache_request_headers(){}
/** @return bool */ function apache_reset_timeout(){}
/** @return array */ function apache_response_headers(){}
/** @return bool */ function apc_cas(string $key,int $old,int $new){}
/** @return mixed */ function apc_delete_file(mixed $keys){}
/** @return mixed */ function apc_delete(string $key){}
/** @return mixed */ function apc_exists(mixed $keys){}
/** @return bool */ function apd_breakpoint(int $debug_level){}
/** @return array */ function apd_callstack(){}
/** @return bool */ function apd_continue(int $debug_level){}
/** @return void */ function apd_dump_function_table(){}
/** @return array */ function apd_dump_persistent_resources(){}
/** @return array */ function apd_dump_regular_resources(){}
/** @return bool */ function apd_echo(string $output){}
/** @return array */ function apd_get_active_symbols(){}
/** @return bool */ function apd_set_session_trace_socket(string $tcp_server,int $socket_type,int $port,int $debug_level){}
/** @return void */ function apd_set_session(int $debug_level){}
/** @return array */ function array_combine(array $keys,array $values){}
/** @return array */ function array_count_values(array $input){}
/** @return array */ function array_fill(int $start_index,int $num,mixed $value){}
/** @return array */ function array_fill_keys(array $keys,mixed $value){}
/** @return array */ function array_flip(array $trans){}
/** @return bool */ function array_key_exists(mixed $key,array $search){}
/** @return array */ function array_pad(array $input,int $pad_size,mixed $pad_value){}
/** @return mixed */ function array_pop(array &$array){}
/** @return number */ function array_product(array $array){}
/** @return mixed */ function array_shift(array &$array){}
/** @return number */ function array_sum(array $array){}
/** @return array */ function array_values(array $input){}
/** @return float */ function asin(float $arg){}
/** @return float */ function asinh(float $arg){}
/** @return float */ function atan2(float $y,float $x){}
/** @return float */ function atan(float $arg){}
/** @return float */ function atanh(float $arg){}
/** @return void */ function __autoload(string $class){}
/** @return string */ function base64_encode(string $data){}
/** @return string */ function base_convert(string $number,int $frombase,int $tobase){}
/** @return bool */ function bbcode_add_element(resource $bbcode_container,string $tag_name,array $tag_rules){}
/** @return bool */ function bbcode_add_smiley(resource $bbcode_container,string $smiley,string $replace_by){}
/** @return bool */ function bbcode_destroy(resource $bbcode_container){}
/** @return string */ function bbcode_parse(resource $bbcode_container,string $to_parse){}
/** @return bool */ function bbcode_set_arg_parser(resource $bbcode_container,resource $bbcode_arg_parser){}
/** @return string */ function bcmod(string $left_operand,string $modulus){}
/** @return bool */ function bcompiler_load(string $filename){}
/** @return bool */ function bcompiler_load_exe(string $filename){}
/** @return bool */ function bcompiler_parse_class(string $class,string $callback){}
/** @return bool */ function bcompiler_read(resource $filehandle){}
/** @return bool */ function bcompiler_write_constant(resource $filehandle,string $constantName){}
/** @return bool */ function bcompiler_write_exe_footer(resource $filehandle,int $startpos){}
/** @return bool */ function bcompiler_write_file(resource $filehandle,string $filename){}
/** @return bool */ function bcompiler_write_footer(resource $filehandle){}
/** @return bool */ function bcompiler_write_function(resource $filehandle,string $functionName){}
/** @return bool */ function bcompiler_write_functions_from_file(resource $filehandle,string $fileName){}
/** @return bool */ function bcompiler_write_included_filename(resource $filehandle,string $filename){}
/** @return bool */ function bcscale(int $scale){}
/** @return string */ function bin2hex(string $str){}
/** @return number */ function bindec(string $binary_string){}
/** @return string */ function bind_textdomain_codeset(string $domain,string $codeset){}
/** @return string */ function bindtextdomain(string $domain,string $directory){}
/** @return boolean */ function boolval(mixed $var){}
/** @return array */ function bson_decode(string $bson){}
/** @return string */ function bson_encode(mixed $anything){}
/** @return int */ function bzclose(resource $bz){}
/** @return int */ function bzerrno(resource $bz){}
/** @return array */ function bzerror(resource $bz){}
/** @return string */ function bzerrstr(resource $bz){}
/** @return int */ function bzflush(resource $bz){}
/** @return resource */ function bzopen(string $filename,string $mode){}
/** @return CairoContext */ function cairo_create(CairoSurface $surface){}
/** @return int */ function cairo_font_face_get_type(CairoFontFace $fontface){}
/** @return int */ function cairo_font_face_status(CairoFontFace $fontface){}
/** @return CairoFontOptions */ function cairo_font_options_create(){}
/** @return bool */ function cairo_font_options_equal(CairoFontOptions $options,CairoFontOptions $other){}
/** @return int */ function cairo_font_options_get_antialias(CairoFontOptions $options){}
/** @return int */ function cairo_font_options_get_hint_metrics(CairoFontOptions $options){}
/** @return int */ function cairo_font_options_get_hint_style(CairoFontOptions $options){}
/** @return int */ function cairo_font_options_get_subpixel_order(CairoFontOptions $options){}
/** @return int */ function cairo_font_options_hash(CairoFontOptions $options){}
/** @return void */ function cairo_font_options_merge(CairoFontOptions $options,CairoFontOptions $other){}
/** @return void */ function cairo_font_options_set_antialias(CairoFontOptions $options,int $antialias){}
/** @return void */ function cairo_font_options_set_hint_metrics(CairoFontOptions $options,int $hint_metrics){}
/** @return void */ function cairo_font_options_set_hint_style(CairoFontOptions $options,int $hint_style){}
/** @return void */ function cairo_font_options_set_subpixel_order(CairoFontOptions $options,int $subpixel_order){}
/** @return int */ function cairo_font_options_status(CairoFontOptions $options){}
/** @return int */ function cairo_format_stride_for_width(int $format,int $width){}
/** @return CairoImageSurface */ function cairo_image_surface_create(int $format,int $width,int $height){}
/** @return CairoImageSurface */ function cairo_image_surface_create_from_png(string $file){}
/** @return string */ function cairo_image_surface_get_data(CairoImageSurface $surface){}
/** @return int */ function cairo_image_surface_get_format(CairoImageSurface $surface){}
/** @return int */ function cairo_image_surface_get_height(CairoImageSurface $surface){}
/** @return int */ function cairo_image_surface_get_stride(CairoImageSurface $surface){}
/** @return int */ function cairo_image_surface_get_width(CairoImageSurface $surface){}
/** @return void */ function cairo_matrix_invert(CairoMatrix $matrix){}
/** @return CairoMatrix */ function cairo_matrix_multiply(CairoMatrix $matrix1,CairoMatrix $matrix2){}
/** @return void */ function cairo_matrix_rotate(CairoMatrix $matrix,float $radians){}
/** @return array */ function cairo_matrix_transform_distance(CairoMatrix $matrix,float $dx,float $dy){}
/** @return array */ function cairo_matrix_transform_point(CairoMatrix $matrix,float $dx,float $dy){}
/** @return void */ function cairo_matrix_translate(CairoMatrix $matrix,float $tx,float $ty){}
/** @return void */ function cairo_pattern_add_color_stop_rgba(CairoGradientPattern $pattern,float $offset,float $red,float $green,float $blue,float $alpha){}
/** @return void */ function cairo_pattern_add_color_stop_rgb(CairoGradientPattern $pattern,float $offset,float $red,float $green,float $blue){}
/** @return CairoPattern */ function cairo_pattern_create_for_surface(CairoSurface $surface){}
/** @return CairoPattern */ function cairo_pattern_create_linear(float $x0,float $y0,float $x1,float $y1){}
/** @return CairoPattern */ function cairo_pattern_create_radial(float $x0,float $y0,float $r0,float $x1,float $y1,float $r1){}
/** @return CairoPattern */ function cairo_pattern_create_rgba(float $red,float $green,float $blue,float $alpha){}
/** @return CairoPattern */ function cairo_pattern_create_rgb(float $red,float $green,float $blue){}
/** @return int */ function cairo_pattern_get_color_stop_count(CairoGradientPattern $pattern){}
/** @return array */ function cairo_pattern_get_color_stop_rgba(CairoGradientPattern $pattern,int $index){}
/** @return int */ function cairo_pattern_get_extend(string $pattern){}
/** @return int */ function cairo_pattern_get_filter(CairoSurfacePattern $pattern){}
/** @return array */ function cairo_pattern_get_linear_points(CairoLinearGradient $pattern){}
/** @return CairoMatrix */ function cairo_pattern_get_matrix(CairoPattern $pattern){}
/** @return array */ function cairo_pattern_get_radial_circles(CairoRadialGradient $pattern){}
/** @return array */ function cairo_pattern_get_rgba(CairoSolidPattern $pattern){}
/** @return CairoSurface */ function cairo_pattern_get_surface(CairoSurfacePattern $pattern){}
/** @return int */ function cairo_pattern_get_type(CairoPattern $pattern){}
/** @return void */ function cairo_pattern_set_extend(string $pattern,string $extend){}
/** @return void */ function cairo_pattern_set_filter(CairoSurfacePattern $pattern,int $filter){}
/** @return void */ function cairo_pattern_set_matrix(CairoPattern $pattern,CairoMatrix $matrix){}
/** @return int */ function cairo_pattern_status(CairoPattern $pattern){}
/** @return CairoPdfSurface */ function cairo_pdf_surface_create(string $file,float $width,float $height){}
/** @return void */ function cairo_pdf_surface_set_size(CairoPdfSurface $surface,float $width,float $height){}
/** @return array */ function cairo_ps_get_levels(){}
/** @return string */ function cairo_ps_level_to_string(int $level){}
/** @return CairoPsSurface */ function cairo_ps_surface_create(string $file,float $width,float $height){}
/** @return void */ function cairo_ps_surface_dsc_begin_page_setup(CairoPsSurface $surface){}
/** @return void */ function cairo_ps_surface_dsc_begin_setup(CairoPsSurface $surface){}
/** @return void */ function cairo_ps_surface_dsc_comment(CairoPsSurface $surface,string $comment){}
/** @return bool */ function cairo_ps_surface_get_eps(CairoPsSurface $surface){}
/** @return void */ function cairo_ps_surface_restrict_to_level(CairoPsSurface $surface,int $level){}
/** @return void */ function cairo_ps_surface_set_eps(CairoPsSurface $surface,bool $level){}
/** @return void */ function cairo_ps_surface_set_size(CairoPsSurface $surface,float $width,float $height){}
/** @return CairoScaledFont */ function cairo_scaled_font_create(CairoFontFace $fontface,CairoMatrix $matrix,CairoMatrix $ctm,CairoFontOptions $fontoptions){}
/** @return array */ function cairo_scaled_font_extents(CairoScaledFont $scaledfont){}
/** @return CairoMatrix */ function cairo_scaled_font_get_ctm(CairoScaledFont $scaledfont){}
/** @return CairoFontFace */ function cairo_scaled_font_get_font_face(CairoScaledFont $scaledfont){}
/** @return CairoFontOptions */ function cairo_scaled_font_get_font_matrix(CairoScaledFont $scaledfont){}
/** @return CairoFontOptions */ function cairo_scaled_font_get_font_options(CairoScaledFont $scaledfont){}
/** @return CairoMatrix */ function cairo_scaled_font_get_scale_matrix(CairoScaledFont $scaledfont){}
/** @return int */ function cairo_scaled_font_get_type(CairoScaledFont $scaledfont){}
/** @return array */ function cairo_scaled_font_glyph_extents(CairoScaledFont $scaledfont,array $glyphs){}
/** @return int */ function cairo_scaled_font_status(CairoScaledFont $scaledfont){}
/** @return array */ function cairo_scaled_font_text_extents(CairoScaledFont $scaledfont,string $text){}
/** @return void */ function cairo_surface_copy_page(CairoSurface $surface){}
/** @return CairoSurface */ function cairo_surface_create_similar(CairoSurface $surface,int $content,float $width,float $height){}
/** @return void */ function cairo_surface_finish(CairoSurface $surface){}
/** @return void */ function cairo_surface_flush(CairoSurface $surface){}
/** @return int */ function cairo_surface_get_content(CairoSurface $surface){}
/** @return array */ function cairo_surface_get_device_offset(CairoSurface $surface){}
/** @return CairoFontOptions */ function cairo_surface_get_font_options(CairoSurface $surface){}
/** @return int */ function cairo_surface_get_type(CairoSurface $surface){}
/** @return void */ function cairo_surface_mark_dirty_rectangle(CairoSurface $surface,float $x,float $y,float $width,float $height){}
/** @return void */ function cairo_surface_mark_dirty(CairoSurface $surface){}
/** @return void */ function cairo_surface_set_device_offset(CairoSurface $surface,float $x,float $y){}
/** @return void */ function cairo_surface_set_fallback_resolution(CairoSurface $surface,float $x,float $y){}
/** @return void */ function cairo_surface_show_page(CairoSurface $surface){}
/** @return int */ function cairo_surface_status(CairoSurface $surface){}
/** @return void */ function cairo_surface_write_to_png(CairoSurface $surface,resource $stream){}
/** @return CairoSvgSurface */ function cairo_svg_surface_create(string $file,float $width,float $height){}
/** @return void */ function cairo_svg_surface_restrict_to_version(CairoSvgSurface $surface,int $version){}
/** @return string */ function cairo_svg_version_to_string(int $version){}
/** @return string */ function calculhmac(string $clent,string $data){}
/** @return string */ function calcul_hmac(string $clent,string $siretcode,string $price,string $reference,string $validity,string $taxation,string $devise,string $language){}
/** @return int */ function cal_days_in_month(int $calendar,int $month,int $year){}
/** @return array */ function cal_from_jd(int $jd,int $calendar){}
/** @return mixed */ function call_user_func_array(callable $callback,array $param_arr){}
/** @return mixed */ function call_user_method_array(string $method_name,object &$obj,array $paramarr){}
/** @return int */ function cal_to_jd(int $calendar,int $month,int $day,int $year){}
/** @return float */ function ceil(float $value){}
/** @return bool */ function chdb_create(string $pathname,array $data){}
/** @return bool */ function chdir(string $directory){}
/** @return bool */ function checkdate(int $month,int $day,int $year){}
/** @return bool */ function chgrp(string $filename,mixed $group){}
/** @return bool */ function chmod(string $filename,int $mode){}
/** @return bool */ function chown(string $filename,mixed $user){}
/** @return bool */ function chroot(string $directory){}
/** @return string */ function chr(int $ascii){}
/** @return array */ function classkit_import(string $filename){}
/** @return bool */ function classkit_method_remove(string $classname,string $methodname){}
/** @return bool */ function classkit_method_rename(string $classname,string $methodname,string $newname){}
/** @return string */ function cli_get_process_title(){}
/** @return bool */ function cli_set_process_title(string $title){}
/** @return bool */ function closelog(){}
/** @return string */ function com_create_guid(){}
/** @return int */ function connection_aborted(){}
/** @return int */ function connection_status(){}
/** @return mixed */ function constant(string $name){}
/** @return string */ function convert_cyr_string(string $str,string $from,string $to){}
/** @return string */ function convert_uudecode(string $data){}
/** @return string */ function convert_uuencode(string $data){}
/** @return float */ function cos(float $arg){}
/** @return float */ function cosh(float $arg){}
/** @return bool */ function crack_check(resource $dictionary,string $password){}
/** @return string */ function crack_getlastmessage(){}
/** @return resource */ function crack_opendict(string $dictionary){}
/** @return int */ function crc32(string $str){}
/** @return string */ function create_function(string $args,string $code){}
/** @return bool */ function ctype_alnum(string $text){}
/** @return bool */ function ctype_alpha(string $text){}
/** @return bool */ function ctype_cntrl(string $text){}
/** @return bool */ function ctype_digit(string $text){}
/** @return bool */ function ctype_graph(string $text){}
/** @return bool */ function ctype_lower(string $text){}
/** @return bool */ function ctype_print(string $text){}
/** @return bool */ function ctype_punct(string $text){}
/** @return bool */ function ctype_space(string $text){}
/** @return bool */ function ctype_upper(string $text){}
/** @return bool */ function ctype_xdigit(string $text){}
/** @return bool */ function cubrid_close_prepare(resource $req_identifier){}
/** @return bool */ function cubrid_close_request(resource $req_identifier){}
/** @return array */ function cubrid_col_get(resource $conn_identifier,string $oid,string $attr_name){}
/** @return int */ function cubrid_col_size(resource $conn_identifier,string $oid,string $attr_name){}
/** @return array */ function cubrid_column_names(resource $req_identifier){}
/** @return array */ function cubrid_column_types(resource $req_identifier){}
/** @return bool */ function cubrid_commit(resource $conn_identifier){}
/** @return string */ function cubrid_current_oid(resource $req_identifier){}
/** @return bool */ function cubrid_data_seek(resource $result,int $row_number){}
/** @return string */ function cubrid_db_name(array $result,int $index){}
/** @return bool */ function cubrid_drop(resource $conn_identifier,string $oid){}
/** @return int */ function cubrid_error_code_facility(){}
/** @return int */ function cubrid_error_code(){}
/** @return string */ function cubrid_error_msg(){}
/** @return array */ function cubrid_fetch_lengths(resource $result){}
/** @return string */ function cubrid_field_flags(resource $result,int $field_offset){}
/** @return int */ function cubrid_field_len(resource $result,int $field_offset){}
/** @return string */ function cubrid_field_name(resource $result,int $field_offset){}
/** @return string */ function cubrid_field_table(resource $result,int $field_offset){}
/** @return string */ function cubrid_field_type(resource $result,int $field_offset){}
/** @return bool */ function cubrid_free_result(resource $req_identifier){}
/** @return bool */ function cubrid_get_autocommit(resource $conn_identifier){}
/** @return string */ function cubrid_get_charset(resource $conn_identifier){}
/** @return string */ function cubrid_get_class_name(resource $conn_identifier,string $oid){}
/** @return string */ function cubrid_get_client_info(){}
/** @return array */ function cubrid_get_db_parameter(resource $conn_identifier){}
/** @return int */ function cubrid_get_query_timeout(resource $req_identifier){}
/** @return string */ function cubrid_get_server_info(resource $conn_identifier){}
/** @return int */ function cubrid_is_instance(resource $conn_identifier,string $oid){}
/** @return int */ function cubrid_load_from_glo(resource $conn_identifier,string $oid,string $file_name){}
/** @return bool */ function cubrid_lob2_close(resource $lob_identifier){}
/** @return bool */ function cubrid_lob2_export(resource $lob_identifier,string $file_name){}
/** @return bool */ function cubrid_lob2_import(resource $lob_identifier,string $file_name){}
/** @return string */ function cubrid_lob2_read(resource $lob_identifier,int $len){}
/** @return string */ function cubrid_lob2_size64(resource $lob_identifier){}
/** @return int */ function cubrid_lob2_size(resource $lob_identifier){}
/** @return string */ function cubrid_lob2_tell64(resource $lob_identifier){}
/** @return int */ function cubrid_lob2_tell(resource $lob_identifier){}
/** @return bool */ function cubrid_lob2_write(resource $lob_identifier,string $buf){}
/** @return bool */ function cubrid_lob_close(array $lob_identifier_array){}
/** @return bool */ function cubrid_lob_export(resource $conn_identifier,resource $lob_identifier,string $path_name){}
/** @return array */ function cubrid_lob_get(resource $conn_identifier,string $sql){}
/** @return bool */ function cubrid_lob_send(resource $conn_identifier,resource $lob_identifier){}
/** @return string */ function cubrid_lob_size(resource $lob_identifier){}
/** @return bool */ function cubrid_lock_read(resource $conn_identifier,string $oid){}
/** @return bool */ function cubrid_lock_write(resource $conn_identifier,string $oid){}
/** @return string */ function cubrid_new_glo(resource $conn_identifier,string $class_name,string $file_name){}
/** @return bool */ function cubrid_next_result(resource $result){}
/** @return int */ function cubrid_num_cols(resource $result){}
/** @return int */ function cubrid_num_fields(resource $result){}
/** @return int */ function cubrid_num_rows(resource $result){}
/** @return bool */ function cubrid_rollback(resource $conn_identifier){}
/** @return int */ function cubrid_save_to_glo(resource $conn_identifier,string $oid,string $file_name){}
/** @return int */ function cubrid_send_glo(resource $conn_identifier,string $oid){}
/** @return bool */ function cubrid_seq_drop(resource $conn_identifier,string $oid,string $attr_name,int $index){}
/** @return bool */ function cubrid_seq_insert(resource $conn_identifier,string $oid,string $attr_name,int $index,string $seq_element){}
/** @return bool */ function cubrid_seq_put(resource $conn_identifier,string $oid,string $attr_name,int $index,string $seq_element){}
/** @return bool */ function cubrid_set_add(resource $conn_identifier,string $oid,string $attr_name,string $set_element){}
/** @return bool */ function cubrid_set_autocommit(resource $conn_identifier,bool $mode){}
/** @return bool */ function cubrid_set_db_parameter(resource $conn_identifier,int $param_type,int $param_value){}
/** @return bool */ function cubrid_set_drop(resource $conn_identifier,string $oid,string $attr_name,string $set_element){}
/** @return bool */ function cubrid_set_query_timeout(resource $req_identifier,int $timeout){}
/** @return string */ function cubrid_version(){}
/** @return void */ function curl_close(resource $ch){}
/** @return resource */ function curl_copy_handle(resource $ch){}
/** @return int */ function curl_errno(resource $ch){}
/** @return string */ function curl_error(resource $ch){}
/** @return string */ function curl_escape(resource $ch,string $str){}
/** @return mixed */ function curl_exec(resource $ch){}
/** @return int */ function curl_multi_add_handle(resource $mh,resource $ch){}
/** @return void */ function curl_multi_close(resource $mh){}
/** @return int */ function curl_multi_exec(resource $mh,int &$still_running){}
/** @return string */ function curl_multi_getcontent(resource $ch){}
/** @return resource */ function curl_multi_init(){}
/** @return int */ function curl_multi_remove_handle(resource $mh,resource $ch){}
/** @return bool */ function curl_multi_setopt(resource $mh,int $option,mixed $value){}
/** @return string */ function curl_multi_strerror(int $errornum){}
/** @return int */ function curl_pause(resource $ch,int $bitmask){}
/** @return void */ function curl_reset(resource $ch){}
/** @return bool */ function curl_setopt_array(resource $ch,array $options){}
/** @return bool */ function curl_setopt(resource $ch,int $option,mixed $value){}
/** @return void */ function curl_share_close(resource $sh){}
/** @return resource */ function curl_share_init(){}
/** @return bool */ function curl_share_setopt(resource $sh,int $option,string $value){}
/** @return string */ function curl_strerror(int $errornum){}
/** @return string */ function curl_unescape(resource $ch,string $str){}
/** @return mixed */ function current(array &$array){}
/** @return bool */ function cyrus_bind(resource $connection,array $callbacks){}
/** @return bool */ function cyrus_close(resource $connection){}
/** @return array */ function cyrus_query(resource $connection,string $query){}
/** @return bool */ function cyrus_unbind(resource $connection,string $trigger_name){}
/** @return string */ function date_default_timezone_get(){}
/** @return bool */ function date_default_timezone_set(string $timezone_identifier){}
/** @return array */ function date_parse(string $date){}
/** @return array */ function date_parse_from_format(string $format,string $date){}
/** @return array */ function date_sun_info(int $time,float $latitude,float $longitude){}
/** @return object */ function db2_client_info(resource $connection){}
/** @return bool */ function db2_close(resource $connection){}
/** @return bool */ function db2_commit(resource $connection){}
/** @return int */ function db2_cursor_type(resource $stmt){}
/** @return string */ function db2_escape_string(string $string_literal){}
/** @return int */ function db2_field_display_size(resource $stmt,mixed $column){}
/** @return string */ function db2_field_name(resource $stmt,mixed $column){}
/** @return int */ function db2_field_num(resource $stmt,mixed $column){}
/** @return int */ function db2_field_precision(resource $stmt,mixed $column){}
/** @return int */ function db2_field_scale(resource $stmt,mixed $column){}
/** @return string */ function db2_field_type(resource $stmt,mixed $column){}
/** @return int */ function db2_field_width(resource $stmt,mixed $column){}
/** @return resource */ function db2_foreign_keys(resource $connection,string $qualifier,string $schema,string $table_name){}
/** @return bool */ function db2_free_result(resource $stmt){}
/** @return bool */ function db2_free_stmt(resource $stmt){}
/** @return string */ function db2_get_option(resource $resource,string $option){}
/** @return string */ function db2_last_insert_id(resource $resource){}
/** @return string */ function db2_lob_read(resource $stmt,int $colnum,int $length){}
/** @return resource */ function db2_next_result(resource $stmt){}
/** @return int */ function db2_num_fields(resource $stmt){}
/** @return int */ function db2_num_rows(resource $stmt){}
/** @return bool */ function db2_pclose(resource $resource){}
/** @return resource */ function db2_primary_keys(resource $connection,string $qualifier,string $schema,string $table_name){}
/** @return resource */ function db2_procedure_columns(resource $connection,string $qualifier,string $schema,string $procedure,string $parameter){}
/** @return resource */ function db2_procedures(resource $connection,string $qualifier,string $schema,string $procedure){}
/** @return mixed */ function db2_result(resource $stmt,mixed $column){}
/** @return bool */ function db2_rollback(resource $connection){}
/** @return object */ function db2_server_info(resource $connection){}
/** @return bool */ function db2_set_option(resource $resource,array $options,int $type){}
/** @return resource */ function db2_special_columns(resource $connection,string $qualifier,string $schema,string $table_name,int $scope){}
/** @return resource */ function db2_statistics(resource $connection,string $qualifier,string $schema,string $table_name,bool $unique){}
/** @return void */ function dba_close(resource $handle){}
/** @return bool */ function dba_delete(string $key,resource $handle){}
/** @return bool */ function dba_exists(string $key,resource $handle){}
/** @return string */ function dba_fetch(string $key,resource $handle){}
/** @return string */ function dba_firstkey(resource $handle){}
/** @return bool */ function dba_insert(string $key,string $value,resource $handle){}
/** @return mixed */ function dba_key_split(mixed $key){}
/** @return array */ function dba_list(){}
/** @return string */ function dba_nextkey(resource $handle){}
/** @return bool */ function dba_optimize(resource $handle){}
/** @return bool */ function dba_replace(string $key,string $value,resource $handle){}
/** @return bool */ function dbase_add_record(int $dbase_identifier,array $record){}
/** @return bool */ function dbase_close(int $dbase_identifier){}
/** @return int */ function dbase_create(string $filename,array $fields){}
/** @return bool */ function dbase_delete_record(int $dbase_identifier,int $record_number){}
/** @return array */ function dbase_get_header_info(int $dbase_identifier){}
/** @return array */ function dbase_get_record(int $dbase_identifier,int $record_number){}
/** @return array */ function dbase_get_record_with_names(int $dbase_identifier,int $record_number){}
/** @return int */ function dbase_numfields(int $dbase_identifier){}
/** @return int */ function dbase_numrecords(int $dbase_identifier){}
/** @return int */ function dbase_open(string $filename,int $mode){}
/** @return bool */ function dbase_pack(int $dbase_identifier){}
/** @return bool */ function dbase_replace_record(int $dbase_identifier,array $record,int $record_number){}
/** @return bool */ function dba_sync(resource $handle){}
/** @return int */ function dbplus_add(resource $relation,array $tuple){}
/** @return mixed */ function dbplus_close(resource $relation){}
/** @return int */ function dbplus_curr(resource $relation,array &$tuple){}
/** @return int */ function dbplus_errno(){}
/** @return int */ function dbplus_find(resource $relation,array $constraints,mixed $tuple){}
/** @return int */ function dbplus_first(resource $relation,array &$tuple){}
/** @return int */ function dbplus_flush(resource $relation){}
/** @return int */ function dbplus_freealllocks(){}
/** @return int */ function dbplus_freelock(resource $relation,string $tuple){}
/** @return int */ function dbplus_freerlocks(resource $relation){}
/** @return int */ function dbplus_getlock(resource $relation,string $tuple){}
/** @return int */ function dbplus_getunique(resource $relation,int $uniqueid){}
/** @return int */ function dbplus_info(resource $relation,string $key,array &$result){}
/** @return int */ function dbplus_last(resource $relation,array &$tuple){}
/** @return int */ function dbplus_lockrel(resource $relation){}
/** @return int */ function dbplus_next(resource $relation,array &$tuple){}
/** @return resource */ function dbplus_open(string $name){}
/** @return int */ function dbplus_prev(resource $relation,array &$tuple){}
/** @return int */ function dbplus_rchperm(resource $relation,int $mask,string $user,string $group){}
/** @return array */ function dbplus_resolve(string $relation_name){}
/** @return int */ function dbplus_restorepos(resource $relation,array $tuple){}
/** @return mixed */ function dbplus_rkeys(resource $relation,mixed $domlist){}
/** @return resource */ function dbplus_ropen(string $name){}
/** @return int */ function dbplus_rrename(resource $relation,string $name){}
/** @return mixed */ function dbplus_rsecindex(resource $relation,mixed $domlist,int $type){}
/** @return int */ function dbplus_runlink(resource $relation){}
/** @return int */ function dbplus_rzap(resource $relation){}
/** @return int */ function dbplus_savepos(resource $relation){}
/** @return int */ function dbplus_setindexbynumber(resource $relation,int $idx_number){}
/** @return int */ function dbplus_setindex(resource $relation,string $idx_name){}
/** @return string */ function dbplus_tcl(int $sid,string $script){}
/** @return int */ function dbplus_undo(resource $relation){}
/** @return int */ function dbplus_undoprepare(resource $relation){}
/** @return int */ function dbplus_unlockrel(resource $relation){}
/** @return int */ function dbplus_unselect(resource $relation){}
/** @return int */ function dbplus_update(resource $relation,array $old,array $new){}
/** @return int */ function dbplus_xlockrel(resource $relation){}
/** @return int */ function dbplus_xunlockrel(resource $relation){}
/** @return int */ function dbx_close(object $link_identifier){}
/** @return string */ function dbx_error(object $link_identifier){}
/** @return string */ function dbx_escape_string(object $link_identifier,string $text){}
/** @return mixed */ function dbx_fetch_row(object $result_identifier){}
/** @return bool */ function dbx_sort(object $result,string $user_compare_function){}
/** @return string */ function dcgettext(string $domain,string $message,int $category){}
/** @return string */ function dcngettext(string $domain,string $msgid1,string $msgid2,int $n,int $category){}
/** @return string */ function decbin(int $number){}
/** @return string */ function dechex(int $number){}
/** @return string */ function decoct(int $number){}
/** @return bool */ function defined(string $name){}
/** @return void */ function define_syslog_variables(){}
/** @return float */ function deg2rad(float $number){}
/** @return void */ function delete(){}
/** @return string */ function dgettext(string $domain,string $message){}
/** @return void */ function dio_close(resource $fd){}
/** @return array */ function dio_stat(resource $fd){}
/** @return bool */ function dio_tcsetattr(resource $fd,array $options){}
/** @return bool */ function dio_truncate(resource $fd,int $offset){}
/** @return string */ function dirname(string $path){}
/** @return float */ function disk_free_space(string $directory){}
/** @return float */ function disk_total_space(string $directory){}
/** @return bool */ function dl(string $library){}
/** @return string */ function dngettext(string $domain,string $msgid1,string $msgid2,int $n){}
/** @return DOMElement */ function dom_import_simplexml(SimpleXMLElement $node){}
/** @return array */ function each(array &$array){}
/** @return void */ function eio_cancel(resource $req){}
/** @return bool */ function eio_event_loop(){}
/** @return mixed */ function eio_get_event_stream(){}
/** @return string */ function eio_get_last_error(resource $req){}
/** @return void */ function eio_grp_add(resource $grp,resource $req){}
/** @return void */ function eio_grp_cancel(resource $grp){}
/** @return void */ function eio_grp_limit(resource $grp,int $limit){}
/** @return void */ function eio_init(){}
/** @return int */ function eio_npending(){}
/** @return int */ function eio_nready(){}
/** @return int */ function eio_nreqs(){}
/** @return int */ function eio_nthreads(){}
/** @return int */ function eio_poll(){}
/** @return void */ function eio_set_max_idle(int $nthreads){}
/** @return void */ function eio_set_max_parallel(int $nthreads){}
/** @return void */ function eio_set_max_poll_reqs(int $nreqs){}
/** @return void */ function eio_set_max_poll_time(float $nseconds){}
/** @return void */ function eio_set_min_parallel(string $nthreads){}
/** @return array */ function enchant_broker_describe(resource $broker){}
/** @return bool */ function enchant_broker_dict_exists(resource $broker,string $tag){}
/** @return bool */ function enchant_broker_free(resource $broker){}
/** @return bool */ function enchant_broker_free_dict(resource $dict){}
/** @return string */ function enchant_broker_get_error(resource $broker){}
/** @return resource */ function enchant_broker_init(){}
/** @return mixed */ function enchant_broker_list_dicts(resource $broker){}
/** @return resource */ function enchant_broker_request_dict(resource $broker,string $tag){}
/** @return resource */ function enchant_broker_request_pwl_dict(resource $broker,string $filename){}
/** @return bool */ function enchant_broker_set_ordering(resource $broker,string $tag,string $ordering){}
/** @return void */ function enchant_dict_add_to_personal(resource $dict,string $word){}
/** @return void */ function enchant_dict_add_to_session(resource $dict,string $word){}
/** @return bool */ function enchant_dict_check(resource $dict,string $word){}
/** @return mixed */ function enchant_dict_describe(resource $dict){}
/** @return string */ function enchant_dict_get_error(resource $dict){}
/** @return bool */ function enchant_dict_is_in_session(resource $dict,string $word){}
/** @return void */ function enchant_dict_store_replacement(resource $dict,string $mis,string $cor){}
/** @return array */ function enchant_dict_suggest(resource $dict,string $word){}
/** @return mixed */ function end(array &$array){}
/** @return string */ function eregi_replace(string $pattern,string $replacement,string $string){}
/** @return string */ function ereg_replace(string $pattern,string $replacement,string $string){}
/** @return array */ function error_get_last(){}
/** @return string */ function escapeshellarg(string $arg){}
/** @return string */ function escapeshellcmd(string $command){}
/** @return void */ function event_base_free(resource $event_base){}
/** @return bool */ function event_base_loopbreak(resource $event_base){}
/** @return resource */ function event_base_new(){}
/** @return bool */ function event_base_priority_init(resource $event_base,int $npriorities){}
/** @return bool */ function event_base_reinit(resource $event_base){}
/** @return bool */ function event_base_set(resource $event,resource $event_base){}
/** @return bool */ function event_buffer_base_set(resource $bevent,resource $event_base){}
/** @return bool */ function event_buffer_disable(resource $bevent,int $events){}
/** @return bool */ function event_buffer_enable(resource $bevent,int $events){}
/** @return void */ function event_buffer_fd_set(resource $bevent,resource $fd){}
/** @return void */ function event_buffer_free(resource $bevent){}
/** @return bool */ function event_buffer_priority_set(resource $bevent,int $priority){}
/** @return string */ function event_buffer_read(resource $bevent,int $data_size){}
/** @return void */ function event_buffer_timeout_set(resource $bevent,int $read_timeout,int $write_timeout){}
/** @return void */ function event_buffer_watermark_set(resource $bevent,int $events,int $lowmark,int $highmark){}
/** @return bool */ function event_del(resource $event){}
/** @return void */ function event_free(resource $event){}
/** @return resource */ function event_new(){}
/** @return bool */ function event_priority_set(resource $event,int $priority){}
/** @return int */ function exif_imagetype(string $filename){}
/** @return string */ function exif_tagname(int $index){}
/** @return resource */ function expect_popen(string $command){}
/** @return float */ function exp(float $arg){}
/** @return float */ function expm1(float $arg){}
/** @return bool */ function extension_loaded(string $name){}
/** @return int */ function ezmlm_hash(string $addr){}
/** @return bool */ function fam_cancel_monitor(resource $fam,resource $fam_monitor){}
/** @return void */ function fam_close(resource $fam){}
/** @return resource */ function fam_monitor_collection(resource $fam,string $dirname,int $depth,string $mask){}
/** @return resource */ function fam_monitor_directory(resource $fam,string $dirname){}
/** @return resource */ function fam_monitor_file(resource $fam,string $filename){}
/** @return array */ function fam_next_event(resource $fam){}
/** @return int */ function fam_pending(resource $fam){}
/** @return bool */ function fam_resume_monitor(resource $fam,resource $fam_monitor){}
/** @return bool */ function fam_suspend_monitor(resource $fam,resource $fam_monitor){}
/** @return bool */ function fann_cascadetrain_on_data(resource $ann,resource $data,int $max_neurons,int $neurons_between_reports,float $desired_error){}
/** @return bool */ function fann_cascadetrain_on_file(resource $ann,string $filename,int $max_neurons,int $neurons_between_reports,float $desired_error){}
/** @return bool */ function fann_clear_scaling_params(resource $ann){}
/** @return resource */ function fann_copy(resource $ann){}
/** @return resource */ function fann_create_from_file(string $configuration_file){}
/** @return resource */ function fann_create_shortcut_array(int $num_layers,array $layers){}
/** @return ReturnType */ function fann_create_sparse_array(float $connection_rate,int $num_layers,array $layers){}
/** @return resource */ function fann_create_standard_array(int $num_layers,array $layers){}
/** @return resource */ function fann_create_train_from_callback(int $num_data,int $num_input,int $num_output,collable $user_function){}
/** @return resource */ function fann_create_train(int $num_data,int $num_input,int $num_output){}
/** @return bool */ function fann_descale_input(resource $ann,array $input_vector){}
/** @return bool */ function fann_descale_output(resource $ann,array $output_vector){}
/** @return bool */ function fann_descale_train(resource $ann,resource $train_data){}
/** @return bool */ function fann_destroy(resource $ann){}
/** @return bool */ function fann_destroy_train(resource $train_data){}
/** @return resource */ function fann_duplicate_train_data(resource $data){}
/** @return int */ function fann_get_activation_function(resource $ann,int $layer,int $neuron){}
/** @return float */ function fann_get_activation_steepness(resource $ann,int $layer,int $neuron){}
/** @return array */ function fann_get_bias_array(resource $ann){}
/** @return int */ function fann_get_bit_fail(resource $ann){}
/** @return float */ function fann_get_bit_fail_limit(resource $ann){}
/** @return array */ function fann_get_cascade_activation_functions(resource $ann){}
/** @return int */ function fann_get_cascade_activation_functions_count(resource $ann){}
/** @return array */ function fann_get_cascade_activation_steepnesses(resource $ann){}
/** @return int */ function fann_get_cascade_activation_steepnesses_count(resource $ann){}
/** @return float */ function fann_get_cascade_candidate_change_fraction(resource $ann){}
/** @return float */ function fann_get_cascade_candidate_limit(resource $ann){}
/** @return float */ function fann_get_cascade_candidate_stagnation_epochs(resource $ann){}
/** @return int */ function fann_get_cascade_max_cand_epochs(resource $ann){}
/** @return int */ function fann_get_cascade_max_out_epochs(resource $ann){}
/** @return int */ function fann_get_cascade_min_cand_epochs(resource $ann){}
/** @return int */ function fann_get_cascade_min_out_epochs(resource $ann){}
/** @return int */ function fann_get_cascade_num_candidate_groups(resource $ann){}
/** @return int */ function fann_get_cascade_num_candidates(resource $ann){}
/** @return float */ function fann_get_cascade_output_change_fraction(resource $ann){}
/** @return int */ function fann_get_cascade_output_stagnation_epochs(resource $ann){}
/** @return float */ function fann_get_cascade_weight_multiplier(resource $ann){}
/** @return array */ function fann_get_connection_array(resource $ann){}
/** @return float */ function fann_get_connection_rate(resource $ann){}
/** @return int */ function fann_get_errno(resource $errdat){}
/** @return string */ function fann_get_errstr(resource $errdat){}
/** @return array */ function fann_get_layer_array(resource $ann){}
/** @return float */ function fann_get_learning_momentum(resource $ann){}
/** @return float */ function fann_get_learning_rate(resource $ann){}
/** @return float */ function fann_get_MSE(resource $ann){}
/** @return int */ function fann_get_network_type(resource $ann){}
/** @return int */ function fann_get_num_input(resource $ann){}
/** @return int */ function fann_get_num_layers(resource $ann){}
/** @return int */ function fann_get_num_output(resource $ann){}
/** @return float */ function fann_get_quickprop_decay(resource $ann){}
/** @return float */ function fann_get_quickprop_mu(resource $ann){}
/** @return float */ function fann_get_rprop_decrease_factor(resource $ann){}
/** @return float */ function fann_get_rprop_delta_max(resource $ann){}
/** @return float */ function fann_get_rprop_delta_min(resource $ann){}
/** @return ReturnType */ function fann_get_rprop_delta_zero(resource $ann){}
/** @return float */ function fann_get_rprop_increase_factor(resource $ann){}
/** @return float */ function fann_get_sarprop_step_error_shift(resource $ann){}
/** @return float */ function fann_get_sarprop_step_error_threshold_factor(resource $ann){}
/** @return float */ function fann_get_sarprop_temperature(resource $ann){}
/** @return float */ function fann_get_sarprop_weight_decay_shift(resource $ann){}
/** @return int */ function fann_get_total_connections(resource $ann){}
/** @return int */ function fann_get_total_neurons(resource $ann){}
/** @return int */ function fann_get_train_error_function(resource $ann){}
/** @return int */ function fann_get_training_algorithm(resource $ann){}
/** @return int */ function fann_get_train_stop_function(resource $ann){}
/** @return bool */ function fann_init_weights(resource $ann,resource $train_data){}
/** @return int */ function fann_length_train_data(resource $data){}
/** @return resource */ function fann_merge_train_data(resource $data1,resource $data2){}
/** @return int */ function fann_num_input_train_data(resource $data){}
/** @return int */ function fann_num_output_train_data(resource $data){}
/** @return void */ function fann_print_error(string $errdat){}
/** @return bool */ function fann_randomize_weights(resource $ann,float $min_weight,float $max_weight){}
/** @return resource */ function fann_read_train_from_file(string $filename){}
/** @return void */ function fann_reset_errno(resource $errdat){}
/** @return void */ function fann_reset_errstr(resource $errdat){}
/** @return bool */ function fann_reset_MSE(string $ann){}
/** @return array */ function fann_run(resource $ann,array $input){}
/** @return bool */ function fann_save(resource $ann,string $configuration_file){}
/** @return bool */ function fann_save_train(resource $data,string $file_name){}
/** @return bool */ function fann_scale_input(resource $ann,array $input_vector){}
/** @return bool */ function fann_scale_input_train_data(resource $train_data,float $new_min,float $new_max){}
/** @return bool */ function fann_scale_output(resource $ann,array $output_vector){}
/** @return bool */ function fann_scale_output_train_data(resource $train_data,float $new_min,float $new_max){}
/** @return bool */ function fann_scale_train(resource $ann,resource $train_data){}
/** @return bool */ function fann_scale_train_data(resource $train_data,float $new_min,float $new_max){}
/** @return bool */ function fann_set_activation_function(resource $ann,int $activation_function,int $layer,int $neuron){}
/** @return bool */ function fann_set_activation_function_hidden(resource $ann,int $activation_function){}
/** @return bool */ function fann_set_activation_function_layer(resource $ann,int $activation_function,int $layer){}
/** @return bool */ function fann_set_activation_function_output(resource $ann,int $activation_function){}
/** @return bool */ function fann_set_activation_steepness(resource $ann,float $activation_steepness,int $layer,int $neuron){}
/** @return bool */ function fann_set_activation_steepness_hidden(resource $ann,float $activation_steepness){}
/** @return bool */ function fann_set_activation_steepness_layer(resource $ann,float $activation_steepness,int $layer){}
/** @return bool */ function fann_set_activation_steepness_output(resource $ann,float $activation_steepness){}
/** @return bool */ function fann_set_bit_fail_limit(resource $ann,float $bit_fail_limit){}
/** @return bool */ function fann_set_callback(resource $ann,collable $callback){}
/** @return bool */ function fann_set_cascade_activation_functions(resource $ann,array $cascade_activation_functions){}
/** @return bool */ function fann_set_cascade_activation_steepnesses(resource $ann,array $cascade_activation_steepnesses_count){}
/** @return bool */ function fann_set_cascade_candidate_change_fraction(resource $ann,float $cascade_candidate_change_fraction){}
/** @return bool */ function fann_set_cascade_candidate_limit(resource $ann,float $cascade_candidate_limit){}
/** @return bool */ function fann_set_cascade_candidate_stagnation_epochs(resource $ann,int $cascade_candidate_stagnation_epochs){}
/** @return bool */ function fann_set_cascade_max_cand_epochs(resource $ann,int $cascade_max_cand_epochs){}
/** @return bool */ function fann_set_cascade_max_out_epochs(resource $ann,int $cascade_max_out_epochs){}
/** @return bool */ function fann_set_cascade_min_cand_epochs(resource $ann,int $cascade_min_cand_epochs){}
/** @return bool */ function fann_set_cascade_min_out_epochs(resource $ann,int $cascade_min_out_epochs){}
/** @return bool */ function fann_set_cascade_num_candidate_groups(resource $ann,int $cascade_num_candidate_groups){}
/** @return bool */ function fann_set_cascade_output_change_fraction(resource $ann,float $cascade_output_change_fraction){}
/** @return bool */ function fann_set_cascade_output_stagnation_epochs(resource $ann,int $cascade_output_stagnation_epochs){}
/** @return bool */ function fann_set_cascade_weight_multiplier(resource $ann,float $cascade_weight_multiplier){}
/** @return void */ function fann_set_error_log(resource $errdat,string $log_file){}
/** @return bool */ function fann_set_input_scaling_params(resource $ann,resource $train_data,float $new_input_min,float $new_input_max){}
/** @return bool */ function fann_set_learning_momentum(resource $ann,float $learning_momentum){}
/** @return bool */ function fann_set_learning_rate(resource $ann,float $learning_rate){}
/** @return bool */ function fann_set_output_scaling_params(resource $ann,resource $train_data,float $new_output_min,float $new_output_max){}
/** @return bool */ function fann_set_quickprop_decay(resource $ann,float $quickprop_decay){}
/** @return bool */ function fann_set_quickprop_mu(resource $ann,float $quickprop_mu){}
/** @return bool */ function fann_set_rprop_decrease_factor(resource $ann,float $rprop_decrease_factor){}
/** @return bool */ function fann_set_rprop_delta_max(resource $ann,float $rprop_delta_max){}
/** @return bool */ function fann_set_rprop_delta_min(resource $ann,float $rprop_delta_min){}
/** @return bool */ function fann_set_rprop_delta_zero(resource $ann,float $rprop_delta_zero){}
/** @return bool */ function fann_set_rprop_increase_factor(resource $ann,float $rprop_increase_factor){}
/** @return bool */ function fann_set_sarprop_step_error_shift(resource $ann,float $sarprop_step_error_shift){}
/** @return bool */ function fann_set_sarprop_step_error_threshold_factor(resource $ann,float $sarprop_step_error_threshold_factor){}
/** @return bool */ function fann_set_sarprop_temperature(resource $ann,float $sarprop_temperature){}
/** @return bool */ function fann_set_sarprop_weight_decay_shift(resource $ann,float $sarprop_weight_decay_shift){}
/** @return bool */ function fann_set_scaling_params(resource $ann,resource $train_data,float $new_input_min,float $new_input_max,float $new_output_min,float $new_output_max){}
/** @return bool */ function fann_set_train_error_function(resource $ann,int $error_function){}
/** @return bool */ function fann_set_training_algorithm(resource $ann,int $training_algorithm){}
/** @return bool */ function fann_set_train_stop_function(resource $ann,int $stop_function){}
/** @return bool */ function fann_set_weight_array(resource $ann,array $connections){}
/** @return bool */ function fann_set_weight(resource $ann,int $from_neuron,int $to_neuron,float $weight){}
/** @return bool */ function fann_shuffle_train_data(resource $train_data){}
/** @return resource */ function fann_subset_train_data(resource $data,int $pos,int $length){}
/** @return bool */ function fann_test(resource $ann,array $input,array $desired_output){}
/** @return float */ function fann_test_data(resource $ann,resource $data){}
/** @return bool */ function fann_train(resource $ann,array $input,array $desired_output){}
/** @return float */ function fann_train_epoch(resource $ann,resource $data){}
/** @return bool */ function fann_train_on_data(resource $ann,resource $data,int $max_epochs,int $epochs_between_reports,float $desired_error){}
/** @return bool */ function fann_train_on_file(resource $ann,string $filename,int $max_epochs,int $epochs_between_reports,float $desired_error){}
/** @return boolean */ function fastcgi_finish_request(){}
/** @return bool */ function fbsql_data_seek(resource $result,int $row_number){}
/** @return array */ function fbsql_fetch_assoc(resource $result){}
/** @return array */ function fbsql_fetch_lengths(resource $result){}
/** @return object */ function fbsql_fetch_object(resource $result){}
/** @return array */ function fbsql_fetch_row(resource $result){}
/** @return bool */ function fbsql_free_result(resource $result){}
/** @return bool */ function fbsql_next_result(resource $result){}
/** @return int */ function fbsql_num_fields(resource $result){}
/** @return int */ function fbsql_num_rows(resource $result){}
/** @return int */ function fbsql_rows_fetched(resource $result){}
/** @return bool */ function fbsql_set_lob_mode(resource $result,int $lob_mode){}
/** @return bool */ function fbsql_set_password(resource $link_identifier,string $user,string $password,string $old_password){}
/** @return void */ function fbsql_set_transaction(resource $link_identifier,int $locking,int $isolation){}
/** @return string */ function fbsql_table_name(resource $result,int $index){}
/** @return bool */ function fclose(resource $handle){}
/** @return bool */ function fdf_add_doc_javascript(resource $fdf_document,string $script_name,string $script_code){}
/** @return bool */ function fdf_add_template(resource $fdf_document,int $newpage,string $filename,string $template,int $rename){}
/** @return void */ function fdf_close(resource $fdf_document){}
/** @return resource */ function fdf_create(){}
/** @return int */ function fdf_errno(){}
/** @return bool */ function fdf_get_ap(resource $fdf_document,string $field,int $face,string $filename){}
/** @return array */ function fdf_get_attachment(resource $fdf_document,string $fieldname,string $savepath){}
/** @return string */ function fdf_get_encoding(resource $fdf_document){}
/** @return string */ function fdf_get_file(resource $fdf_document){}
/** @return int */ function fdf_get_flags(resource $fdf_document,string $fieldname,int $whichflags){}
/** @return string */ function fdf_get_status(resource $fdf_document){}
/** @return void */ function fdf_header(){}
/** @return resource */ function fdf_open(string $filename){}
/** @return resource */ function fdf_open_string(string $fdf_data){}
/** @return bool */ function fdf_remove_item(resource $fdf_document,string $fieldname,int $item){}
/** @return string */ function fdf_save_string(resource $fdf_document){}
/** @return bool */ function fdf_set_ap(resource $fdf_document,string $field_name,int $face,string $filename,int $page_number){}
/** @return bool */ function fdf_set_encoding(resource $fdf_document,string $encoding){}
/** @return bool */ function fdf_set_flags(resource $fdf_document,string $fieldname,int $whichFlags,int $newFlags){}
/** @return bool */ function fdf_set_javascript_action(resource $fdf_document,string $fieldname,int $trigger,string $script){}
/** @return bool */ function fdf_set_on_import_javascript(resource $fdf_document,string $script,bool $before_data_import){}
/** @return bool */ function fdf_set_opt(resource $fdf_document,string $fieldname,int $element,string $str1,string $str2){}
/** @return bool */ function fdf_set_status(resource $fdf_document,string $status){}
/** @return bool */ function fdf_set_submit_form_action(resource $fdf_document,string $fieldname,int $trigger,string $script,int $flags){}
/** @return bool */ function fdf_set_target_frame(resource $fdf_document,string $frame_name){}
/** @return bool */ function fdf_set_version(resource $fdf_document,string $version){}
/** @return bool */ function feof(resource $handle){}
/** @return bool */ function fflush(resource $handle){}
/** @return string */ function fgetc(resource $handle){}
/** @return int */ function fileatime(string $filename){}
/** @return int */ function filectime(string $filename){}
/** @return bool */ function file_exists(string $filename){}
/** @return int */ function filegroup(string $filename){}
/** @return int */ function fileinode(string $filename){}
/** @return int */ function filemtime(string $filename){}
/** @return int */ function fileowner(string $filename){}
/** @return int */ function fileperms(string $filename){}
/** @return bool */ function filepro(string $directory){}
/** @return int */ function filepro_fieldcount(){}
/** @return string */ function filepro_fieldname(int $field_number){}
/** @return string */ function filepro_fieldtype(int $field_number){}
/** @return int */ function filepro_fieldwidth(int $field_number){}
/** @return string */ function filepro_retrieve(int $row_number,int $field_number){}
/** @return int */ function filepro_rowcount(){}
/** @return int */ function filesize(string $filename){}
/** @return string */ function filetype(string $filename){}
/** @return bool */ function filter_has_var(int $type,string $variable_name){}
/** @return int */ function filter_id(string $filtername){}
/** @return array */ function filter_list(){}
/** @return string */ function finfo_buffer(resource $finfo,string $string,int $options,resource $context){}
/** @return bool */ function finfo_close(resource $finfo){}
/** @return string */ function finfo_file(resource $finfo,string $file_name,int $options,resource $context){}
/** @return resource */ function finfo_open(int $options,string $magic_file){}
/** @return bool */ function finfo_set_flags(resource $finfo,int $options){}
/** @return float */ function floatval(mixed $var){}
/** @return float */ function floor(float $value){}
/** @return void */ function flush(){}
/** @return float */ function fmod(float $x,float $y){}
/** @return mixed */ function forward_static_call_array(callable $function,array $parameters){}
/** @return int */ function fpassthru(resource $handle){}
/** @return string */ function fread(resource $handle,int $length){}
/** @return int */ function frenchtojd(int $month,int $day,int $year){}
/** @return string */ function fribidi_log2vis(string $str,string $direction,int $charset){}
/** @return array */ function fstat(resource $handle){}
/** @return int */ function ftell(resource $handle){}
/** @return int */ function ftok(string $pathname,string $proj){}
/** @return bool */ function ftp_cdup(resource $ftp_stream){}
/** @return bool */ function ftp_chdir(resource $ftp_stream,string $directory){}
/** @return int */ function ftp_chmod(resource $ftp_stream,int $mode,string $filename){}
/** @return bool */ function ftp_close(resource $ftp_stream){}
/** @return bool */ function ftp_delete(resource $ftp_stream,string $path){}
/** @return bool */ function ftp_exec(resource $ftp_stream,string $command){}
/** @return mixed */ function ftp_get_option(resource $ftp_stream,int $option){}
/** @return bool */ function ftp_login(resource $ftp_stream,string $username,string $password){}
/** @return int */ function ftp_mdtm(resource $ftp_stream,string $remote_file){}
/** @return string */ function ftp_mkdir(resource $ftp_stream,string $directory){}
/** @return int */ function ftp_nb_continue(resource $ftp_stream){}
/** @return array */ function ftp_nlist(resource $ftp_stream,string $directory){}
/** @return bool */ function ftp_pasv(resource $ftp_stream,bool $pasv){}
/** @return string */ function ftp_pwd(resource $ftp_stream){}
/** @return array */ function ftp_raw(resource $ftp_stream,string $command){}
/** @return bool */ function ftp_rename(resource $ftp_stream,string $oldname,string $newname){}
/** @return bool */ function ftp_rmdir(resource $ftp_stream,string $directory){}
/** @return bool */ function ftp_set_option(resource $ftp_stream,int $option,mixed $value){}
/** @return bool */ function ftp_site(resource $ftp_stream,string $cmd){}
/** @return int */ function ftp_size(resource $ftp_stream,string $remote_file){}
/** @return string */ function ftp_systype(resource $ftp_stream){}
/** @return bool */ function ftruncate(resource $handle,int $size){}
/** @return mixed */ function func_get_arg(int $arg_num){}
/** @return array */ function func_get_args(){}
/** @return int */ function func_num_args(){}
/** @return bool */ function function_exists(string $function_name){}
/** @return int */ function gc_collect_cycles(){}
/** @return void */ function gc_disable(){}
/** @return bool */ function gc_enabled(){}
/** @return void */ function gc_enable(){}
/** @return array */ function gd_info(){}
/** @return string */ function geoip_asnum_by_name(string $hostname){}
/** @return string */ function geoip_continent_code_by_name(string $hostname){}
/** @return string */ function geoip_country_code3_by_name(string $hostname){}
/** @return string */ function geoip_country_code_by_name(string $hostname){}
/** @return string */ function geoip_country_name_by_name(string $hostname){}
/** @return bool */ function geoip_db_avail(int $database){}
/** @return string */ function geoip_db_filename(int $database){}
/** @return array */ function geoip_db_get_all_info(){}
/** @return string */ function geoip_domain_by_name(string $hostname){}
/** @return int */ function geoip_id_by_name(string $hostname){}
/** @return string */ function geoip_isp_by_name(string $hostname){}
/** @return string */ function geoip_netspeedcell_by_name(string $hostname){}
/** @return string */ function geoip_org_by_name(string $hostname){}
/** @return array */ function geoip_record_by_name(string $hostname){}
/** @return array */ function geoip_region_by_name(string $hostname){}
/** @return string */ function geoip_region_name_by_code(string $country_code,string $region_code){}
/** @return void */ function geoip_setup_custom_directory(string $path){}
/** @return array */ function getallheaders(){}
/** @return string */ function get_called_class(){}
/** @return string */ function get_cfg_var(string $option){}
/** @return array */ function get_class_methods(mixed $class_name){}
/** @return array */ function get_class_vars(string $class_name){}
/** @return string */ function get_current_user(){}
/** @return string */ function getcwd(){}
/** @return array */ function get_declared_classes(){}
/** @return array */ function get_declared_interfaces(){}
/** @return array */ function get_declared_traits(){}
/** @return array */ function get_defined_functions(){}
/** @return array */ function get_defined_vars(){}
/** @return string */ function getenv(string $varname){}
/** @return array */ function get_extension_funcs(string $module_name){}
/** @return string */ function gethostbyaddr(string $ip_address){}
/** @return array */ function gethostbynamel(string $hostname){}
/** @return string */ function gethostbyname(string $hostname){}
/** @return string */ function gethostname(){}
/** @return array */ function get_included_files(){}
/** @return string */ function get_include_path(){}
/** @return int */ function getlastmod(){}
/** @return bool */ function get_magic_quotes_gpc(){}
/** @return bool */ function get_magic_quotes_runtime(){}
/** @return int */ function getmygid(){}
/** @return int */ function getmyinode(){}
/** @return int */ function getmypid(){}
/** @return int */ function getmyuid(){}
/** @return array */ function get_object_vars(object $obj){}
/** @return int */ function getprotobyname(string $name){}
/** @return string */ function getprotobynumber(int $number){}
/** @return int */ function getrandmax(){}
/** @return string */ function get_resource_type(resource $handle){}
/** @return int */ function getservbyname(string $service,string $protocol){}
/** @return string */ function getservbyport(int $port,string $protocol){}
/** @return string */ function gettext(string $message){}
/** @return string */ function gettype(mixed $var){}
/** @return GMP */ function gmp_abs(GMP $a){}
/** @return GMP */ function gmp_add(GMP $a,GMP $b){}
/** @return GMP */ function gmp_and(GMP $a,GMP $b){}
/** @return void */ function gmp_clrbit(GMP $a,int $index){}
/** @return int */ function gmp_cmp(GMP $a,GMP $b){}
/** @return GMP */ function gmp_com(GMP $a){}
/** @return GMP */ function gmp_divexact(GMP $n,GMP $d){}
/** @return string */ function gmp_export(GMP $gmpnumber,integer $word_size,integer $options){}
/** @return GMP */ function gmp_fact(mixed $a){}
/** @return array */ function gmp_gcdext(GMP $a,GMP $b){}
/** @return GMP */ function gmp_gcd(GMP $a,GMP $b){}
/** @return int */ function gmp_hamdist(GMP $a,GMP $b){}
/** @return GMP */ function gmp_import(string $data,integer $word_size,integer $options){}
/** @return int */ function gmp_intval(GMP $gmpnumber){}
/** @return GMP */ function gmp_invert(GMP $a,GMP $b){}
/** @return int */ function gmp_jacobi(GMP $a,GMP $p){}
/** @return int */ function gmp_legendre(GMP $a,GMP $p){}
/** @return GMP */ function gmp_mod(GMP $n,GMP $d){}
/** @return GMP */ function gmp_mul(GMP $a,GMP $b){}
/** @return GMP */ function gmp_neg(GMP $a){}
/** @return GMP */ function gmp_nextprime(int $a){}
/** @return GMP */ function gmp_or(GMP $a,GMP $b){}
/** @return bool */ function gmp_perfect_square(GMP $a){}
/** @return int */ function gmp_popcount(GMP $a){}
/** @return GMP */ function gmp_pow(GMP $base,int $exp){}
/** @return GMP */ function gmp_powm(GMP $base,GMP $exp,GMP $mod){}
/** @return GMP */ function gmp_random_bits(integer $bits){}
/** @return GMP */ function gmp_random_range(GMP $min,GMP $max){}
/** @return GMP */ function gmp_root(GMP $a,int $nth){}
/** @return array */ function gmp_rootrem(GMP $a,int $nth){}
/** @return int */ function gmp_scan0(GMP $a,int $start){}
/** @return int */ function gmp_scan1(GMP $a,int $start){}
/** @return int */ function gmp_sign(GMP $a){}
/** @return GMP */ function gmp_sqrt(GMP $a){}
/** @return array */ function gmp_sqrtrem(GMP $a){}
/** @return GMP */ function gmp_sub(GMP $a,GMP $b){}
/** @return bool */ function gmp_testbit(GMP $a,int $index){}
/** @return GMP */ function gmp_xor(GMP $a,GMP $b){}
/** @return bool */ function gnupg_adddecryptkey(resource $identifier,string $fingerprint,string $passphrase){}
/** @return bool */ function gnupg_addencryptkey(resource $identifier,string $fingerprint){}
/** @return bool */ function gnupg_cleardecryptkeys(resource $identifier){}
/** @return bool */ function gnupg_clearencryptkeys(resource $identifier){}
/** @return bool */ function gnupg_clearsignkeys(resource $identifier){}
/** @return string */ function gnupg_decrypt(resource $identifier,string $text){}
/** @return array */ function gnupg_decryptverify(resource $identifier,string $text,string &$plaintext){}
/** @return string */ function gnupg_encryptsign(resource $identifier,string $plaintext){}
/** @return string */ function gnupg_encrypt(resource $identifier,string $plaintext){}
/** @return string */ function gnupg_export(resource $identifier,string $fingerprint){}
/** @return string */ function gnupg_geterror(resource $identifier){}
/** @return int */ function gnupg_getprotocol(resource $identifier){}
/** @return array */ function gnupg_import(resource $identifier,string $keydata){}
/** @return resource */ function gnupg_init(){}
/** @return array */ function gnupg_keyinfo(resource $identifier,string $pattern){}
/** @return bool */ function gnupg_setarmor(resource $identifier,int $armor){}
/** @return void */ function gnupg_seterrormode(resource $identifier,int $errormode){}
/** @return bool */ function gnupg_setsignmode(resource $identifier,int $signmode){}
/** @return string */ function gnupg_sign(resource $identifier,string $plaintext){}
/** @return array */ function gopher_parsedir(string $dirent){}
/** @return string */ function grapheme_extract(string $haystack,int $size,int $extract_type,int $start,int &$next){}
/** @return int */ function grapheme_stripos(string $haystack,string $needle,int $offset){}
/** @return string */ function grapheme_stristr(string $haystack,string $needle,bool $before_needle){}
/** @return int */ function grapheme_strlen(string $input){}
/** @return int */ function grapheme_strpos(string $haystack,string $needle,int $offset){}
/** @return int */ function grapheme_strripos(string $haystack,string $needle,int $offset){}
/** @return int */ function grapheme_strrpos(string $haystack,string $needle,int $offset){}
/** @return string */ function grapheme_strstr(string $haystack,string $needle,bool $before_needle){}
/** @return int */ function grapheme_substr(string $string,int $start,int $length){}
/** @return int */ function gregoriantojd(int $month,int $day,int $year){}
/** @return string */ function gupnp_context_get_host_ip(resource $context){}
/** @return int */ function gupnp_context_get_port(resource $context){}
/** @return int */ function gupnp_context_get_subscription_timeout(resource $context){}
/** @return bool */ function gupnp_context_host_path(resource $context,string $local_path,string $server_path){}
/** @return void */ function gupnp_context_set_subscription_timeout(resource $context,int $timeout){}
/** @return bool */ function gupnp_context_unhost_path(resource $context,string $server_path){}
/** @return bool */ function gupnp_control_point_browse_start(resource $cpoint){}
/** @return bool */ function gupnp_control_point_browse_stop(resource $cpoint){}
/** @return resource */ function gupnp_control_point_new(resource $context,string $target){}
/** @return array */ function gupnp_device_info_get(resource $root_device){}
/** @return resource */ function gupnp_device_info_get_service(resource $root_device,string $type){}
/** @return bool */ function gupnp_root_device_get_available(resource $root_device){}
/** @return string */ function gupnp_root_device_get_relative_location(resource $root_device){}
/** @return resource */ function gupnp_root_device_new(resource $context,string $location,string $description_dir){}
/** @return bool */ function gupnp_root_device_set_available(resource $root_device,bool $available){}
/** @return bool */ function gupnp_root_device_start(resource $root_device){}
/** @return bool */ function gupnp_root_device_stop(resource $root_device){}
/** @return mixed */ function gupnp_service_action_get(resource $action,string $name,int $type){}
/** @return bool */ function gupnp_service_action_return(resource $action){}
/** @return bool */ function gupnp_service_action_set(resource $action,string $name,int $type,mixed $value){}
/** @return bool */ function gupnp_service_freeze_notify(resource $service){}
/** @return array */ function gupnp_service_info_get(resource $proxy){}
/** @return array */ function gupnp_service_introspection_get_state_variable(resource $introspection,string $variable_name){}
/** @return bool */ function gupnp_service_notify(resource $service,string $name,int $type,mixed $value){}
/** @return mixed */ function gupnp_service_proxy_action_get(resource $proxy,string $action,string $name,int $type){}
/** @return bool */ function gupnp_service_proxy_action_set(resource $proxy,string $action,string $name,mixed $value,int $type){}
/** @return bool */ function gupnp_service_proxy_get_subscribed(resource $proxy){}
/** @return bool */ function gupnp_service_proxy_remove_notify(resource $proxy,string $value){}
/** @return bool */ function gupnp_service_proxy_set_subscribed(resource $proxy,bool $subscribed){}
/** @return bool */ function gupnp_service_thaw_notify(resource $service){}
/** @return bool */ function gzclose(resource $zp){}
/** @return int */ function gzeof(resource $zp){}
/** @return string */ function gzgetc(resource $zp){}
/** @return int */ function gzpassthru(resource $zp){}
/** @return string */ function gzread(resource $zp,int $length){}
/** @return bool */ function gzrewind(resource $zp){}
/** @return int */ function gztell(resource $zp){}
/** @return array */ function hash_algos(){}
/** @return resource */ function hash_copy(resource $context){}
/** @return bool */ function hash_equals(string $known_string,string $user_string){}
/** @return bool */ function hash_update(resource $context,string $data){}
/** @return bool */ function header_register_callback(callable $callback){}
/** @return array */ function headers_list(){}
/** @return string */ function hex2bin(string $data){}
/** @return number */ function hexdec(string $hex_string){}
/** @return string */ function http_build_cookie(array $cookie){}
/** @return string */ function http_chunked_decode(string $encoded){}
/** @return resource */ function http_get_request_body_stream(){}
/** @return string */ function http_get_request_body(){}
/** @return array */ function http_get_request_headers(){}
/** @return string */ function http_inflate(string $data){}
/** @return array */ function http_parse_headers(string $header){}
/** @return object */ function http_parse_message(string $message){}
/** @return object */ function http_persistent_handles_count(){}
/** @return string */ function http_request_body_encode(array $fields,array $files){}
/** @return int */ function http_request_method_exists(mixed $method){}
/** @return string */ function http_request_method_name(int $method){}
/** @return int */ function http_request_method_register(string $method){}
/** @return bool */ function http_request_method_unregister(mixed $method){}
/** @return bool */ function http_send_data(string $data){}
/** @return bool */ function http_send_file(string $file){}
/** @return bool */ function http_send_status(int $status){}
/** @return bool */ function http_send_stream(resource $stream){}
/** @return HW_API_Content */ function hwapi_content_new(string $content,string $mimetype){}
/** @return hw_api_object */ function hwapi_object_new(array $parameter){}
/** @return float */ function hypot(float $x,float $y){}
/** @return void */ function ibase_blob_add(resource $blob_handle,string $data){}
/** @return bool */ function ibase_blob_cancel(resource $blob_handle){}
/** @return mixed */ function ibase_blob_close(resource $blob_handle){}
/** @return bool */ function ibase_blob_echo(string $blob_id){}
/** @return string */ function ibase_blob_get(resource $blob_handle,int $len){}
/** @return string */ function ibase_blob_import(resource $link_identifier,resource $file_handle){}
/** @return array */ function ibase_blob_info(resource $link_identifier,string $blob_id){}
/** @return resource */ function ibase_blob_open(resource $link_identifier,string $blob_id){}
/** @return bool */ function ibase_delete_user(resource $service_handle,string $user_name){}
/** @return int */ function ibase_errcode(){}
/** @return string */ function ibase_errmsg(){}
/** @return array */ function ibase_field_info(resource $result,int $field_number){}
/** @return bool */ function ibase_free_event_handler(resource $event){}
/** @return bool */ function ibase_free_query(resource $query){}
/** @return bool */ function ibase_free_result(resource $result_identifier){}
/** @return bool */ function ibase_name_result(resource $result,string $name){}
/** @return int */ function ibase_num_fields(resource $result_id){}
/** @return int */ function ibase_num_params(resource $query){}
/** @return array */ function ibase_param_info(resource $query,int $param_number){}
/** @return resource */ function ibase_prepare(string $query){}
/** @return string */ function ibase_server_info(resource $service_handle,int $action){}
/** @return resource */ function ibase_service_attach(string $host,string $dba_username,string $dba_password){}
/** @return bool */ function ibase_service_detach(resource $service_handle){}
/** @return bool */ function iconv_set_encoding(string $type,string $charset){}
/** @return string */ function iconv(string $in_charset,string $out_charset,string $str){}
/** @return string */ function id3_get_frame_long_name(string $frameId){}
/** @return string */ function id3_get_frame_short_name(string $frameId){}
/** @return int */ function id3_get_genre_id(string $genre){}
/** @return array */ function id3_get_genre_list(){}
/** @return string */ function id3_get_genre_name(int $genre_id){}
/** @return int */ function id3_get_version(string $filename){}
/** @return string */ function idn_to_ascii(string $domain,int $options,int $variant,array &$idna_info){}
/** @return string */ function idn_to_utf8(string $domain,int $options,int $variant,array &$idna_info){}
/** @return int */ function ifx_affected_rows(resource $result_id){}
/** @return bool */ function ifx_blobinfile_mode(int $mode){}
/** @return bool */ function ifx_byteasvarchar(int $mode){}
/** @return int */ function ifx_copy_blob(int $bid){}
/** @return int */ function ifx_create_blob(int $type,int $mode,string $param){}
/** @return int */ function ifx_create_char(string $param){}
/** @return bool */ function ifx_do(resource $result_id){}
/** @return array */ function ifx_fieldproperties(resource $result_id){}
/** @return array */ function ifx_fieldtypes(resource $result_id){}
/** @return bool */ function ifx_free_blob(int $bid){}
/** @return bool */ function ifx_free_char(int $bid){}
/** @return bool */ function ifx_free_result(resource $result_id){}
/** @return string */ function ifx_get_blob(int $bid){}
/** @return string */ function ifx_get_char(int $bid){}
/** @return array */ function ifx_getsqlca(resource $result_id){}
/** @return bool */ function ifx_nullformat(int $mode){}
/** @return int */ function ifx_num_fields(resource $result_id){}
/** @return int */ function ifx_num_rows(resource $result_id){}
/** @return bool */ function ifx_textasvarchar(int $mode){}
/** @return bool */ function ifx_update_blob(int $bid,string $content){}
/** @return bool */ function ifx_update_char(int $bid,string $content){}
/** @return bool */ function ifxus_close_slob(int $bid){}
/** @return int */ function ifxus_create_slob(int $mode){}
/** @return bool */ function ifxus_free_slob(int $bid){}
/** @return int */ function ifxus_open_slob(int $bid,int $mode){}
/** @return string */ function ifxus_read_slob(int $bid,int $nbytes){}
/** @return int */ function ifxus_seek_slob(int $bid,int $mode,int $offset){}
/** @return int */ function ifxus_tell_slob(int $bid){}
/** @return int */ function ifxus_write_slob(int $bid,string $content){}
/** @return int */ function iis_add_server(string $path,string $comment,string $server_ip,int $port,string $host_name,int $rights,int $start_server){}
/** @return int */ function iis_get_dir_security(int $server_instance,string $virtual_path){}
/** @return string */ function iis_get_script_map(int $server_instance,string $virtual_path,string $script_extension){}
/** @return int */ function iis_get_server_by_comment(string $comment){}
/** @return int */ function iis_get_server_by_path(string $path){}
/** @return int */ function iis_get_server_rights(int $server_instance,string $virtual_path){}
/** @return int */ function iis_get_service_state(string $service_id){}
/** @return int */ function iis_remove_server(int $server_instance){}
/** @return int */ function iis_set_app_settings(int $server_instance,string $virtual_path,string $application_scope){}
/** @return int */ function iis_set_dir_security(int $server_instance,string $virtual_path,int $directory_flags){}
/** @return int */ function iis_set_script_map(int $server_instance,string $virtual_path,string $script_extension,string $engine_path,int $allow_scripting){}
/** @return int */ function iis_set_server_rights(int $server_instance,string $virtual_path,int $directory_flags){}
/** @return int */ function iis_start_server(int $server_instance){}
/** @return int */ function iis_start_service(string $service_id){}
/** @return int */ function iis_stop_server(int $server_instance){}
/** @return int */ function iis_stop_service(string $service_id){}
/** @return array */ function imageaffinematrixconcat(array $m1,array $m2){}
/** @return bool */ function imagealphablending(resource $image,bool $blendmode){}
/** @return bool */ function imageantialias(resource $image,bool $enabled){}
/** @return bool */ function imagearc(resource $image,int $cx,int $cy,int $w,int $h,int $s,int $e,int $color){}
/** @return bool */ function imagechar(resource $image,int $font,int $x,int $y,string $c,int $color){}
/** @return bool */ function imagecharup(resource $image,int $font,int $x,int $y,string $c,int $color){}
/** @return int */ function imagecolorallocatealpha(resource $image,int $red,int $green,int $blue,int $alpha){}
/** @return int */ function imagecolorallocate(resource $image,int $red,int $green,int $blue){}
/** @return int */ function imagecolorat(resource $image,int $x,int $y){}
/** @return int */ function imagecolorclosestalpha(resource $image,int $red,int $green,int $blue,int $alpha){}
/** @return int */ function imagecolorclosesthwb(resource $image,int $red,int $green,int $blue){}
/** @return int */ function imagecolorclosest(resource $image,int $red,int $green,int $blue){}
/** @return bool */ function imagecolordeallocate(resource $image,int $color){}
/** @return int */ function imagecolorexactalpha(resource $image,int $red,int $green,int $blue,int $alpha){}
/** @return int */ function imagecolorexact(resource $image,int $red,int $green,int $blue){}
/** @return bool */ function imagecolormatch(resource $image1,resource $image2){}
/** @return int */ function imagecolorresolvealpha(resource $image,int $red,int $green,int $blue,int $alpha){}
/** @return int */ function imagecolorresolve(resource $image,int $red,int $green,int $blue){}
/** @return array */ function imagecolorsforindex(resource $image,int $index){}
/** @return int */ function imagecolorstotal(resource $image){}
/** @return bool */ function imageconvolution(resource $image,array $matrix,float $div,float $offset){}
/** @return bool */ function imagecopy(resource $dst_im,resource $src_im,int $dst_x,int $dst_y,int $src_x,int $src_y,int $src_w,int $src_h){}
/** @return bool */ function imagecopymerge(resource $dst_im,resource $src_im,int $dst_x,int $dst_y,int $src_x,int $src_y,int $src_w,int $src_h,int $pct){}
/** @return bool */ function imagecopymergegray(resource $dst_im,resource $src_im,int $dst_x,int $dst_y,int $src_x,int $src_y,int $src_w,int $src_h,int $pct){}
/** @return bool */ function imagecopyresampled(resource $dst_image,resource $src_image,int $dst_x,int $dst_y,int $src_x,int $src_y,int $dst_w,int $dst_h,int $src_w,int $src_h){}
/** @return bool */ function imagecopyresized(resource $dst_image,resource $src_image,int $dst_x,int $dst_y,int $src_x,int $src_y,int $dst_w,int $dst_h,int $src_w,int $src_h){}
/** @return resource */ function imagecreatefromgd2part(string $filename,int $srcX,int $srcY,int $width,int $height){}
/** @return resource */ function imagecreatefromgd2(string $filename){}
/** @return resource */ function imagecreatefromgd(string $filename){}
/** @return resource */ function imagecreatefromgif(string $filename){}
/** @return resource */ function imagecreatefromjpeg(string $filename){}
/** @return resource */ function imagecreatefrompng(string $filename){}
/** @return resource */ function imagecreatefromstring(string $image){}
/** @return resource */ function imagecreatefromwbmp(string $filename){}
/** @return resource */ function imagecreatefromwebp(string $filename){}
/** @return resource */ function imagecreatefromxbm(string $filename){}
/** @return resource */ function imagecreatefromxpm(string $filename){}
/** @return resource */ function imagecreate(int $x_size,int $y_size){}
/** @return resource */ function imagecreatetruecolor(int $width,int $height){}
/** @return resource */ function imagecrop(resource $image,array $rect){}
/** @return bool */ function imagedashedline(resource $image,int $x1,int $y1,int $x2,int $y2,int $color){}
/** @return bool */ function imagedestroy(resource $image){}
/** @return bool */ function imageellipse(resource $image,int $cx,int $cy,int $width,int $height,int $color){}
/** @return bool */ function imagefill(resource $image,int $x,int $y,int $color){}
/** @return bool */ function imagefilledarc(resource $image,int $cx,int $cy,int $width,int $height,int $start,int $end,int $color,int $style){}
/** @return bool */ function imagefilledellipse(resource $image,int $cx,int $cy,int $width,int $height,int $color){}
/** @return bool */ function imagefilledpolygon(resource $image,array $points,int $num_points,int $color){}
/** @return bool */ function imagefilledrectangle(resource $image,int $x1,int $y1,int $x2,int $y2,int $color){}
/** @return bool */ function imagefilltoborder(resource $image,int $x,int $y,int $border,int $color){}
/** @return bool */ function imageflip(resource $image,int $mode){}
/** @return int */ function imagefontheight(int $font){}
/** @return int */ function imagefontwidth(int $font){}
/** @return bool */ function imagegammacorrect(resource $image,float $inputgamma,float $outputgamma){}
/** @return resource */ function imagegrabscreen(){}
/** @return bool */ function imageistruecolor(resource $image){}
/** @return bool */ function imagelayereffect(resource $image,int $effect){}
/** @return bool */ function imageline(resource $image,int $x1,int $y1,int $x2,int $y2,int $color){}
/** @return int */ function imageloadfont(string $file){}
/** @return void */ function imagepalettecopy(resource $destination,resource $source){}
/** @return bool */ function imagepalettetotruecolor(resource $src){}
/** @return bool */ function imagepolygon(resource $image,array $points,int $num_points,int $color){}
/** @return array */ function imagepsbbox(string $text,resource $font,int $size){}
/** @return bool */ function imagepsencodefont(resource $font_index,string $encodingfile){}
/** @return bool */ function imagepsextendfont(resource $font_index,float $extend){}
/** @return bool */ function imagepsfreefont(resource $font_index){}
/** @return resource */ function imagepsloadfont(string $filename){}
/** @return bool */ function imagepsslantfont(resource $font_index,float $slant){}
/** @return bool */ function imagerectangle(resource $image,int $x1,int $y1,int $x2,int $y2,int $col){}
/** @return bool */ function imagesavealpha(resource $image,bool $saveflag){}
/** @return bool */ function imagesetbrush(resource $image,resource $brush){}
/** @return bool */ function imagesetpixel(resource $image,int $x,int $y,int $color){}
/** @return bool */ function imagesetstyle(resource $image,array $style){}
/** @return bool */ function imagesetthickness(resource $image,int $thickness){}
/** @return bool */ function imagesettile(resource $image,resource $tile){}
/** @return bool */ function imagestring(resource $image,int $font,int $x,int $y,string $s,int $col){}
/** @return bool */ function imagestringup(resource $image,int $font,int $x,int $y,string $s,int $col){}
/** @return int */ function imagesx(resource $image){}
/** @return int */ function imagesy(resource $image){}
/** @return bool */ function imagetruecolortopalette(resource $image,bool $dither,int $ncolors){}
/** @return array */ function imagettfbbox(float $size,float $angle,string $fontfile,string $text){}
/** @return array */ function imagettftext(resource $image,float $size,float $angle,int $x,int $y,int $color,string $fontfile,string $text){}
/** @return int */ function imagetypes(){}
/** @return string */ function image_type_to_mime_type(int $imagetype){}
/** @return bool */ function imagewebp(resource $image,string $filename){}
/** @return string */ function imap_8bit(string $string){}
/** @return array */ function imap_alerts(){}
/** @return string */ function imap_base64(string $text){}
/** @return string */ function imap_binary(string $string){}
/** @return object */ function imap_bodystruct(resource $imap_stream,int $msg_number,string $section){}
/** @return object */ function imap_check(resource $imap_stream){}
/** @return bool */ function imap_createmailbox(resource $imap_stream,string $mailbox){}
/** @return bool */ function imap_deletemailbox(resource $imap_stream,string $mailbox){}
/** @return array */ function imap_errors(){}
/** @return bool */ function imap_expunge(resource $imap_stream){}
/** @return bool */ function imap_gc(resource $imap_stream,int $caches){}
/** @return array */ function imap_getacl(resource $imap_stream,string $mailbox){}
/** @return array */ function imap_getmailboxes(resource $imap_stream,string $ref,string $pattern){}
/** @return array */ function imap_get_quota(resource $imap_stream,string $quota_root){}
/** @return array */ function imap_get_quotaroot(resource $imap_stream,string $quota_root){}
/** @return array */ function imap_getsubscribed(resource $imap_stream,string $ref,string $pattern){}
/** @return array */ function imap_headers(resource $imap_stream){}
/** @return string */ function imap_last_error(){}
/** @return array */ function imap_list(resource $imap_stream,string $ref,string $pattern){}
/** @return array */ function imap_listscan(resource $imap_stream,string $ref,string $pattern,string $content){}
/** @return array */ function imap_lsub(resource $imap_stream,string $ref,string $pattern){}
/** @return object */ function imap_mailboxmsginfo(resource $imap_stream){}
/** @return string */ function imap_mail_compose(array $envelope,array $body){}
/** @return array */ function imap_mime_header_decode(string $text){}
/** @return int */ function imap_msgno(resource $imap_stream,int $uid){}
/** @return int */ function imap_num_msg(resource $imap_stream){}
/** @return int */ function imap_num_recent(resource $imap_stream){}
/** @return bool */ function imap_ping(resource $imap_stream){}
/** @return string */ function imap_qprint(string $string){}
/** @return bool */ function imap_renamemailbox(resource $imap_stream,string $old_mbox,string $new_mbox){}
/** @return array */ function imap_rfc822_parse_adrlist(string $address,string $default_host){}
/** @return string */ function imap_rfc822_write_address(string $mailbox,string $host,string $personal){}
/** @return bool */ function imap_setacl(resource $imap_stream,string $mailbox,string $id,string $rights){}
/** @return bool */ function imap_set_quota(resource $imap_stream,string $quota_root,int $quota_limit){}
/** @return object */ function imap_status(resource $imap_stream,string $mailbox,int $options){}
/** @return bool */ function imap_subscribe(resource $imap_stream,string $mailbox){}
/** @return int */ function imap_uid(resource $imap_stream,int $msg_number){}
/** @return bool */ function imap_unsubscribe(resource $imap_stream,string $mailbox){}
/** @return string */ function imap_utf7_decode(string $text){}
/** @return string */ function imap_utf7_encode(string $data){}
/** @return string */ function imap_utf8(string $mime_encoded_text){}
/** @return string */ function implode(string $glue,array $pieces){}
/** @return array */ function inclued_get_data(){}
/** @return string */ function inet_ntop(string $in_addr){}
/** @return string */ function inet_pton(string $address){}
/** @return bool */ function ingres_autocommit(resource $link){}
/** @return bool */ function ingres_autocommit_state(resource $link){}
/** @return string */ function ingres_charset(resource $link){}
/** @return bool */ function ingres_close(resource $link){}
/** @return bool */ function ingres_commit(resource $link){}
/** @return string */ function ingres_cursor(resource $result){}
/** @return string */ function ingres_escape_string(resource $link,string $source_string){}
/** @return array */ function ingres_fetch_assoc(resource $result){}
/** @return int */ function ingres_fetch_proc_return(resource $result){}
/** @return array */ function ingres_fetch_row(resource $result){}
/** @return int */ function ingres_field_length(resource $result,int $index){}
/** @return string */ function ingres_field_name(resource $result,int $index){}
/** @return bool */ function ingres_field_nullable(resource $result,int $index){}
/** @return int */ function ingres_field_precision(resource $result,int $index){}
/** @return int */ function ingres_field_scale(resource $result,int $index){}
/** @return string */ function ingres_field_type(resource $result,int $index){}
/** @return bool */ function ingres_free_result(resource $result){}
/** @return int */ function ingres_num_fields(resource $result){}
/** @return int */ function ingres_num_rows(resource $result){}
/** @return mixed */ function ingres_prepare(resource $link,string $query){}
/** @return bool */ function ingres_result_seek(resource $result,int $position){}
/** @return bool */ function ingres_rollback(resource $link){}
/** @return bool */ function ingres_set_environment(resource $link,array $options){}
/** @return string */ function ini_get(string $varname){}
/** @return void */ function ini_restore(string $varname){}
/** @return string */ function ini_set(string $varname,string $newvalue){}
/** @return int */ function inotify_add_watch(resource $inotify_instance,string $pathname,int $mask){}
/** @return resource */ function inotify_init(){}
/** @return int */ function inotify_queue_len(resource $inotify_instance){}
/** @return array */ function inotify_read(resource $inotify_instance){}
/** @return bool */ function inotify_rm_watch(resource $inotify_instance,int $watch_descriptor){}
/** @return string */ function intl_error_name(int $error_code){}
/** @return int */ function intl_get_error_code(){}
/** @return string */ function intl_get_error_message(){}
/** @return bool */ function intl_is_failure(int $error_code){}
/** @return int */ function ip2long(string $ip_address){}
/** @return array */ function iptcparse(string $iptcblock){}
/** @return bool */ function is_array(mixed $var){}
/** @return bool */ function is_bool(mixed $var){}
/** @return bool */ function is_dir(string $filename){}
/** @return bool */ function is_executable(string $filename){}
/** @return bool */ function is_file(string $filename){}
/** @return bool */ function is_finite(float $val){}
/** @return bool */ function is_float(mixed $var){}
/** @return bool */ function is_infinite(float $val){}
/** @return bool */ function is_int(mixed $var){}
/** @return bool */ function is_link(string $filename){}
/** @return bool */ function is_nan(float $val){}
/** @return bool */ function is_null(mixed $var){}
/** @return bool */ function is_numeric(mixed $var){}
/** @return bool */ function is_object(mixed $var){}
/** @return bool */ function is_readable(string $filename){}
/** @return bool */ function is_resource(mixed $var){}
/** @return bool */ function is_scalar(mixed $var){}
/** @return bool */ function is_soap_fault(mixed $object){}
/** @return bool */ function is_string(mixed $var){}
/** @return bool */ function is_tainted(string $string){}
/** @return bool */ function is_uploaded_file(string $filename){}
/** @return bool */ function is_writable(string $filename){}
/** @return int */ function iterator_count(Traversable $iterator){}
/** @return string */ function jdmonthname(int $julianday,int $mode){}
/** @return string */ function jdtofrench(int $juliandaycount){}
/** @return string */ function jdtogregorian(int $julianday){}
/** @return string */ function jdtojulian(int $julianday){}
/** @return int */ function jdtounix(int $jday){}
/** @return int */ function jewishtojd(int $month,int $day,int $year){}
/** @return string */ function join(string $glue,array $pieces){}
/** @return bool */ function jpeg2wbmp(string $jpegname,string $wbmpname,int $dest_height,int $dest_width,int $threshold){}
/** @return int */ function json_last_error(){}
/** @return string */ function json_last_error_msg(){}
/** @return int */ function judy_type(Judy $array){}
/** @return string */ function judy_version(){}
/** @return int */ function juliantojd(int $month,int $day,int $year){}
/** @return bool */ function kadm5_chpass_principal(resource $handle,string $principal,string $password){}
/** @return bool */ function kadm5_delete_principal(resource $handle,string $principal){}
/** @return bool */ function kadm5_destroy(resource $handle){}
/** @return bool */ function kadm5_flush(resource $handle){}
/** @return array */ function kadm5_get_policies(resource $handle){}
/** @return array */ function kadm5_get_principal(resource $handle,string $principal){}
/** @return array */ function kadm5_get_principals(resource $handle){}
/** @return resource */ function kadm5_init_with_password(string $admin_server,string $realm,string $principal,string $password){}
/** @return bool */ function kadm5_modify_principal(resource $handle,string $principal,array $options){}
/** @return mixed */ function key(array &$array){}
/** @return string */ function lcfirst(string $str){}
/** @return float */ function lcg_value(){}
/** @return bool */ function lchgrp(string $filename,mixed $group){}
/** @return bool */ function lchown(string $filename,mixed $user){}
/** @return string */ function ldap_8859_to_t61(string $value){}
/** @return bool */ function ldap_add(resource $link_identifier,string $dn,array $entry){}
/** @return mixed */ function ldap_compare(resource $link_identifier,string $dn,string $attribute,string $value){}
/** @return int */ function ldap_count_entries(resource $link_identifier,resource $result_identifier){}
/** @return bool */ function ldap_delete(resource $link_identifier,string $dn){}
/** @return string */ function ldap_dn2ufn(string $dn){}
/** @return string */ function ldap_err2str(int $errno){}
/** @return int */ function ldap_errno(resource $link_identifier){}
/** @return string */ function ldap_error(resource $link_identifier){}
/** @return array */ function ldap_explode_dn(string $dn,int $with_attrib){}
/** @return string */ function ldap_first_attribute(resource $link_identifier,resource $result_entry_identifier){}
/** @return resource */ function ldap_first_entry(resource $link_identifier,resource $result_identifier){}
/** @return resource */ function ldap_first_reference(resource $link,resource $result){}
/** @return bool */ function ldap_free_result(resource $result_identifier){}
/** @return array */ function ldap_get_attributes(resource $link_identifier,resource $result_entry_identifier){}
/** @return string */ function ldap_get_dn(resource $link_identifier,resource $result_entry_identifier){}
/** @return array */ function ldap_get_entries(resource $link_identifier,resource $result_identifier){}
/** @return bool */ function ldap_get_option(resource $link_identifier,int $option,mixed &$retval){}
/** @return array */ function ldap_get_values(resource $link_identifier,resource $result_entry_identifier,string $attribute){}
/** @return array */ function ldap_get_values_len(resource $link_identifier,resource $result_entry_identifier,string $attribute){}
/** @return bool */ function ldap_mod_add(resource $link_identifier,string $dn,array $entry){}
/** @return bool */ function ldap_mod_del(resource $link_identifier,string $dn,array $entry){}
/** @return bool */ function ldap_modify_batch(resource $link_identifier,string $dn,array $entry){}
/** @return bool */ function ldap_modify(resource $link_identifier,string $dn,array $entry){}
/** @return bool */ function ldap_mod_replace(resource $link_identifier,string $dn,array $entry){}
/** @return string */ function ldap_next_attribute(resource $link_identifier,resource $result_entry_identifier){}
/** @return resource */ function ldap_next_entry(resource $link_identifier,resource $result_entry_identifier){}
/** @return resource */ function ldap_next_reference(resource $link,resource $entry){}
/** @return bool */ function ldap_parse_reference(resource $link,resource $entry,array &$referrals){}
/** @return bool */ function ldap_rename(resource $link_identifier,string $dn,string $newrdn,string $newparent,bool $deleteoldrdn){}
/** @return bool */ function ldap_set_option(resource $link_identifier,int $option,mixed $newval){}
/** @return bool */ function ldap_set_rebind_proc(resource $link,callable $callback){}
/** @return bool */ function ldap_sort(resource $link,resource $result,string $sortfilter){}
/** @return bool */ function ldap_start_tls(resource $link){}
/** @return string */ function ldap_t61_to_8859(string $value){}
/** @return bool */ function ldap_unbind(resource $link_identifier){}
/** @return int */ function levenshtein(string $str1,string $str2){}
/** @return void */ function libxml_clear_errors(){}
/** @return array */ function libxml_get_errors(){}
/** @return LibXMLError */ function libxml_get_last_error(){}
/** @return void */ function libxml_set_external_entity_loader(callable $resolver_function){}
/** @return void */ function libxml_set_streams_context(resource $streams_context){}
/** @return bool */ function link(string $target,string $link){}
/** @return int */ function linkinfo(string $path){}
/** @return array */ function localeconv(){}
/** @return float */ function log10(float $arg){}
/** @return float */ function log1p(float $number){}
/** @return string */ function long2ip(string $proper_address){}
/** @return array */ function lstat(string $filename){}
/** @return string */ function lzf_compress(string $data){}
/** @return string */ function lzf_decompress(string $data){}
/** @return int */ function lzf_optimized_for(){}
/** @return string */ function mailparse_determine_best_xfer_encoding(resource $fp){}
/** @return resource */ function mailparse_msg_create(){}
/** @return bool */ function mailparse_msg_free(resource $mimemail){}
/** @return array */ function mailparse_msg_get_part_data(resource $mimemail){}
/** @return resource */ function mailparse_msg_get_part(resource $mimemail,string $mimesection){}
/** @return array */ function mailparse_msg_get_structure(resource $mimemail){}
/** @return bool */ function mailparse_msg_parse(resource $mimemail,string $data){}
/** @return resource */ function mailparse_msg_parse_file(string $filename){}
/** @return array */ function mailparse_rfc822_parse_addresses(string $addresses){}
/** @return bool */ function mailparse_stream_encode(resource $sourcefp,resource $destfp,string $encoding){}
/** @return array */ function mailparse_uudecode_all(resource $fp){}
/** @return int */ function maxdb_affected_rows(resource $link){}
/** @return bool */ function maxdb_autocommit(resource $link,bool $mode){}
/** @return bool */ function maxdb_change_user(resource $link,string $user,string $password,string $database){}
/** @return string */ function maxdb_character_set_name(resource $link){}
/** @return bool */ function maxdb_close(resource $link){}
/** @return bool */ function maxdb_commit(resource $link){}
/** @return int */ function maxdb_connect_errno(){}
/** @return string */ function maxdb_connect_error(){}
/** @return resource */ function maxdb_connect(string $host,string $username,string $passwd,string $dbname,int $port,string $socket){}
/** @return bool */ function maxdb_data_seek(resource $result,int $offset){}
/** @return void */ function maxdb_debug(string $debug){}
/** @return bool */ function maxdb_disable_reads_from_master(resource $link){}
/** @return bool */ function maxdb_disable_rpl_parse(resource $link){}
/** @return bool */ function maxdb_dump_debug_info(resource $link){}
/** @return bool */ function maxdb_enable_reads_from_master(resource $link){}
/** @return bool */ function maxdb_enable_rpl_parse(resource $link){}
/** @return int */ function maxdb_errno(resource $link){}
/** @return string */ function maxdb_error(resource $link){}
/** @return mixed */ function maxdb_fetch_array(resource $result,int $resulttype){}
/** @return array */ function maxdb_fetch_assoc(resource $result){}
/** @return mixed */ function maxdb_fetch_field_direct(resource $result,int $fieldnr){}
/** @return mixed */ function maxdb_fetch_field(resource $result){}
/** @return mixed */ function maxdb_fetch_fields(resource $result){}
/** @return array */ function maxdb_fetch_lengths(resource $result){}
/** @return object */ function maxdb_fetch_object(object $result){}
/** @return mixed */ function maxdb_fetch_row(resource $result){}
/** @return int */ function maxdb_field_count(resource $link){}
/** @return bool */ function maxdb_field_seek(resource $result,int $fieldnr){}
/** @return int */ function maxdb_field_tell(resource $result){}
/** @return void */ function maxdb_free_result(resource $result){}
/** @return string */ function maxdb_get_client_info(){}
/** @return int */ function maxdb_get_client_version(){}
/** @return string */ function maxdb_get_host_info(resource $link){}
/** @return int */ function maxdb_get_proto_info(resource $link){}
/** @return string */ function maxdb_get_server_info(resource $link){}
/** @return int */ function maxdb_get_server_version(resource $link){}
/** @return string */ function maxdb_info(resource $link){}
/** @return resource */ function maxdb_init(){}
/** @return mixed */ function maxdb_insert_id(resource $link){}
/** @return bool */ function maxdb_kill(resource $link,int $processid){}
/** @return bool */ function maxdb_master_query(resource $link,string $query){}
/** @return bool */ function maxdb_more_results(resource $link){}
/** @return bool */ function maxdb_multi_query(resource $link,string $query){}
/** @return bool */ function maxdb_next_result(resource $link){}
/** @return int */ function maxdb_num_fields(resource $result){}
/** @return int */ function maxdb_num_rows(resource $result){}
/** @return bool */ function maxdb_options(resource $link,int $option,mixed $value){}
/** @return bool */ function maxdb_ping(resource $link){}
/** @return resource */ function maxdb_prepare(resource $link,string $query){}
/** @return mixed */ function maxdb_query(resource $link,string $query,int $resultmode){}
/** @return bool */ function maxdb_real_connect(resource $link,string $hostname,string $username,string $passwd,string $dbname,int $port,string $socket){}
/** @return string */ function maxdb_real_escape_string(resource $link,string $escapestr){}
/** @return bool */ function maxdb_real_query(resource $link,string $query){}
/** @return bool */ function maxdb_report(int $flags){}
/** @return bool */ function maxdb_rollback(resource $link){}
/** @return int */ function maxdb_rpl_parse_enabled(resource $link){}
/** @return bool */ function maxdb_rpl_probe(resource $link){}
/** @return int */ function maxdb_rpl_query_type(resource $link){}
/** @return bool */ function maxdb_select_db(resource $link,string $dbname){}
/** @return bool */ function maxdb_send_query(resource $link,string $query){}
/** @return void */ function maxdb_server_end(){}
/** @return string */ function maxdb_sqlstate(resource $link){}
/** @return bool */ function maxdb_ssl_set(resource $link,string $key,string $cert,string $ca,string $capath,string $cipher){}
/** @return string */ function maxdb_stat(resource $link){}
/** @return int */ function maxdb_stmt_affected_rows(resource $stmt){}
/** @return bool */ function maxdb_stmt_bind_param(resource $stmt,string $types,mixed &$var1,mixed &$__args__){}
/** @return bool */ function maxdb_stmt_bind_result(resource $stmt,mixed &$var1,mixed &$__args__){}
/** @return bool */ function maxdb_stmt_close(resource $stmt){}
/** @return bool */ function maxdb_stmt_close_long_data(resource $stmt,int $param_nr){}
/** @return bool */ function maxdb_stmt_data_seek(resource $statement,int $offset){}
/** @return int */ function maxdb_stmt_errno(resource $stmt){}
/** @return string */ function maxdb_stmt_error(resource $stmt){}
/** @return bool */ function maxdb_stmt_execute(resource $stmt){}
/** @return bool */ function maxdb_stmt_fetch(resource $stmt){}
/** @return void */ function maxdb_stmt_free_result(resource $stmt){}
/** @return resource */ function maxdb_stmt_init(resource $link){}
/** @return int */ function maxdb_stmt_num_rows(resource $stmt){}
/** @return int */ function maxdb_stmt_param_count(resource $stmt){}
/** @return bool */ function maxdb_stmt_prepare(resource $stmt,string $query){}
/** @return bool */ function maxdb_stmt_reset(resource $stmt){}
/** @return resource */ function maxdb_stmt_result_metadata(resource $stmt){}
/** @return bool */ function maxdb_stmt_send_long_data(resource $stmt,int $param_nr,string $data){}
/** @return string */ function maxdb_stmt_sqlstate(resource $stmt){}
/** @return bool */ function maxdb_stmt_store_result(resource $stmt){}
/** @return resource */ function maxdb_store_result(resource $link){}
/** @return int */ function maxdb_thread_id(resource $link){}
/** @return bool */ function maxdb_thread_safe(){}
/** @return resource */ function maxdb_use_result(resource $link){}
/** @return int */ function maxdb_warning_count(resource $link){}
/** @return mixed */ function max(array $values){}
/** @return string */ function mb_decode_mimeheader(string $str){}
/** @return array */ function mb_encoding_aliases(string $encoding){}
/** @return int */ function mb_ereg_search_getpos(){}
/** @return array */ function mb_ereg_search_getregs(){}
/** @return bool */ function mb_ereg_search_setpos(int $position){}
/** @return array */ function mb_list_encodings(){}
/** @return string */ function mb_output_handler(string $contents,int $status){}
/** @return string */ function mb_preferred_mime_name(string $encoding){}
/** @return int */ function m_checkstatus(resource $conn,int $identifier){}
/** @return int */ function m_completeauthorizations(resource $conn,int &$array){}
/** @return int */ function m_connect(resource $conn){}
/** @return string */ function m_connectionerror(resource $conn){}
/** @return string */ function mcrypt_cfb(int $cipher,string $key,string $data,int $mode,string $iv){}
/** @return string */ function mcrypt_ecb(int $cipher,string $key,string $data,int $mode){}
/** @return string */ function mcrypt_enc_get_algorithms_name(resource $td){}
/** @return int */ function mcrypt_enc_get_block_size(resource $td){}
/** @return int */ function mcrypt_enc_get_iv_size(resource $td){}
/** @return int */ function mcrypt_enc_get_key_size(resource $td){}
/** @return string */ function mcrypt_enc_get_modes_name(resource $td){}
/** @return array */ function mcrypt_enc_get_supported_key_sizes(resource $td){}
/** @return bool */ function mcrypt_enc_is_block_algorithm(resource $td){}
/** @return bool */ function mcrypt_enc_is_block_algorithm_mode(resource $td){}
/** @return bool */ function mcrypt_enc_is_block_mode(resource $td){}
/** @return int */ function mcrypt_enc_self_test(resource $td){}
/** @return bool */ function mcrypt_generic_deinit(resource $td){}
/** @return bool */ function mcrypt_generic_end(resource $td){}
/** @return int */ function mcrypt_generic_init(resource $td,string $key,string $iv){}
/** @return string */ function mcrypt_generic(resource $td,string $data){}
/** @return int */ function mcrypt_get_block_size(int $cipher){}
/** @return string */ function mcrypt_get_cipher_name(int $cipher){}
/** @return int */ function mcrypt_get_iv_size(string $cipher,string $mode){}
/** @return int */ function mcrypt_get_key_size(int $cipher){}
/** @return bool */ function mcrypt_module_close(resource $td){}
/** @return resource */ function mcrypt_module_open(string $algorithm,string $algorithm_directory,string $mode,string $mode_directory){}
/** @return string */ function mcrypt_ofb(int $cipher,string $key,string $data,int $mode,string $iv){}
/** @return string */ function mdecrypt_generic(resource $td,string $data){}
/** @return bool */ function m_deletetrans(resource $conn,int $identifier){}
/** @return bool */ function m_destroyconn(resource $conn){}
/** @return void */ function m_destroyengine(){}
/** @return bool */ function memcache_debug(bool $on_off){}
/** @return bool */ function method_exists(mixed $object,string $method_name){}
/** @return string */ function m_getcellbynum(resource $conn,int $identifier,int $column,int $row){}
/** @return string */ function m_getcell(resource $conn,int $identifier,string $column,int $row){}
/** @return string */ function m_getcommadelimited(resource $conn,int $identifier){}
/** @return string */ function m_getheader(resource $conn,int $identifier,int $column_num){}
/** @return int */ function mhash_count(){}
/** @return int */ function mhash_get_block_size(int $hash){}
/** @return string */ function mhash_get_hash_name(int $hash){}
/** @return string */ function mhash_keygen_s2k(int $hash,string $password,string $salt,int $bytes){}
/** @return string */ function mime_content_type(string $filename){}
/** @return int */ function ming_keypress(string $char){}
/** @return void */ function ming_setcubicthreshold(int $threshold){}
/** @return void */ function ming_setscale(float $scale){}
/** @return void */ function ming_setswfcompression(int $level){}
/** @return void */ function ming_useconstants(int $use){}
/** @return void */ function ming_useswfversion(int $version){}
/** @return resource */ function m_initconn(){}
/** @return int */ function m_initengine(string $location){}
/** @return mixed */ function min(array $values){}
/** @return int */ function m_iscommadelimited(resource $conn,int $identifier){}
/** @return bool */ function m_maxconntimeout(resource $conn,int $secs){}
/** @return int */ function m_monitor(resource $conn){}
/** @return int */ function m_numcolumns(resource $conn,int $identifier){}
/** @return int */ function m_numrows(resource $conn,int $identifier){}
/** @return string */ function money_format(string $format,float $number){}
/** @return bool */ function move_uploaded_file(string $filename,string $destination){}
/** @return int */ function m_parsecommadelimited(resource $conn,int $identifier){}
/** @return void */ function mqseries_back(resource $hconn,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_begin(resource $hconn,array $beginOptions,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_close(resource $hconn,resource $hobj,int $options,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_cmit(resource $hconn,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_conn(string $qManagerName,resource &$hconn,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_connx(string $qManagerName,array &$connOptions,resource &$hconn,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_disc(resource $hconn,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_get(resource $hConn,resource $hObj,array &$md,array &$gmo,int &$bufferLength,string &$msg,int &$data_length,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_inq(resource $hconn,resource $hobj,int $selectorCount,array $selectors,int $intAttrCount,resource &$intAttr,int $charAttrLength,resource &$charAttr,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_open(resource $hconn,array &$objDesc,int $option,resource &$hobj,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_put1(resource $hconn,resource &$objDesc,resource &$msgDesc,resource &$pmo,string $buffer,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_put(resource $hConn,resource $hObj,array &$md,array &$pmo,string $message,resource &$compCode,resource &$reason){}
/** @return void */ function mqseries_set(resource $hconn,resource $hobj,int $selectorcount,array $selectors,int $intattrcount,array $intattrs,int $charattrlength,array $charattrs,resource &$compCode,resource &$reason){}
/** @return string */ function mqseries_strerror(int $reason){}
/** @return array */ function m_responsekeys(resource $conn,int $identifier){}
/** @return string */ function m_responseparam(resource $conn,int $identifier,string $key){}
/** @return int */ function m_returnstatus(resource $conn,int $identifier){}
/** @return bool */ function msession_connect(string $host,string $port){}
/** @return int */ function msession_count(){}
/** @return bool */ function msession_destroy(string $name){}
/** @return void */ function msession_disconnect(){}
/** @return array */ function msession_find(string $name,string $value){}
/** @return array */ function msession_get_array(string $session){}
/** @return string */ function msession_get_data(string $session){}
/** @return string */ function msession_get(string $session,string $name,string $value){}
/** @return string */ function msession_inc(string $session,string $name){}
/** @return array */ function msession_list(){}
/** @return array */ function msession_listvar(string $name){}
/** @return int */ function msession_lock(string $name){}
/** @return string */ function msession_randstr(int $param){}
/** @return void */ function msession_set_array(string $session,array $tuples){}
/** @return bool */ function msession_set(string $session,string $name,string $value){}
/** @return bool */ function msession_set_data(string $session,string $value){}
/** @return int */ function msession_unlock(string $session,int $key){}
/** @return int */ function m_setblocking(resource $conn,int $tf){}
/** @return int */ function m_setdropfile(resource $conn,string $directory){}
/** @return int */ function m_setip(resource $conn,string $host,int $port){}
/** @return int */ function m_setssl_cafile(resource $conn,string $cafile){}
/** @return int */ function m_setssl_files(resource $conn,string $sslkeyfile,string $sslcertfile){}
/** @return int */ function m_setssl(resource $conn,string $host,int $port){}
/** @return int */ function m_settimeout(resource $conn,int $seconds){}
/** @return bool */ function msg_queue_exists(int $key){}
/** @return bool */ function msg_remove_queue(resource $queue){}
/** @return bool */ function msg_set_queue(resource $queue,array $data){}
/** @return array */ function msg_stat_queue(resource $queue){}
/** @return int */ function msql_affected_rows(resource $result){}
/** @return bool */ function msql_data_seek(resource $result,int $row_number){}
/** @return string */ function msql_error(){}
/** @return object */ function msql_fetch_object(resource $result){}
/** @return array */ function msql_fetch_row(resource $result){}
/** @return string */ function msql_field_flags(resource $result,int $field_offset){}
/** @return int */ function msql_field_len(resource $result,int $field_offset){}
/** @return string */ function msql_field_name(resource $result,int $field_offset){}
/** @return bool */ function msql_field_seek(resource $result,int $field_offset){}
/** @return int */ function msql_field_table(resource $result,int $field_offset){}
/** @return string */ function msql_field_type(resource $result,int $field_offset){}
/** @return bool */ function msql_free_result(resource $result){}
/** @return int */ function msql_num_fields(resource $result){}
/** @return int */ function msql_num_rows(resource $query_identifier){}
/** @return string */ function m_sslcert_gen_hash(string $filename){}
/** @return bool */ function mssql_data_seek(resource $result_identifier,int $row_number){}
/** @return array */ function mssql_fetch_assoc(resource $result_id){}
/** @return int */ function mssql_fetch_batch(resource $result){}
/** @return object */ function mssql_fetch_object(resource $result){}
/** @return array */ function mssql_fetch_row(resource $result){}
/** @return bool */ function mssql_field_seek(resource $result,int $field_offset){}
/** @return bool */ function mssql_free_result(resource $result){}
/** @return bool */ function mssql_free_statement(resource $stmt){}
/** @return string */ function mssql_get_last_message(){}
/** @return void */ function mssql_min_error_severity(int $severity){}
/** @return void */ function mssql_min_message_severity(int $severity){}
/** @return bool */ function mssql_next_result(resource $result_id){}
/** @return int */ function mssql_num_fields(resource $result){}
/** @return int */ function mssql_num_rows(resource $result){}
/** @return string */ function mssql_result(resource $result,int $row,mixed $field){}
/** @return int */ function mssql_rows_affected(resource $link_identifier){}
/** @return int */ function mt_getrandmax(){}
/** @return int */ function mt_rand(){}
/** @return int */ function m_transactionssent(resource $conn){}
/** @return int */ function m_transinqueue(resource $conn){}
/** @return int */ function m_transkeyval(resource $conn,int $identifier,string $key,string $value){}
/** @return int */ function m_transnew(resource $conn){}
/** @return int */ function m_transsend(resource $conn,int $identifier){}
/** @return int */ function m_uwait(int $microsecs){}
/** @return int */ function m_validateidentifier(resource $conn,int $tf){}
/** @return bool */ function m_verifyconnection(resource $conn,int $tf){}
/** @return bool */ function m_verifysslcert(resource $conn,int $tf){}
/** @return bool */ function mysql_data_seek(resource $result,int $row_number){}
/** @return string */ function mysql_escape_string(string $unescaped_string){}
/** @return array */ function mysql_fetch_assoc(resource $result){}
/** @return array */ function mysql_fetch_lengths(resource $result){}
/** @return array */ function mysql_fetch_row(resource $result){}
/** @return string */ function mysql_field_flags(resource $result,int $field_offset){}
/** @return int */ function mysql_field_len(resource $result,int $field_offset){}
/** @return string */ function mysql_field_name(resource $result,int $field_index){}
/** @return int */ function mysql_field_seek(resource $result,int $field_offset){}
/** @return string */ function mysql_field_table(resource $result,int $field_offset){}
/** @return string */ function mysql_field_type(resource $result,int $field_offset){}
/** @return bool */ function mysql_free_result(resource $result){}
/** @return string */ function mysql_get_client_info(){}
/** @return bool */ function mysqli_disable_rpl_parse(mysqli $link){}
/** @return bool */ function mysqli_enable_reads_from_master(mysqli $link){}
/** @return bool */ function mysqli_enable_rpl_parse(mysqli $link){}
/** @return array */ function mysqli_get_links_stats(){}
/** @return bool */ function mysqli_master_query(mysqli $link,string $query){}
/** @return bool */ function mysqli_report(int $flags){}
/** @return int */ function mysqli_rpl_parse_enabled(mysqli $link){}
/** @return bool */ function mysqli_rpl_probe(mysqli $link){}
/** @return bool */ function mysqli_slave_query(mysqli $link,string $query){}
/** @return array */ function mysqlnd_memcache_get_config(mixed $connection){}
/** @return array */ function mysqlnd_ms_dump_servers(mixed $connection){}
/** @return array */ function mysqlnd_ms_fabric_select_global(mixed $connection,mixed $table_name){}
/** @return array */ function mysqlnd_ms_fabric_select_shard(mixed $connection,mixed $table_name,mixed $shard_key){}
/** @return string */ function mysqlnd_ms_get_last_gtid(mixed $connection){}
/** @return array */ function mysqlnd_ms_get_last_used_connection(mixed $connection){}
/** @return array */ function mysqlnd_ms_get_stats(){}
/** @return bool */ function mysqlnd_ms_match_wild(string $table_name,string $wildcard){}
/** @return int */ function mysqlnd_ms_query_is_select(string $query){}
/** @return bool */ function mysqlnd_ms_set_user_pick_server(string $function){}
/** @return int */ function mysqlnd_ms_xa_commit(mixed $connection,string $gtrid){}
/** @return int */ function mysqlnd_ms_xa_rollback(mixed $connection,string $gtrid){}
/** @return bool */ function mysqlnd_qc_clear_cache(){}
/** @return array */ function mysqlnd_qc_get_available_handlers(){}
/** @return array */ function mysqlnd_qc_get_cache_info(){}
/** @return array */ function mysqlnd_qc_get_core_stats(){}
/** @return array */ function mysqlnd_qc_get_normalized_query_trace_log(){}
/** @return array */ function mysqlnd_qc_get_query_trace_log(){}
/** @return bool */ function mysqlnd_qc_set_cache_condition(int $condition_type,mixed $condition,mixed $condition_option){}
/** @return mixed */ function mysqlnd_qc_set_is_select(string $callback){}
/** @return bool */ function mysqlnd_qc_set_storage_handler(string $handler){}
/** @return bool */ function mysqlnd_qc_set_user_handlers(string $get_hash,string $find_query_in_cache,string $return_to_cache,string $add_query_to_cache_if_not_exists,string $query_is_select,string $update_query_run_time_stats,string $get_stats,string $clear_cache){}
/** @return resource */ function mysqlnd_uh_convert_to_mysqlnd(mysqli &$mysql_connection){}
/** @return bool */ function mysqlnd_uh_set_statement_proxy(MysqlndUhStatement &$statement_proxy){}
/** @return int */ function mysql_num_fields(resource $result){}
/** @return int */ function mysql_num_rows(resource $result){}
/** @return string */ function mysql_tablename(resource $result,int $i){}
/** @return bool */ function natcasesort(array &$array){}
/** @return bool */ function natsort(array &$array){}
/** @return int */ function ncurses_addch(int $ch){}
/** @return int */ function ncurses_addchnstr(string $s,int $n){}
/** @return int */ function ncurses_addchstr(string $s){}
/** @return int */ function ncurses_addnstr(string $s,int $n){}
/** @return int */ function ncurses_addstr(string $text){}
/** @return int */ function ncurses_assume_default_colors(int $fg,int $bg){}
/** @return int */ function ncurses_attroff(int $attributes){}
/** @return int */ function ncurses_attron(int $attributes){}
/** @return int */ function ncurses_attrset(int $attributes){}
/** @return int */ function ncurses_baudrate(){}
/** @return int */ function ncurses_beep(){}
/** @return int */ function ncurses_bkgd(int $attrchar){}
/** @return void */ function ncurses_bkgdset(int $attrchar){}
/** @return int */ function ncurses_border(int $left,int $right,int $top,int $bottom,int $tl_corner,int $tr_corner,int $bl_corner,int $br_corner){}
/** @return int */ function ncurses_bottom_panel(resource $panel){}
/** @return bool */ function ncurses_can_change_color(){}
/** @return bool */ function ncurses_cbreak(){}
/** @return bool */ function ncurses_clear(){}
/** @return bool */ function ncurses_clrtobot(){}
/** @return bool */ function ncurses_clrtoeol(){}
/** @return int */ function ncurses_color_content(int $color,int &$r,int &$g,int &$b){}
/** @return int */ function ncurses_color_set(int $pair){}
/** @return int */ function ncurses_curs_set(int $visibility){}
/** @return int */ function ncurses_define_key(string $definition,int $keycode){}
/** @return bool */ function ncurses_def_prog_mode(){}
/** @return bool */ function ncurses_def_shell_mode(){}
/** @return int */ function ncurses_delay_output(int $milliseconds){}
/** @return bool */ function ncurses_delch(){}
/** @return bool */ function ncurses_deleteln(){}
/** @return bool */ function ncurses_del_panel(resource $panel){}
/** @return bool */ function ncurses_delwin(resource $window){}
/** @return bool */ function ncurses_doupdate(){}
/** @return bool */ function ncurses_echo(){}
/** @return int */ function ncurses_echochar(int $character){}
/** @return int */ function ncurses_end(){}
/** @return bool */ function ncurses_erase(){}
/** @return string */ function ncurses_erasechar(){}
/** @return void */ function ncurses_filter(){}
/** @return bool */ function ncurses_flash(){}
/** @return bool */ function ncurses_flushinp(){}
/** @return int */ function ncurses_getch(){}
/** @return void */ function ncurses_getmaxyx(resource $window,int &$y,int &$x){}
/** @return bool */ function ncurses_getmouse(array &$mevent){}
/** @return void */ function ncurses_getyx(resource $window,int &$y,int &$x){}
/** @return int */ function ncurses_halfdelay(int $tenth){}
/** @return bool */ function ncurses_has_colors(){}
/** @return bool */ function ncurses_has_ic(){}
/** @return bool */ function ncurses_has_il(){}
/** @return int */ function ncurses_has_key(int $keycode){}
/** @return int */ function ncurses_hide_panel(resource $panel){}
/** @return int */ function ncurses_hline(int $charattr,int $n){}
/** @return string */ function ncurses_inch(){}
/** @return int */ function ncurses_init_color(int $color,int $r,int $g,int $b){}
/** @return int */ function ncurses_init_pair(int $pair,int $fg,int $bg){}
/** @return void */ function ncurses_init(){}
/** @return int */ function ncurses_insch(int $character){}
/** @return int */ function ncurses_insdelln(int $count){}
/** @return int */ function ncurses_insertln(){}
/** @return int */ function ncurses_insstr(string $text){}
/** @return int */ function ncurses_instr(string &$buffer){}
/** @return bool */ function ncurses_isendwin(){}
/** @return int */ function ncurses_keyok(int $keycode,bool $enable){}
/** @return int */ function ncurses_keypad(resource $window,bool $bf){}
/** @return string */ function ncurses_killchar(){}
/** @return string */ function ncurses_longname(){}
/** @return int */ function ncurses_meta(resource $window,bool $bit8 ){}
/** @return int */ function ncurses_mouseinterval(int $milliseconds){}
/** @return int */ function ncurses_mousemask(int $newmask,int &$oldmask){}
/** @return bool */ function ncurses_mouse_trafo(int &$y,int &$x,bool $toscreen){}
/** @return int */ function ncurses_move(int $y,int $x){}
/** @return int */ function ncurses_move_panel(resource $panel,int $startx,int $starty){}
/** @return int */ function ncurses_mvaddch(int $y,int $x,int $c){}
/** @return int */ function ncurses_mvaddchnstr(int $y,int $x,string $s,int $n){}
/** @return int */ function ncurses_mvaddchstr(int $y,int $x,string $s){}
/** @return int */ function ncurses_mvaddnstr(int $y,int $x,string $s,int $n){}
/** @return int */ function ncurses_mvaddstr(int $y,int $x,string $s){}
/** @return int */ function ncurses_mvcur(int $old_y,int $old_x,int $new_y,int $new_x){}
/** @return int */ function ncurses_mvdelch(int $y,int $x){}
/** @return int */ function ncurses_mvgetch(int $y,int $x){}
/** @return int */ function ncurses_mvhline(int $y,int $x,int $attrchar,int $n){}
/** @return int */ function ncurses_mvinch(int $y,int $x){}
/** @return int */ function ncurses_mvvline(int $y,int $x,int $attrchar,int $n){}
/** @return int */ function ncurses_mvwaddstr(resource $window,int $y,int $x,string $text){}
/** @return int */ function ncurses_napms(int $milliseconds){}
/** @return resource */ function ncurses_newpad(int $rows,int $cols){}
/** @return resource */ function ncurses_new_panel(resource $window){}
/** @return resource */ function ncurses_newwin(int $rows,int $cols,int $y,int $x){}
/** @return bool */ function ncurses_nl(){}
/** @return bool */ function ncurses_nocbreak(){}
/** @return bool */ function ncurses_noecho(){}
/** @return bool */ function ncurses_nonl(){}
/** @return void */ function ncurses_noqiflush(){}
/** @return bool */ function ncurses_noraw(){}
/** @return int */ function ncurses_pair_content(int $pair,int &$f,int &$b){}
/** @return resource */ function ncurses_panel_above(resource $panel){}
/** @return resource */ function ncurses_panel_below(resource $panel){}
/** @return resource */ function ncurses_panel_window(resource $panel){}
/** @return int */ function ncurses_pnoutrefresh(resource $pad,int $pminrow,int $pmincol,int $sminrow,int $smincol,int $smaxrow,int $smaxcol){}
/** @return int */ function ncurses_prefresh(resource $pad,int $pminrow,int $pmincol,int $sminrow,int $smincol,int $smaxrow,int $smaxcol){}
/** @return int */ function ncurses_putp(string $text){}
/** @return void */ function ncurses_qiflush(){}
/** @return bool */ function ncurses_raw(){}
/** @return int */ function ncurses_refresh(int $ch){}
/** @return int */ function ncurses_replace_panel(resource $panel,resource $window){}
/** @return int */ function ncurses_reset_prog_mode(){}
/** @return int */ function ncurses_reset_shell_mode(){}
/** @return bool */ function ncurses_resetty(){}
/** @return bool */ function ncurses_savetty(){}
/** @return int */ function ncurses_scr_dump(string $filename){}
/** @return int */ function ncurses_scr_init(string $filename){}
/** @return int */ function ncurses_scrl(int $count){}
/** @return int */ function ncurses_scr_restore(string $filename){}
/** @return int */ function ncurses_scr_set(string $filename){}
/** @return int */ function ncurses_show_panel(resource $panel){}
/** @return int */ function ncurses_slk_attr(){}
/** @return int */ function ncurses_slk_attroff(int $intarg){}
/** @return int */ function ncurses_slk_attron(int $intarg){}
/** @return int */ function ncurses_slk_attrset(int $intarg){}
/** @return bool */ function ncurses_slk_clear(){}
/** @return int */ function ncurses_slk_color(int $intarg){}
/** @return bool */ function ncurses_slk_init(int $format){}
/** @return bool */ function ncurses_slk_noutrefresh(){}
/** @return int */ function ncurses_slk_refresh(){}
/** @return int */ function ncurses_slk_restore(){}
/** @return bool */ function ncurses_slk_set(int $labelnr,string $label,int $format){}
/** @return int */ function ncurses_slk_touch(){}
/** @return int */ function ncurses_standend(){}
/** @return int */ function ncurses_standout(){}
/** @return int */ function ncurses_start_color(){}
/** @return bool */ function ncurses_termattrs(){}
/** @return string */ function ncurses_termname(){}
/** @return void */ function ncurses_timeout(int $millisec){}
/** @return int */ function ncurses_top_panel(resource $panel){}
/** @return int */ function ncurses_typeahead(int $fd){}
/** @return int */ function ncurses_ungetch(int $keycode){}
/** @return bool */ function ncurses_ungetmouse(array $mevent){}
/** @return void */ function ncurses_update_panels(){}
/** @return bool */ function ncurses_use_default_colors(){}
/** @return void */ function ncurses_use_env(bool $flag){}
/** @return int */ function ncurses_use_extended_names(bool $flag){}
/** @return int */ function ncurses_vidattr(int $intarg){}
/** @return int */ function ncurses_vline(int $charattr,int $n){}
/** @return int */ function ncurses_waddch(resource $window,int $ch){}
/** @return int */ function ncurses_wattroff(resource $window,int $attrs){}
/** @return int */ function ncurses_wattron(resource $window,int $attrs){}
/** @return int */ function ncurses_wattrset(resource $window,int $attrs){}
/** @return int */ function ncurses_wborder(resource $window,int $left,int $right,int $top,int $bottom,int $tl_corner,int $tr_corner,int $bl_corner,int $br_corner){}
/** @return int */ function ncurses_wclear(resource $window){}
/** @return int */ function ncurses_wcolor_set(resource $window,int $color_pair){}
/** @return int */ function ncurses_werase(resource $window){}
/** @return int */ function ncurses_wgetch(resource $window){}
/** @return int */ function ncurses_whline(resource $window,int $charattr,int $n){}
/** @return bool */ function ncurses_wmouse_trafo(resource $window,int &$y,int &$x,bool $toscreen){}
/** @return int */ function ncurses_wmove(resource $window,int $y,int $x){}
/** @return int */ function ncurses_wnoutrefresh(resource $window){}
/** @return int */ function ncurses_wrefresh(resource $window){}
/** @return int */ function ncurses_wstandend(resource $window){}
/** @return int */ function ncurses_wstandout(resource $window){}
/** @return int */ function ncurses_wvline(resource $window,int $charattr,int $n){}
/** @return void */ function newt_bell(){}
/** @return resource */ function newt_button_bar(array &$buttons){}
/** @return resource */ function newt_button(int $left,int $top,string $text){}
/** @return string */ function newt_checkbox_get_value(resource $checkbox){}
/** @return void */ function newt_checkbox_set_flags(resource $checkbox,int $flags,int $sense){}
/** @return void */ function newt_checkbox_set_value(resource $checkbox,string $value){}
/** @return array */ function newt_checkbox_tree_find_item(resource $checkboxtree,mixed $data){}
/** @return mixed */ function newt_checkbox_tree_get_current(resource $checkboxtree){}
/** @return string */ function newt_checkbox_tree_get_entry_value(resource $checkboxtree,mixed $data){}
/** @return array */ function newt_checkbox_tree_get_multi_selection(resource $checkboxtree,string $seqnum){}
/** @return array */ function newt_checkbox_tree_get_selection(resource $checkboxtree){}
/** @return void */ function newt_checkbox_tree_set_current(resource $checkboxtree,mixed $data){}
/** @return void */ function newt_checkbox_tree_set_entry_value(resource $checkboxtree,mixed $data,string $value){}
/** @return void */ function newt_checkbox_tree_set_entry(resource $checkboxtree,mixed $data,string $text){}
/** @return void */ function newt_checkbox_tree_set_width(resource $checkbox_tree,int $width){}
/** @return void */ function newt_clear_key_buffer(){}
/** @return void */ function newt_cls(){}
/** @return resource */ function newt_compact_button(int $left,int $top,string $text){}
/** @return void */ function newt_component_add_callback(resource $component,mixed $func_name,mixed $data){}
/** @return void */ function newt_component_takes_focus(resource $component,bool $takes_focus){}
/** @return resource */ function newt_create_grid(int $cols,int $rows){}
/** @return void */ function newt_cursor_off(){}
/** @return void */ function newt_cursor_on(){}
/** @return void */ function newt_delay(int $microseconds){}
/** @return void */ function newt_draw_form(resource $form){}
/** @return void */ function newt_draw_root_text(int $left,int $top,string $text){}
/** @return string */ function newt_entry_get_value(resource $entry){}
/** @return void */ function newt_entry_set_filter(resource $entry,callable $filter,mixed $data){}
/** @return void */ function newt_entry_set_flags(resource $entry,int $flags,int $sense){}
/** @return int */ function newt_finished(){}
/** @return void */ function newt_form_add_components(resource $form,array $components){}
/** @return void */ function newt_form_add_component(resource $form,resource $component){}
/** @return void */ function newt_form_add_hot_key(resource $form,int $key){}
/** @return void */ function newt_form_destroy(resource $form){}
/** @return resource */ function newt_form_get_current(resource $form){}
/** @return void */ function newt_form_run(resource $form,array &$exit_struct){}
/** @return void */ function newt_form_set_background(resource $from,int $background){}
/** @return void */ function newt_form_set_height(resource $form,int $height){}
/** @return void */ function newt_form_set_size(resource $form){}
/** @return void */ function newt_form_set_timer(resource $form,int $milliseconds){}
/** @return void */ function newt_form_set_width(resource $form,int $width){}
/** @return void */ function newt_get_screen_size(int &$cols,int &$rows){}
/** @return void */ function newt_grid_add_components_to_form(resource $grid,resource $form,bool $recurse){}
/** @return resource */ function newt_grid_basic_window(resource $text,resource $middle,resource $buttons){}
/** @return void */ function newt_grid_free(resource $grid,bool $recurse){}
/** @return void */ function newt_grid_get_size(resouce $grid,int &$width,int &$height){}
/** @return void */ function newt_grid_place(resource $grid,int $left,int $top){}
/** @return resource */ function newt_grid_simple_window(resource $text,resource $middle,resource $buttons){}
/** @return void */ function newt_grid_wrapped_window_at(resource $grid,string $title,int $left,int $top){}
/** @return void */ function newt_grid_wrapped_window(resource $grid,string $title){}
/** @return int */ function newt_init(){}
/** @return resource */ function newt_label(int $left,int $top,string $text){}
/** @return void */ function newt_label_set_text(resource $label,string $text){}
/** @return void */ function newt_listbox_append_entry(resource $listbox,string $text,mixed $data){}
/** @return void */ function newt_listbox_clear_selection(resource $listbox){}
/** @return void */ function newt_listbox_clear(resource $listobx){}
/** @return void */ function newt_listbox_delete_entry(resource $listbox,mixed $key){}
/** @return string */ function newt_listbox_get_current(resource $listbox){}
/** @return array */ function newt_listbox_get_selection(resource $listbox){}
/** @return void */ function newt_listbox_insert_entry(resource $listbox,string $text,mixed $data,mixed $key){}
/** @return int */ function newt_listbox_item_count(resource $listbox){}
/** @return void */ function newt_listbox_select_item(resource $listbox,mixed $key,int $sense){}
/** @return void */ function newt_listbox_set_current_by_key(resource $listbox,mixed $key){}
/** @return void */ function newt_listbox_set_current(resource $listbox,int $num){}
/** @return void */ function newt_listbox_set_data(resource $listbox,int $num,mixed $data){}
/** @return void */ function newt_listbox_set_entry(resource $listbox,int $num,string $text){}
/** @return void */ function newt_listbox_set_width(resource $listbox,int $width){}
/** @return mixed */ function newt_listitem_get_data(resource $item){}
/** @return void */ function newt_listitem_set(resource $item,string $text){}
/** @return void */ function newt_pop_help_line(){}
/** @return void */ function newt_pop_window(){}
/** @return resource */ function newt_radio_get_current(resource $set_member){}
/** @return void */ function newt_redraw_help_line(){}
/** @return string */ function newt_reflow_text(string $text,int $width,int $flex_down,int $flex_up,int &$actual_width,int &$actual_height){}
/** @return void */ function newt_refresh(){}
/** @return void */ function newt_resume(){}
/** @return resource */ function newt_run_form(resource $form){}
/** @return resource */ function newt_scale(int $left,int $top,int $width,int $full_value){}
/** @return void */ function newt_scale_set(resource $scale,int $amount){}
/** @return void */ function newt_scrollbar_set(resource $scrollbar,int $where,int $total){}
/** @return void */ function newt_set_help_callback(mixed $function){}
/** @return void */ function newt_set_suspend_callback(callable $function,mixed $data){}
/** @return void */ function newt_suspend(){}
/** @return int */ function newt_textbox_get_num_lines(resource $textbox){}
/** @return void */ function newt_textbox_set_height(resource $textbox,int $height){}
/** @return void */ function newt_textbox_set_text(resource $textbox,string $text){}
/** @return void */ function newt_wait_for_key(){}
/** @return void */ function newt_win_messagev(string $title,string $button_text,string $format,array $args){}
/** @return mixed */ function next(array &$array){}
/** @return string */ function ngettext(string $msgid1,string $msgid2,int $n){}
/** @return string */ function nl_langinfo(int $item){}
/** @return array */ function nsapi_request_headers(){}
/** @return array */ function nsapi_response_headers(){}
/** @return bool */ function nsapi_virtual(string $uri){}
/** @return string */ function nthmac(string $clent,string $data){}
/** @return string */ function nthmac(string $clent,string $data){}
/** @return 字符串 */ function oauth_urlencode(字符串 $uri){}
/** @return void */ function ob_clean(){}
/** @return string */ function ob_deflatehandler(string $data,int $mode){}
/** @return bool */ function ob_end_clean(){}
/** @return bool */ function ob_end_flush(){}
/** @return string */ function ob_etaghandler(string $data,int $mode){}
/** @return void */ function ob_flush(){}
/** @return string */ function ob_get_clean(){}
/** @return string */ function ob_get_contents(){}
/** @return string */ function ob_get_flush(){}
/** @return int */ function ob_get_length(){}
/** @return int */ function ob_get_level(){}
/** @return string */ function ob_gzhandler(string $buffer,int $mode){}
/** @return string */ function ob_iconv_handler(string $contents,int $status){}
/** @return string */ function ob_inflatehandler(string $data,int $mode){}
/** @return array */ function ob_list_handlers(){}
/** @return bool */ function oci_cancel(resource $statement){}
/** @return string */ function oci_client_version(){}
/** @return bool */ function oci_close(resource $connection){}
/** @return bool */ function oci_commit(resource $connection){}
/** @return array */ function oci_fetch_assoc(resource $statement){}
/** @return bool */ function oci_fetch(resource $statement){}
/** @return object */ function oci_fetch_object(resource $statement){}
/** @return array */ function oci_fetch_row(resource $statement){}
/** @return bool */ function oci_field_is_null(resource $statement,mixed $field){}
/** @return string */ function oci_field_name(resource $statement,int $field){}
/** @return int */ function oci_field_precision(resource $statement,int $field){}
/** @return int */ function oci_field_scale(resource $statement,int $field){}
/** @return int */ function oci_field_size(resource $stmt,mixed $field){}
/** @return mixed */ function oci_field_type(resource $stmt,int $field){}
/** @return int */ function oci_field_type_raw(resource $statement,int $field){}
/** @return bool */ function oci_free_descriptor(resource $descriptor){}
/** @return bool */ function oci_free_statement(resource $statement){}
/** @return resource */ function oci_get_implicit_resultset(resource $statement){}
/** @return void */ function oci_internal_debug(int $onoff){}
/** @return bool */ function oci_lob_is_equal(OCI_Lob $lob1,OCI_Lob $lob2){}
/** @return resource */ function oci_new_cursor(resource $connection){}
/** @return int */ function oci_num_fields(resource $statement){}
/** @return int */ function oci_num_rows(resource $stmt){}
/** @return resource */ function oci_parse(resource $connection,string $query){}
/** @return bool */ function oci_password_change(resource $connection,string $username,string $old_password,string $new_password){}
/** @return mixed */ function oci_result(resource $statement,mixed $field){}
/** @return bool */ function oci_rollback(resource $connection){}
/** @return string */ function oci_server_version(resource $connection){}
/** @return bool */ function oci_set_action(resource $connection,string $action_name){}
/** @return bool */ function oci_set_client_identifier(resource $connection,string $client_identifier){}
/** @return bool */ function oci_set_client_info(resource $connection,string $client_info){}
/** @return bool */ function oci_set_edition(string $edition){}
/** @return bool */ function oci_set_module_name(resource $connection,string $module_name){}
/** @return bool */ function oci_set_prefetch(resource $statement,int $rows){}
/** @return string */ function oci_statement_type(resource $statement){}
/** @return number */ function octdec(string $octal_string){}
/** @return bool */ function odbc_binmode(resource $result_id,int $mode){}
/** @return void */ function odbc_close_all(){}
/** @return void */ function odbc_close(resource $connection_id){}
/** @return resource */ function odbc_columnprivileges(resource $connection_id,string $qualifier,string $owner,string $table_name,string $column_name){}
/** @return bool */ function odbc_commit(resource $connection_id){}
/** @return string */ function odbc_cursor(resource $result_id){}
/** @return array */ function odbc_data_source(resource $connection_id,int $fetch_type){}
/** @return int */ function odbc_field_len(resource $result_id,int $field_number){}
/** @return string */ function odbc_field_name(resource $result_id,int $field_number){}
/** @return int */ function odbc_field_num(resource $result_id,string $field_name){}
/** @return int */ function odbc_field_scale(resource $result_id,int $field_number){}
/** @return string */ function odbc_field_type(resource $result_id,int $field_number){}
/** @return resource */ function odbc_foreignkeys(resource $connection_id,string $pk_qualifier,string $pk_owner,string $pk_table,string $fk_qualifier,string $fk_owner,string $fk_table){}
/** @return bool */ function odbc_free_result(resource $result_id){}
/** @return bool */ function odbc_longreadlen(resource $result_id,int $length){}
/** @return bool */ function odbc_next_result(resource $result_id){}
/** @return int */ function odbc_num_fields(resource $result_id){}
/** @return int */ function odbc_num_rows(resource $result_id){}
/** @return resource */ function odbc_prepare(resource $connection_id,string $query_string){}
/** @return resource */ function odbc_primarykeys(resource $connection_id,string $qualifier,string $owner,string $table){}
/** @return resource */ function odbc_procedurecolumns(resource $connection_id){}
/** @return resource */ function odbc_procedures(resource $connection_id){}
/** @return mixed */ function odbc_result(resource $result_id,mixed $field){}
/** @return bool */ function odbc_rollback(resource $connection_id){}
/** @return bool */ function odbc_setoption(resource $id,int $function,int $option,int $param){}
/** @return resource */ function odbc_specialcolumns(resource $connection_id,int $type,string $qualifier,string $owner,string $table,int $scope,int $nullable){}
/** @return resource */ function odbc_statistics(resource $connection_id,string $qualifier,string $owner,string $table_name,int $unique,int $accuracy){}
/** @return resource */ function odbc_tableprivileges(resource $connection_id,string $qualifier,string $owner,string $name){}
/** @return boolean */ function opcache_compile_file(string $file){}
/** @return array */ function opcache_get_configuration(){}
/** @return boolean */ function opcache_reset(){}
/** @return resource */ function openal_buffer_create(){}
/** @return bool */ function openal_buffer_data(resource $buffer,int $format,string $data,int $freq){}
/** @return bool */ function openal_buffer_destroy(resource $buffer){}
/** @return int */ function openal_buffer_get(resource $buffer,int $property){}
/** @return bool */ function openal_buffer_loadwav(resource $buffer,string $wavfile){}
/** @return resource */ function openal_context_create(resource $device){}
/** @return bool */ function openal_context_current(resource $context){}
/** @return bool */ function openal_context_destroy(resource $context){}
/** @return bool */ function openal_context_process(resource $context){}
/** @return bool */ function openal_context_suspend(resource $context){}
/** @return bool */ function openal_device_close(resource $device){}
/** @return mixed */ function openal_listener_get(int $property){}
/** @return bool */ function openal_listener_set(int $property,mixed $setting){}
/** @return resource */ function openal_source_create(){}
/** @return bool */ function openal_source_destroy(resource $source){}
/** @return mixed */ function openal_source_get(resource $source,int $property){}
/** @return bool */ function openal_source_pause(resource $source){}
/** @return bool */ function openal_source_play(resource $source){}
/** @return bool */ function openal_source_rewind(resource $source){}
/** @return bool */ function openal_source_set(resource $source,int $property,mixed $setting){}
/** @return bool */ function openal_source_stop(resource $source){}
/** @return resource */ function openal_stream(resource $source,int $format,int $rate){}
/** @return bool */ function openlog(string $ident,int $option,int $facility){}
/** @return int */ function openssl_cipher_iv_length(string $method){}
/** @return string */ function openssl_dh_compute_key(string $pub_key,resource $dh_key){}
/** @return string */ function openssl_error_string(){}
/** @return void */ function openssl_free_key(resource $key_identifier){}
/** @return array */ function openssl_get_cert_locations(){}
/** @return bool */ function openssl_pkcs12_read(string $pkcs12,array &$certs,string $pass){}
/** @return void */ function openssl_pkey_free(resource $key){}
/** @return array */ function openssl_pkey_get_details(resource $key){}
/** @return resource */ function openssl_pkey_get_public(mixed $certificate){}
/** @return string */ function openssl_spki_export_challenge(string &$spkac){}
/** @return string */ function openssl_spki_export(string &$spkac){}
/** @return string */ function openssl_spki_verify(string &$spkac){}
/** @return bool */ function openssl_x509_check_private_key(mixed $cert,mixed $key){}
/** @return void */ function openssl_x509_free(resource $x509cert){}
/** @return resource */ function openssl_x509_read(mixed $x509certdata){}
/** @return int */ function ord(string $string){}
/** @return bool */ function output_add_rewrite_var(string $name,string $value){}
/** @return bool */ function output_reset_rewrite_vars(){}
/** @return bool */ function override_function(string $function_name,string $function_args,string $function_code){}
/** @return array */ function parsekit_func_arginfo(mixed $function){}
/** @return array */ function password_get_info(string $hash){}
/** @return boolean */ function password_verify(string $password,string $hash){}
/** @return int */ function pclose(resource $handle){}
/** @return int */ function pcntl_alarm(int $seconds){}
/** @return int */ function pcntl_fork(){}
/** @return int */ function pcntl_get_last_error(){}
/** @return bool */ function pcntl_signal_dispatch(){}
/** @return string */ function pcntl_strerror(int $errno){}
/** @return int */ function pcntl_wexitstatus(int $status){}
/** @return bool */ function pcntl_wifexited(int $status){}
/** @return bool */ function pcntl_wifsignaled(int $status){}
/** @return bool */ function pcntl_wifstopped(int $status){}
/** @return int */ function pcntl_wstopsig(int $status){}
/** @return int */ function pcntl_wtermsig(int $status){}
/** @return bool */ function PDF_activate_item(resource $pdfdoc,int $id){}
/** @return bool */ function PDF_add_launchlink(resource $pdfdoc,float $llx,float $lly,float $urx,float $ury,string $filename){}
/** @return bool */ function PDF_add_locallink(resource $pdfdoc,float $lowerleftx,float $lowerlefty,float $upperrightx,float $upperrighty,int $page,string $dest){}
/** @return bool */ function PDF_add_nameddest(resource $pdfdoc,string $name,string $optlist){}
/** @return bool */ function PDF_add_note(resource $pdfdoc,float $llx,float $lly,float $urx,float $ury,string $contents,string $title,string $icon,int $open){}
/** @return bool */ function PDF_add_pdflink(resource $pdfdoc,float $bottom_left_x,float $bottom_left_y,float $up_right_x,float $up_right_y,string $filename,int $page,string $dest){}
/** @return int */ function PDF_add_table_cell(resource $pdfdoc,int $table,int $column,int $row,string $text,string $optlist){}
/** @return int */ function PDF_add_textflow(resource $pdfdoc,int $textflow,string $text,string $optlist){}
/** @return bool */ function PDF_add_thumbnail(resource $pdfdoc,int $image){}
/** @return bool */ function PDF_add_weblink(resource $pdfdoc,float $lowerleftx,float $lowerlefty,float $upperrightx,float $upperrighty,string $url){}
/** @return bool */ function PDF_arc(resource $p,float $x,float $y,float $r,float $alpha,float $beta){}
/** @return bool */ function PDF_arcn(resource $p,float $x,float $y,float $r,float $alpha,float $beta){}
/** @return bool */ function PDF_attach_file(resource $pdfdoc,float $llx,float $lly,float $urx,float $ury,string $filename,string $description,string $author,string $mimetype,string $icon){}
/** @return int */ function PDF_begin_document(resource $pdfdoc,string $filename,string $optlist){}
/** @return bool */ function PDF_begin_font(resource $pdfdoc,string $filename,float $a,float $b,float $c,float $d,float $e,float $f,string $optlist){}
/** @return bool */ function PDF_begin_glyph(resource $pdfdoc,string $glyphname,float $wx,float $llx,float $lly,float $urx,float $ury){}
/** @return int */ function PDF_begin_item(resource $pdfdoc,string $tag,string $optlist){}
/** @return bool */ function PDF_begin_layer(resource $pdfdoc,int $layer){}
/** @return bool */ function PDF_begin_page(resource $pdfdoc,float $width,float $height){}
/** @return bool */ function PDF_begin_page_ext(resource $pdfdoc,float $width,float $height,string $optlist){}
/** @return int */ function PDF_begin_pattern(resource $pdfdoc,float $width,float $height,float $xstep,float $ystep,int $painttype){}
/** @return int */ function PDF_begin_template_ext(resource $pdfdoc,float $width,float $height,string $optlist){}
/** @return int */ function PDF_begin_template(resource $pdfdoc,float $width,float $height){}
/** @return bool */ function PDF_circle(resource $pdfdoc,float $x,float $y,float $r){}
/** @return bool */ function PDF_clip(resource $p){}
/** @return bool */ function PDF_close(resource $p){}
/** @return bool */ function PDF_close_image(resource $p,int $image){}
/** @return bool */ function PDF_closepath(resource $p){}
/** @return bool */ function PDF_closepath_fill_stroke(resource $p){}
/** @return bool */ function PDF_closepath_stroke(resource $p){}
/** @return bool */ function PDF_close_pdi(resource $p,int $doc){}
/** @return bool */ function PDF_close_pdi_page(resource $p,int $page){}
/** @return bool */ function PDF_concat(resource $p,float $a,float $b,float $c,float $d,float $e,float $f){}
/** @return bool */ function PDF_continue_text(resource $p,string $text){}
/** @return int */ function PDF_create_3dview(resource $pdfdoc,string $username,string $optlist){}
/** @return int */ function PDF_create_action(resource $pdfdoc,string $type,string $optlist){}
/** @return bool */ function PDF_create_annotation(resource $pdfdoc,float $llx,float $lly,float $urx,float $ury,string $type,string $optlist){}
/** @return int */ function PDF_create_bookmark(resource $pdfdoc,string $text,string $optlist){}
/** @return bool */ function PDF_create_field(resource $pdfdoc,float $llx,float $lly,float $urx,float $ury,string $name,string $type,string $optlist){}
/** @return bool */ function PDF_create_fieldgroup(resource $pdfdoc,string $name,string $optlist){}
/** @return int */ function PDF_create_gstate(resource $pdfdoc,string $optlist){}
/** @return bool */ function PDF_create_pvf(resource $pdfdoc,string $filename,string $data,string $optlist){}
/** @return int */ function PDF_create_textflow(resource $pdfdoc,string $text,string $optlist){}
/** @return bool */ function PDF_curveto(resource $p,float $x1,float $y1,float $x2,float $y2,float $x3,float $y3){}
/** @return int */ function PDF_define_layer(resource $pdfdoc,string $name,string $optlist){}
/** @return bool */ function PDF_delete(resource $pdfdoc){}
/** @return int */ function PDF_delete_pvf(resource $pdfdoc,string $filename){}
/** @return bool */ function PDF_delete_table(resource $pdfdoc,int $table,string $optlist){}
/** @return bool */ function PDF_delete_textflow(resource $pdfdoc,int $textflow){}
/** @return bool */ function PDF_encoding_set_char(resource $pdfdoc,string $encoding,int $slot,string $glyphname,int $uv){}
/** @return bool */ function PDF_end_document(resource $pdfdoc,string $optlist){}
/** @return bool */ function PDF_end_font(resource $pdfdoc){}
/** @return bool */ function PDF_end_glyph(resource $pdfdoc){}
/** @return bool */ function PDF_end_item(resource $pdfdoc,int $id){}
/** @return bool */ function PDF_end_layer(resource $pdfdoc){}
/** @return bool */ function PDF_end_page(resource $p){}
/** @return bool */ function PDF_end_page_ext(resource $pdfdoc,string $optlist){}
/** @return bool */ function PDF_endpath(resource $p){}
/** @return bool */ function PDF_end_pattern(resource $p){}
/** @return bool */ function PDF_end_template(resource $p){}
/** @return bool */ function PDF_fill(resource $p){}
/** @return int */ function PDF_fill_imageblock(resource $pdfdoc,int $page,string $blockname,int $image,string $optlist){}
/** @return int */ function PDF_fill_pdfblock(resource $pdfdoc,int $page,string $blockname,int $contents,string $optlist){}
/** @return bool */ function PDF_fill_stroke(resource $p){}
/** @return int */ function PDF_fill_textblock(resource $pdfdoc,int $page,string $blockname,string $text,string $optlist){}
/** @return int */ function PDF_findfont(resource $p,string $fontname,string $encoding,int $embed){}
/** @return bool */ function PDF_fit_image(resource $pdfdoc,int $image,float $x,float $y,string $optlist){}
/** @return bool */ function PDF_fit_pdi_page(resource $pdfdoc,int $page,float $x,float $y,string $optlist){}
/** @return string */ function PDF_fit_table(resource $pdfdoc,int $table,float $llx,float $lly,float $urx,float $ury,string $optlist){}
/** @return string */ function PDF_fit_textflow(resource $pdfdoc,int $textflow,float $llx,float $lly,float $urx,float $ury,string $optlist){}
/** @return bool */ function PDF_fit_textline(resource $pdfdoc,string $text,float $x,float $y,string $optlist){}
/** @return string */ function PDF_get_apiname(resource $pdfdoc){}
/** @return string */ function PDF_get_buffer(resource $p){}
/** @return string */ function PDF_get_errmsg(resource $pdfdoc){}
/** @return int */ function PDF_get_errnum(resource $pdfdoc){}
/** @return int */ function PDF_get_majorversion(){}
/** @return int */ function PDF_get_minorversion(){}
/** @return string */ function PDF_get_parameter(resource $p,string $key,float $modifier){}
/** @return string */ function PDF_get_pdi_parameter(resource $p,string $key,int $doc,int $page,int $reserved){}
/** @return float */ function PDF_get_pdi_value(resource $p,string $key,int $doc,int $page,int $reserved){}
/** @return float */ function PDF_get_value(resource $p,string $key,float $modifier){}
/** @return float */ function PDF_info_font(resource $pdfdoc,int $font,string $keyword,string $optlist){}
/** @return float */ function PDF_info_matchbox(resource $pdfdoc,string $boxname,int $num,string $keyword){}
/** @return float */ function PDF_info_table(resource $pdfdoc,int $table,string $keyword){}
/** @return float */ function PDF_info_textflow(resource $pdfdoc,int $textflow,string $keyword){}
/** @return float */ function PDF_info_textline(resource $pdfdoc,string $text,string $keyword,string $optlist){}
/** @return bool */ function PDF_initgraphics(resource $p){}
/** @return bool */ function PDF_lineto(resource $p,float $x,float $y){}
/** @return int */ function PDF_load_3ddata(resource $pdfdoc,string $filename,string $optlist){}
/** @return int */ function PDF_load_font(resource $pdfdoc,string $fontname,string $encoding,string $optlist){}
/** @return int */ function PDF_load_iccprofile(resource $pdfdoc,string $profilename,string $optlist){}
/** @return int */ function PDF_load_image(resource $pdfdoc,string $imagetype,string $filename,string $optlist){}
/** @return int */ function PDF_makespotcolor(resource $p,string $spotname){}
/** @return bool */ function PDF_moveto(resource $p,float $x,float $y){}
/** @return resource */ function PDF_new(){}
/** @return int */ function PDF_open_ccitt(resource $pdfdoc,string $filename,int $width,int $height,int $BitReverse,int $k,int $Blackls1){}
/** @return bool */ function PDF_open_file(resource $p,string $filename){}
/** @return int */ function PDF_open_image_file(resource $p,string $imagetype,string $filename,string $stringparam,int $intparam){}
/** @return int */ function PDF_open_image(resource $p,string $imagetype,string $source,string $data,int $length,int $width,int $height,int $components,int $bpc,string $params){}
/** @return int */ function PDF_open_memory_image(resource $p,resource $image){}
/** @return int */ function PDF_open_pdi_document(resource $p,string $filename,string $optlist){}
/** @return int */ function PDF_open_pdi(resource $pdfdoc,string $filename,string $optlist,int $len){}
/** @return int */ function PDF_open_pdi_page(resource $p,int $doc,int $pagenumber,string $optlist){}
/** @return float */ function PDF_pcos_get_number(resource $p,int $doc,string $path){}
/** @return string */ function PDF_pcos_get_stream(resource $p,int $doc,string $optlist,string $path){}
/** @return string */ function PDF_pcos_get_string(resource $p,int $doc,string $path){}
/** @return bool */ function PDF_place_image(resource $pdfdoc,int $image,float $x,float $y,float $scale){}
/** @return bool */ function PDF_place_pdi_page(resource $pdfdoc,int $page,float $x,float $y,float $sx,float $sy){}
/** @return int */ function PDF_process_pdi(resource $pdfdoc,int $doc,int $page,string $optlist){}
/** @return bool */ function PDF_rect(resource $p,float $x,float $y,float $width,float $height){}
/** @return bool */ function PDF_restore(resource $p){}
/** @return bool */ function PDF_resume_page(resource $pdfdoc,string $optlist){}
/** @return bool */ function PDF_rotate(resource $p,float $phi){}
/** @return bool */ function PDF_save(resource $p){}
/** @return bool */ function PDF_scale(resource $p,float $sx,float $sy){}
/** @return bool */ function PDF_set_border_color(resource $p,float $red,float $green,float $blue){}
/** @return bool */ function PDF_set_border_dash(resource $pdfdoc,float $black,float $white){}
/** @return bool */ function PDF_set_border_style(resource $pdfdoc,string $style,float $width){}
/** @return bool */ function PDF_setcolor(resource $p,string $fstype,string $colorspace,float $c1,float $c2,float $c3,float $c4){}
/** @return bool */ function PDF_setdash(resource $pdfdoc,float $b,float $w){}
/** @return bool */ function PDF_setdashpattern(resource $pdfdoc,string $optlist){}
/** @return bool */ function PDF_setflat(resource $pdfdoc,float $flatness){}
/** @return bool */ function PDF_setfont(resource $pdfdoc,int $font,float $fontsize){}
/** @return bool */ function PDF_setgray(resource $p,float $g){}
/** @return bool */ function PDF_setgray_fill(resource $p,float $g){}
/** @return bool */ function PDF_setgray_stroke(resource $p,float $g){}
/** @return bool */ function PDF_set_gstate(resource $pdfdoc,int $gstate){}
/** @return bool */ function PDF_set_info(resource $p,string $key,string $value){}
/** @return bool */ function PDF_set_layer_dependency(resource $pdfdoc,string $type,string $optlist){}
/** @return bool */ function PDF_setlinecap(resource $p,int $linecap){}
/** @return bool */ function PDF_setlinejoin(resource $p,int $value){}
/** @return bool */ function PDF_setlinewidth(resource $p,float $width){}
/** @return bool */ function PDF_setmatrix(resource $p,float $a,float $b,float $c,float $d,float $e,float $f){}
/** @return bool */ function PDF_setmiterlimit(resource $pdfdoc,float $miter){}
/** @return bool */ function PDF_set_parameter(resource $p,string $key,string $value){}
/** @return bool */ function PDF_setrgbcolor(resource $p,float $red,float $green,float $blue){}
/** @return bool */ function PDF_setrgbcolor_fill(resource $p,float $red,float $green,float $blue){}
/** @return bool */ function PDF_setrgbcolor_stroke(resource $p,float $red,float $green,float $blue){}
/** @return bool */ function PDF_set_text_pos(resource $p,float $x,float $y){}
/** @return bool */ function PDF_set_value(resource $p,string $key,float $value){}
/** @return int */ function PDF_shading(resource $pdfdoc,string $shtype,float $x0,float $y0,float $x1,float $y1,float $c1,float $c2,float $c3,float $c4,string $optlist){}
/** @return int */ function PDF_shading_pattern(resource $pdfdoc,int $shading,string $optlist){}
/** @return bool */ function PDF_shfill(resource $pdfdoc,int $shading){}
/** @return bool */ function PDF_show(resource $pdfdoc,string $text){}
/** @return int */ function PDF_show_boxed(resource $p,string $text,float $left,float $top,float $width,float $height,string $mode,string $feature){}
/** @return bool */ function PDF_show_xy(resource $p,string $text,float $x,float $y){}
/** @return bool */ function PDF_skew(resource $p,float $alpha,float $beta){}
/** @return float */ function PDF_stringwidth(resource $p,string $text,int $font,float $fontsize){}
/** @return bool */ function PDF_stroke(resource $p){}
/** @return bool */ function PDF_suspend_page(resource $pdfdoc,string $optlist){}
/** @return bool */ function PDF_translate(resource $p,float $tx,float $ty){}
/** @return string */ function PDF_utf16_to_utf8(resource $pdfdoc,string $utf16string){}
/** @return string */ function PDF_utf32_to_utf16(resource $pdfdoc,string $utf32string,string $ordering){}
/** @return string */ function PDF_utf8_to_utf16(resource $pdfdoc,string $utf8string,string $ordering){}
/** @return int */ function pg_affected_rows(resource $result){}
/** @return bool */ function pg_cancel_query(resource $connection){}
/** @return bool */ function pg_connection_busy(resource $connection){}
/** @return bool */ function pg_connection_reset(resource $connection){}
/** @return int */ function pg_connection_status(resource $connection){}
/** @return bool */ function pg_consume_input(resource $connection){}
/** @return array */ function pg_fetch_all(resource $result){}
/** @return mixed */ function pg_fetch_result(resource $result,int $row,mixed $field){}
/** @return int */ function pg_field_is_null(resource $result,int $row,mixed $field){}
/** @return string */ function pg_field_name(resource $result,int $field_number){}
/** @return int */ function pg_field_num(resource $result,string $field_name){}
/** @return int */ function pg_field_prtlen(resource $result,int $row_number,string $field_name){}
/** @return int */ function pg_field_size(resource $result,int $field_number){}
/** @return int */ function pg_field_type_oid(resource $result,int $field_number){}
/** @return string */ function pg_field_type(resource $result,int $field_number){}
/** @return mixed */ function pg_flush(resource $connection){}
/** @return bool */ function pg_free_result(resource $result){}
/** @return int */ function pg_get_pid(resource $connection){}
/** @return string */ function pg_last_notice(resource $connection){}
/** @return int */ function pg_last_oid(resource $result){}
/** @return bool */ function pg_lo_close(resource $large_object){}
/** @return resource */ function pg_lo_open(resource $connection,int $oid,string $mode){}
/** @return int */ function pg_lo_read_all(resource $large_object){}
/** @return int */ function pg_lo_tell(resource $large_object){}
/** @return bool */ function pg_lo_truncate(resource $large_object,int $size){}
/** @return bool */ function pg_lo_unlink(resource $connection,int $oid){}
/** @return int */ function pg_num_fields(resource $result){}
/** @return int */ function pg_num_rows(resource $result){}
/** @return string */ function pg_result_error_field(resource $result,int $fieldcode){}
/** @return string */ function pg_result_error(resource $result){}
/** @return array */ function pg_result_seek(resource $result,int $offset){}
/** @return bool */ function pg_send_execute(resource $connection,string $stmtname,array $params){}
/** @return bool */ function pg_send_prepare(resource $connection,string $stmtname,string $query){}
/** @return bool */ function pg_send_query(resource $connection,string $query){}
/** @return bool */ function pg_send_query_params(resource $connection,string $query,array $params){}
/** @return resource */ function pg_socket(resource $connection){}
/** @return int */ function pg_transaction_status(resource $connection){}
/** @return string */ function pg_unescape_bytea(string $data){}
/** @return string */ function php_ini_loaded_file(){}
/** @return string */ function php_ini_scanned_files(){}
/** @return string */ function php_logo_guid(){}
/** @return string */ function php_sapi_name(){}
/** @return string */ function php_strip_whitespace(string $filename){}
/** @return float */ function pi(){}
/** @return bool */ function png2wbmp(string $pngname,string $wbmpname,int $dest_height,int $dest_width,int $threshold){}
/** @return resource */ function popen(string $command,string $mode){}
/** @return string */ function posix_ctermid(){}
/** @return string */ function posix_getcwd(){}
/** @return int */ function posix_getegid(){}
/** @return int */ function posix_geteuid(){}
/** @return int */ function posix_getgid(){}
/** @return array */ function posix_getgrgid(int $gid){}
/** @return array */ function posix_getgrnam(string $name){}
/** @return array */ function posix_getgroups(){}
/** @return int */ function posix_get_last_error(){}
/** @return string */ function posix_getlogin(){}
/** @return int */ function posix_getpgid(int $pid){}
/** @return int */ function posix_getpgrp(){}
/** @return int */ function posix_getpid(){}
/** @return int */ function posix_getppid(){}
/** @return array */ function posix_getpwnam(string $username){}
/** @return array */ function posix_getpwuid(int $uid){}
/** @return array */ function posix_getrlimit(){}
/** @return int */ function posix_getsid(int $pid){}
/** @return int */ function posix_getuid(){}
/** @return bool */ function posix_initgroups(string $name,int $base_group_id){}
/** @return bool */ function posix_isatty(mixed $fd){}
/** @return bool */ function posix_kill(int $pid,int $sig){}
/** @return bool */ function posix_mkfifo(string $pathname,int $mode){}
/** @return bool */ function posix_setegid(int $gid){}
/** @return bool */ function posix_seteuid(int $uid){}
/** @return bool */ function posix_setgid(int $gid){}
/** @return bool */ function posix_setpgid(int $pid,int $pgid){}
/** @return int */ function posix_setsid(){}
/** @return bool */ function posix_setuid(int $uid){}
/** @return string */ function posix_strerror(int $errno){}
/** @return array */ function posix_times(){}
/** @return string */ function posix_ttyname(mixed $fd){}
/** @return array */ function posix_uname(){}
/** @return number */ function pow(number $base,number $exp){}
/** @return int */ function preg_last_error(){}
/** @return mixed */ function prev(array &$array){}
/** @return int */ function proc_close(resource $process){}
/** @return array */ function proc_get_status(resource $process){}
/** @return bool */ function proc_nice(int $increment){}
/** @return bool */ function property_exists(mixed $class,string $property){}
/** @return bool */ function ps_add_launchlink(resource $psdoc,float $llx,float $lly,float $urx,float $ury,string $filename){}
/** @return bool */ function ps_add_locallink(resource $psdoc,float $llx,float $lly,float $urx,float $ury,int $page,string $dest){}
/** @return bool */ function ps_add_note(resource $psdoc,float $llx,float $lly,float $urx,float $ury,string $contents,string $title,string $icon,int $open){}
/** @return bool */ function ps_add_pdflink(resource $psdoc,float $llx,float $lly,float $urx,float $ury,string $filename,int $page,string $dest){}
/** @return bool */ function ps_add_weblink(resource $psdoc,float $llx,float $lly,float $urx,float $ury,string $url){}
/** @return bool */ function ps_arc(resource $psdoc,float $x,float $y,float $radius,float $alpha,float $beta){}
/** @return bool */ function ps_arcn(resource $psdoc,float $x,float $y,float $radius,float $alpha,float $beta){}
/** @return bool */ function ps_begin_page(resource $psdoc,float $width,float $height){}
/** @return int */ function ps_begin_pattern(resource $psdoc,float $width,float $height,float $xstep,float $ystep,int $painttype){}
/** @return int */ function ps_begin_template(resource $psdoc,float $width,float $height){}
/** @return bool */ function ps_circle(resource $psdoc,float $x,float $y,float $radius){}
/** @return bool */ function ps_clip(resource $psdoc){}
/** @return bool */ function ps_close(resource $psdoc){}
/** @return void */ function ps_close_image(resource $psdoc,int $imageid){}
/** @return bool */ function ps_closepath(resource $psdoc){}
/** @return bool */ function ps_closepath_stroke(resource $psdoc){}
/** @return bool */ function ps_continue_text(resource $psdoc,string $text){}
/** @return bool */ function ps_curveto(resource $psdoc,float $x1,float $y1,float $x2,float $y2,float $x3,float $y3){}
/** @return bool */ function ps_delete(resource $psdoc){}
/** @return bool */ function ps_end_page(resource $psdoc){}
/** @return bool */ function ps_end_pattern(resource $psdoc){}
/** @return bool */ function ps_end_template(resource $psdoc){}
/** @return bool */ function ps_fill(resource $psdoc){}
/** @return bool */ function ps_fill_stroke(resource $psdoc){}
/** @return string */ function ps_get_buffer(resource $psdoc){}
/** @return array */ function ps_hyphenate(resource $psdoc,string $text){}
/** @return bool */ function ps_include_file(resource $psdoc,string $file){}
/** @return bool */ function ps_lineto(resource $psdoc,float $x,float $y){}
/** @return bool */ function ps_moveto(resource $psdoc,float $x,float $y){}
/** @return resource */ function ps_new(){}
/** @return int */ function ps_open_image(resource $psdoc,string $type,string $source,string $data,int $lenght,int $width,int $height,int $components,int $bpc,string $params){}
/** @return int */ function ps_open_memory_image(resource $psdoc,int $gd){}
/** @return bool */ function pspell_add_to_personal(int $dictionary_link,string $word){}
/** @return bool */ function pspell_add_to_session(int $dictionary_link,string $word){}
/** @return bool */ function pspell_check(int $dictionary_link,string $word){}
/** @return bool */ function pspell_clear_session(int $dictionary_link){}
/** @return bool */ function pspell_config_data_dir(int $conf,string $directory){}
/** @return bool */ function pspell_config_dict_dir(int $conf,string $directory){}
/** @return bool */ function pspell_config_ignore(int $dictionary_link,int $n){}
/** @return bool */ function pspell_config_mode(int $dictionary_link,int $mode){}
/** @return bool */ function pspell_config_personal(int $dictionary_link,string $file){}
/** @return bool */ function pspell_config_repl(int $dictionary_link,string $file){}
/** @return bool */ function pspell_config_runtogether(int $dictionary_link,bool $flag){}
/** @return bool */ function pspell_config_save_repl(int $dictionary_link,bool $flag){}
/** @return int */ function pspell_new_config(int $config){}
/** @return bool */ function pspell_save_wordlist(int $dictionary_link){}
/** @return bool */ function pspell_store_replacement(int $dictionary_link,string $misspelled,string $correct){}
/** @return array */ function pspell_suggest(int $dictionary_link,string $word){}
/** @return bool */ function ps_place_image(resource $psdoc,int $imageid,float $x,float $y,float $scale){}
/** @return bool */ function ps_rect(resource $psdoc,float $x,float $y,float $width,float $height){}
/** @return bool */ function ps_restore(resource $psdoc){}
/** @return bool */ function ps_rotate(resource $psdoc,float $rot){}
/** @return bool */ function ps_save(resource $psdoc){}
/** @return bool */ function ps_scale(resource $psdoc,float $x,float $y){}
/** @return bool */ function ps_set_border_color(resource $psdoc,float $red,float $green,float $blue){}
/** @return bool */ function ps_set_border_dash(resource $psdoc,float $black,float $white){}
/** @return bool */ function ps_set_border_style(resource $psdoc,string $style,float $width){}
/** @return bool */ function ps_setcolor(resource $psdoc,string $type,string $colorspace,float $c1,float $c2,float $c3,float $c4){}
/** @return bool */ function ps_setdash(resource $psdoc,float $on,float $off){}
/** @return bool */ function ps_setflat(resource $psdoc,float $value){}
/** @return bool */ function ps_setfont(resource $psdoc,int $fontid,float $size){}
/** @return bool */ function ps_setgray(resource $psdoc,float $gray){}
/** @return bool */ function ps_set_info(resource $p,string $key,string $val){}
/** @return bool */ function ps_setlinecap(resource $psdoc,int $type){}
/** @return bool */ function ps_setlinejoin(resource $psdoc,int $type){}
/** @return bool */ function ps_setlinewidth(resource $psdoc,float $width){}
/** @return bool */ function ps_setmiterlimit(resource $psdoc,float $value){}
/** @return bool */ function ps_setoverprintmode(resource $psdoc,int $mode){}
/** @return bool */ function ps_set_parameter(resource $psdoc,string $name,string $value){}
/** @return bool */ function ps_setpolydash(resource $psdoc,float $arr){}
/** @return bool */ function ps_set_text_pos(resource $psdoc,float $x,float $y){}
/** @return bool */ function ps_set_value(resource $psdoc,string $name,float $value){}
/** @return int */ function ps_shading(resource $psdoc,string $type,float $x0,float $y0,float $x1,float $y1,float $c1,float $c2,float $c3,float $c4,string $optlist){}
/** @return int */ function ps_shading_pattern(resource $psdoc,int $shadingid,string $optlist){}
/** @return bool */ function ps_shfill(resource $psdoc,int $shadingid){}
/** @return bool */ function ps_show2(resource $psdoc,string $text,int $len){}
/** @return bool */ function ps_show(resource $psdoc,string $text){}
/** @return bool */ function ps_show_xy2(resource $psdoc,string $text,int $len,float $xcoor,float $ycoor){}
/** @return bool */ function ps_show_xy(resource $psdoc,string $text,float $x,float $y){}
/** @return bool */ function ps_stroke(resource $psdoc){}
/** @return bool */ function ps_symbol(resource $psdoc,int $ord){}
/** @return bool */ function ps_translate(resource $psdoc,float $x,float $y){}
/** @return bool */ function putenv(string $setting){}
/** @return bool */ function px_close(resource $pxdoc){}
/** @return bool */ function px_create_fp(resource $pxdoc,resource $file,array $fielddesc){}
/** @return string */ function px_date2string(resource $pxdoc,int $value,string $format){}
/** @return bool */ function px_delete(resource $pxdoc){}
/** @return bool */ function px_delete_record(resource $pxdoc,int $num){}
/** @return array */ function px_get_field(resource $pxdoc,int $fieldno){}
/** @return array */ function px_get_info(resource $pxdoc){}
/** @return string */ function px_get_parameter(resource $pxdoc,string $name){}
/** @return float */ function px_get_value(resource $pxdoc,string $name){}
/** @return int */ function px_insert_record(resource $pxdoc,array $data){}
/** @return resource */ function px_new(){}
/** @return int */ function px_numfields(resource $pxdoc){}
/** @return int */ function px_numrecords(resource $pxdoc){}
/** @return bool */ function px_open_fp(resource $pxdoc,resource $file){}
/** @return bool */ function px_set_blob_file(resource $pxdoc,string $filename){}
/** @return bool */ function px_set_parameter(resource $pxdoc,string $name,string $value){}
/** @return void */ function px_set_tablename(resource $pxdoc,string $name){}
/** @return bool */ function px_set_targetencoding(resource $pxdoc,string $encoding){}
/** @return bool */ function px_set_value(resource $pxdoc,string $name,float $value){}
/** @return string */ function px_timestamp2string(resource $pxdoc,float $value,string $format){}
/** @return bool */ function px_update_record(resource $pxdoc,array $data,int $num){}
/** @return string */ function quoted_printable_decode(string $str){}
/** @return string */ function quoted_printable_encode(string $str){}
/** @return string */ function quotemeta(string $str){}
/** @return float */ function rad2deg(float $number){}
/** @return resource */ function radius_acct_open(){}
/** @return bool */ function radius_add_server(resource $radius_handle,string $hostname,int $port,string $secret,int $timeout,int $max_tries){}
/** @return resource */ function radius_auth_open(){}
/** @return bool */ function radius_close(resource $radius_handle){}
/** @return bool */ function radius_config(resource $radius_handle,string $file){}
/** @return bool */ function radius_create_request(resource $radius_handle,int $type){}
/** @return string */ function radius_cvt_addr(string $data){}
/** @return int */ function radius_cvt_int(string $data){}
/** @return string */ function radius_cvt_string(string $data){}
/** @return string */ function radius_demangle_mppe_key(resource $radius_handle,string $mangled){}
/** @return string */ function radius_demangle(resource $radius_handle,string $mangled){}
/** @return mixed */ function radius_get_attr(resource $radius_handle){}
/** @return string */ function radius_get_tagged_attr_data(string $data){}
/** @return integer */ function radius_get_tagged_attr_tag(string $data){}
/** @return array */ function radius_get_vendor_attr(string $data){}
/** @return bool */ function radius_put_vendor_addr(resource $radius_handle,int $vendor,int $type,string $addr){}
/** @return string */ function radius_request_authenticator(resource $radius_handle){}
/** @return string */ function radius_salt_encrypt_attr(resource $radius_handle,string $data){}
/** @return int */ function radius_send_request(resource $radius_handle){}
/** @return string */ function radius_server_secret(resource $radius_handle){}
/** @return string */ function radius_strerror(resource $radius_handle){}
/** @return int */ function rand(){}
/** @return string */ function rar_wrapper_cache_stats(){}
/** @return string */ function rawurldecode(string $str){}
/** @return string */ function rawurlencode(string $str){}
/** @return bool */ function readline_add_history(string $line){}
/** @return bool */ function readline_callback_handler_install(string $prompt,callable $callback){}
/** @return bool */ function readline_callback_handler_remove(){}
/** @return void */ function readline_callback_read_char(){}
/** @return bool */ function readline_clear_history(){}
/** @return bool */ function readline_completion_function(callable $function){}
/** @return array */ function readline_list_history(){}
/** @return void */ function readline_on_new_line(){}
/** @return void */ function readline_redisplay(){}
/** @return string */ function readlink(string $path){}
/** @return array */ function realpath_cache_get(){}
/** @return int */ function realpath_cache_size(){}
/** @return string */ function realpath(string $path){}
/** @return bool */ function recode_file(string $request,resource $input,resource $output){}
/** @return string */ function recode_string(string $request,string $string){}
/** @return bool */ function rename_function(string $original_name,string $new_name){}
/** @return mixed */ function reset(array &$array){}
/** @return bool */ function restore_error_handler(){}
/** @return bool */ function restore_exception_handler(){}
/** @return void */ function restore_include_path(){}
/** @return bool */ function rewind(resource $handle){}
/** @return bool */ function rpm_close(resource $rpmr){}
/** @return mixed */ function rpm_get_tag(resource $rpmr,int $tagnum){}
/** @return bool */ function rpm_is_valid(string $filename){}
/** @return resource */ function rpm_open(string $filename){}
/** @return string */ function rpm_version(){}
/** @return void */ function rrdc_disconnect(){}
/** @return bool */ function rrd_create(string $filename,array $options){}
/** @return string */ function rrd_error(){}
/** @return array */ function rrd_fetch(string $filename,array $options){}
/** @return array */ function rrd_graph(string $filename,array $options){}
/** @return array */ function rrd_info(string $filename){}
/** @return int */ function rrd_last(string $filename){}
/** @return array */ function rrd_lastupdate(string $filename){}
/** @return bool */ function rrd_tune(string $filename,array $options){}
/** @return bool */ function rrd_update(string $filename,array $options){}
/** @return string */ function rrd_version(){}
/** @return array */ function rrd_xport(array $options){}
/** @return bool */ function runkit_class_adopt(string $classname,string $parentname){}
/** @return bool */ function runkit_class_emancipate(string $classname){}
/** @return bool */ function runkit_constant_add(string $constname,mixed $value){}
/** @return bool */ function runkit_constant_redefine(string $constname,mixed $newvalue){}
/** @return bool */ function runkit_constant_remove(string $constname){}
/** @return bool */ function runkit_function_add(string $funcname,string $arglist,string $code){}
/** @return bool */ function runkit_function_copy(string $funcname,string $targetname){}
/** @return bool */ function runkit_function_redefine(string $funcname,string $arglist,string $code){}
/** @return bool */ function runkit_function_remove(string $funcname){}
/** @return bool */ function runkit_function_rename(string $funcname,string $newname){}
/** @return bool */ function runkit_lint(string $code){}
/** @return bool */ function runkit_lint_file(string $filename){}
/** @return bool */ function runkit_method_remove(string $classname,string $methodname){}
/** @return bool */ function runkit_method_rename(string $classname,string $methodname,string $newname){}
/** @return bool */ function runkit_return_value_used(){}
/** @return array */ function runkit_superglobals(){}
/** @return bool */ function sem_acquire(resource $sem_identifier){}
/** @return bool */ function sem_release(resource $sem_identifier){}
/** @return bool */ function sem_remove(resource $sem_identifier){}
/** @return string */ function serialize(mixed $value){}
/** @return bool */ function session_abort(){}
/** @return bool */ function session_decode(string $data){}
/** @return bool */ function session_destroy(){}
/** @return string */ function session_encode(){}
/** @return array */ function session_get_cookie_params(){}
/** @return bool */ function session_is_registered(string $name){}
/** @return string */ function session_pgsql_get_field(){}
/** @return bool */ function session_pgsql_reset(){}
/** @return bool */ function session_pgsql_set_field(string $value){}
/** @return array */ function session_pgsql_status(){}
/** @return void */ function session_register_shutdown(){}
/** @return bool */ function session_reset(){}
/** @return bool */ function session_start(){}
/** @return int */ function session_status(){}
/** @return bool */ function session_unregister(string $name){}
/** @return void */ function session_unset(){}
/** @return void */ function session_write_close(){}
/** @return callable */ function set_exception_handler(callable $exception_handler){}
/** @return string */ function set_include_path(string $new_include_path){}
/** @return bool */ function set_magic_quotes_runtime(bool $new_setting){}
/** @return void */ function setproctitle(string $title){}
/** @return bool */ function setthreadtitle(string $title){}
/** @return void */ function set_time_limit(int $seconds){}
/** @return bool */ function settype(mixed &$var,string $type){}
/** @return string */ function shell_exec(string $cmd){}
/** @return bool */ function shm_detach(resource $shm_identifier){}
/** @return mixed */ function shm_get_var(resource $shm_identifier,int $variable_key){}
/** @return bool */ function shm_has_var(resource $shm_identifier,int $variable_key){}
/** @return void */ function shmop_close(int $shmid){}
/** @return bool */ function shmop_delete(int $shmid){}
/** @return int */ function shmop_open(int $key,string $flags,int $mode,int $size){}
/** @return string */ function shmop_read(int $shmid,int $start,int $count){}
/** @return int */ function shmop_size(int $shmid){}
/** @return int */ function shmop_write(int $shmid,string $data,int $offset){}
/** @return bool */ function shm_put_var(resource $shm_identifier,int $variable_key,mixed $variable){}
/** @return bool */ function shm_remove(resource $shm_identifier){}
/** @return bool */ function shm_remove_var(resource $shm_identifier,int $variable_key){}
/** @return bool */ function shuffle(array &$array){}
/** @return float */ function sin(float $arg){}
/** @return float */ function sinh(float $arg){}
/** @return int */ function sleep(int $seconds){}
/** @return bool */ function snmp_get_quick_print(){}
/** @return int */ function snmp_get_valueretrieval(){}
/** @return bool */ function snmp_read_mib(string $filename){}
/** @return bool */ function snmp_set_enum_print(int $enum_print){}
/** @return void */ function snmp_set_oid_numeric_print(int $oid_format){}
/** @return bool */ function snmp_set_oid_output_format(int $oid_format){}
/** @return void */ function snmp_set_quick_print(bool $quick_print){}
/** @return bool */ function snmp_set_valueretrieval(int $method){}
/** @return resource */ function socket_accept(resource $socket){}
/** @return void */ function socket_close(resource $socket){}
/** @return int */ function socket_cmsg_space(int $level,int $type){}
/** @return bool */ function socket_create_pair(int $domain,int $type,int $protocol,array &$fd){}
/** @return resource */ function socket_create(int $domain,int $type,int $protocol){}
/** @return mixed */ function socket_get_option(resource $socket,int $level,int $optname){}
/** @return resource */ function socket_import_stream(resource $stream){}
/** @return int */ function socket_recv(resource $socket,string &$buf,int $len,int $flags){}
/** @return int */ function socket_send(resource $socket,string $buf,int $len,int $flags){}
/** @return int */ function socket_sendmsg(resource $socket,array $message,int $flags){}
/** @return bool */ function socket_set_block(resource $socket){}
/** @return bool */ function socket_set_nonblock(resource $socket){}
/** @return bool */ function socket_set_option(resource $socket,int $level,int $optname,mixed $optval){}
/** @return string */ function socket_strerror(int $errno){}
/** @return string */ function solr_get_version(){}
/** @return string */ function soundex(string $str){}
/** @return void */ function spl_autoload_call(string $class_name){}
/** @return array */ function spl_autoload_functions(){}
/** @return bool */ function spl_autoload_unregister(mixed $autoload_function){}
/** @return array */ function spl_classes(){}
/** @return string */ function spl_object_hash(object $obj){}
/** @return void */ function sqlite_busy_timeout(resource $dbhandle,int $milliseconds){}
/** @return int */ function sqlite_changes(resource $dbhandle){}
/** @return void */ function sqlite_close(resource $dbhandle){}
/** @return string */ function sqlite_error_string(int $error_code){}
/** @return string */ function sqlite_escape_string(string $item){}
/** @return string */ function sqlite_field_name(resource $result,int $field_index){}
/** @return bool */ function sqlite_has_more(resource $result){}
/** @return bool */ function sqlite_has_prev(resource $result){}
/** @return int */ function sqlite_last_error(resource $dbhandle){}
/** @return int */ function sqlite_last_insert_rowid(resource $dbhandle){}
/** @return string */ function sqlite_libencoding(){}
/** @return string */ function sqlite_libversion(){}
/** @return bool */ function sqlite_next(resource $result){}
/** @return int */ function sqlite_num_fields(resource $result){}
/** @return int */ function sqlite_num_rows(resource $result){}
/** @return bool */ function sqlite_prev(resource $result){}
/** @return bool */ function sqlite_rewind(resource $result){}
/** @return bool */ function sqlite_seek(resource $result,int $rownum){}
/** @return string */ function sqlite_udf_decode_binary(string $data){}
/** @return string */ function sqlite_udf_encode_binary(string $data){}
/** @return bool */ function sqlite_valid(resource $result){}
/** @return string */ function sql_regcase(string $string){}
/** @return bool */ function sqlsrv_begin_transaction(resource $conn){}
/** @return bool */ function sqlsrv_cancel(resource $stmt){}
/** @return array */ function sqlsrv_client_info(resource $conn){}
/** @return bool */ function sqlsrv_close(resource $conn){}
/** @return bool */ function sqlsrv_commit(resource $conn){}
/** @return bool */ function sqlsrv_configure(string $setting,mixed $value){}
/** @return bool */ function sqlsrv_execute(resource $stmt){}
/** @return mixed */ function sqlsrv_field_metadata(resource $stmt){}
/** @return bool */ function sqlsrv_free_stmt(resource $stmt){}
/** @return mixed */ function sqlsrv_get_config(string $setting){}
/** @return bool */ function sqlsrv_has_rows(resource $stmt){}
/** @return mixed */ function sqlsrv_next_result(resource $stmt){}
/** @return mixed */ function sqlsrv_num_fields(resource $stmt){}
/** @return mixed */ function sqlsrv_num_rows(resource $stmt){}
/** @return bool */ function sqlsrv_rollback(resource $conn){}
/** @return int */ function sqlsrv_rows_affected(resource $stmt){}
/** @return bool */ function sqlsrv_send_stream_data(resource $stmt){}
/** @return array */ function sqlsrv_server_info(resource $conn){}
/** @return float */ function sqrt(float $arg){}
/** @return int */ function ssdeep_fuzzy_compare(string $signature1,string $signature2){}
/** @return string */ function ssdeep_fuzzy_hash_filename(string $file_name){}
/** @return string */ function ssdeep_fuzzy_hash(string $to_hash){}
/** @return bool */ function ssh2_auth_agent(resource $session,string $username){}
/** @return mixed */ function ssh2_auth_none(resource $session,string $username){}
/** @return bool */ function ssh2_auth_password(resource $session,string $username,string $password){}
/** @return resource */ function ssh2_fetch_stream(resource $channel,int $streamid){}
/** @return array */ function ssh2_methods_negotiated(resource $session){}
/** @return resource */ function ssh2_publickey_init(resource $session){}
/** @return array */ function ssh2_publickey_list(resource $pkey){}
/** @return bool */ function ssh2_publickey_remove(resource $pkey,string $algoname,string $blob){}
/** @return bool */ function ssh2_scp_recv(resource $session,string $remote_file,string $local_file){}
/** @return bool */ function ssh2_sftp_chmod(resource $sftp,string $filename,int $mode){}
/** @return array */ function ssh2_sftp_lstat(resource $sftp,string $path){}
/** @return string */ function ssh2_sftp_readlink(resource $sftp,string $link){}
/** @return string */ function ssh2_sftp_realpath(resource $sftp,string $filename){}
/** @return bool */ function ssh2_sftp_rename(resource $sftp,string $from,string $to){}
/** @return resource */ function ssh2_sftp(resource $session){}
/** @return bool */ function ssh2_sftp_rmdir(resource $sftp,string $dirname){}
/** @return array */ function ssh2_sftp_stat(resource $sftp,string $path){}
/** @return bool */ function ssh2_sftp_symlink(resource $sftp,string $target,string $link){}
/** @return bool */ function ssh2_sftp_unlink(resource $sftp,string $filename){}
/** @return resource */ function ssh2_tunnel(resource $session,string $host,int $port){}
/** @return array */ function stat(string $filename){}
/** @return float */ function stats_absolute_deviation(array $a){}
/** @return float */ function stats_cdf_beta(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_binomial(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_cauchy(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_chisquare(float $par1,float $par2,int $which){}
/** @return float */ function stats_cdf_exponential(float $par1,float $par2,int $which){}
/** @return float */ function stats_cdf_f(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_gamma(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_laplace(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_logistic(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_negative_binomial(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_noncentral_chisquare(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_noncentral_f(float $par1,float $par2,float $par3,float $par4,int $which){}
/** @return float */ function stats_cdf_poisson(float $par1,float $par2,int $which){}
/** @return float */ function stats_cdf_t(float $par1,float $par2,int $which){}
/** @return float */ function stats_cdf_uniform(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_cdf_weibull(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_covariance(array $a,array $b){}
/** @return float */ function stats_dens_beta(float $x,float $a,float $b){}
/** @return float */ function stats_dens_cauchy(float $x,float $ave,float $stdev){}
/** @return float */ function stats_dens_chisquare(float $x,float $dfr){}
/** @return float */ function stats_dens_exponential(float $x,float $scale){}
/** @return float */ function stats_dens_f(float $x,float $dfr1,float $dfr2){}
/** @return float */ function stats_dens_gamma(float $x,float $shape,float $scale){}
/** @return float */ function stats_dens_laplace(float $x,float $ave,float $stdev){}
/** @return float */ function stats_dens_logistic(float $x,float $ave,float $stdev){}
/** @return float */ function stats_dens_negative_binomial(float $x,float $n,float $pi){}
/** @return float */ function stats_dens_normal(float $x,float $ave,float $stdev){}
/** @return float */ function stats_dens_pmf_binomial(float $x,float $n,float $pi){}
/** @return float */ function stats_dens_pmf_hypergeometric(float $n1,float $n2,float $N1,float $N2){}
/** @return float */ function stats_dens_pmf_poisson(float $x,float $lb){}
/** @return float */ function stats_dens_t(float $x,float $dfr){}
/** @return float */ function stats_dens_weibull(float $x,float $a,float $b){}
/** @return float */ function stats_den_uniform(float $x,float $a,float $b){}
/** @return number */ function stats_harmonic_mean(array $a){}
/** @return float */ function stats_kurtosis(array $a){}
/** @return float */ function stats_rand_gen_beta(float $a,float $b){}
/** @return float */ function stats_rand_gen_chisquare(float $df){}
/** @return float */ function stats_rand_gen_exponential(float $av){}
/** @return float */ function stats_rand_gen_f(float $dfn,float $dfd){}
/** @return float */ function stats_rand_gen_funiform(float $low,float $high){}
/** @return float */ function stats_rand_gen_gamma(float $a,float $r){}
/** @return int */ function stats_rand_gen_ibinomial(int $n,float $pp){}
/** @return int */ function stats_rand_gen_ibinomial_negative(int $n,float $p){}
/** @return int */ function stats_rand_gen_int(){}
/** @return int */ function stats_rand_gen_ipoisson(float $mu){}
/** @return int */ function stats_rand_gen_iuniform(int $low,int $high){}
/** @return float */ function stats_rand_gen_noncenral_chisquare(float $df,float $xnonc){}
/** @return float */ function stats_rand_gen_noncentral_f(float $dfn,float $dfd,float $xnonc){}
/** @return float */ function stats_rand_gen_noncentral_t(float $df,float $xnonc){}
/** @return float */ function stats_rand_gen_normal(float $av,float $sd){}
/** @return float */ function stats_rand_gen_t(float $df){}
/** @return array */ function stats_rand_get_seeds(){}
/** @return array */ function stats_rand_phrase_to_seeds(string $phrase){}
/** @return float */ function stats_rand_ranf(){}
/** @return void */ function stats_rand_setall(int $iseed1,int $iseed2){}
/** @return float */ function stats_skew(array $a){}
/** @return float */ function stats_stat_binomial_coef(int $x,int $n){}
/** @return float */ function stats_stat_correlation(array $arr1,array $arr2){}
/** @return float */ function stats_stat_gennch(int $n){}
/** @return float */ function stats_stat_independent_t(array $arr1,array $arr2){}
/** @return float */ function stats_stat_innerproduct(array $arr1,array $arr2){}
/** @return float */ function stats_stat_noncentral_t(float $par1,float $par2,float $par3,int $which){}
/** @return float */ function stats_stat_paired_t(array $arr1,array $arr2){}
/** @return float */ function stats_stat_percentile(float $df,float $xnonc){}
/** @return float */ function stats_stat_powersum(array $arr,float $power){}
/** @return string */ function stomp_connect_error(){}
/** @return string */ function stomp_version(){}
/** @return int */ function strcasecmp(string $str1,string $str2){}
/** @return int */ function strcmp(string $str1,string $str2){}
/** @return int */ function strcoll(string $str1,string $str2){}
/** @return void */ function stream_bucket_append(resource $brigade,resource $bucket){}
/** @return object */ function stream_bucket_make_writeable(resource $brigade){}
/** @return object */ function stream_bucket_new(resource $stream,string $buffer){}
/** @return void */ function stream_bucket_prepend(resource $brigade,resource $bucket){}
/** @return array */ function stream_context_get_options(resource $stream_or_context){}
/** @return array */ function stream_context_get_params(resource $stream_or_context){}
/** @return resource */ function stream_context_set_default(array $options){}
/** @return bool */ function stream_context_set_option(resource $stream_or_context,string $wrapper,string $option,mixed $value){}
/** @return bool */ function stream_context_set_params(resource $stream_or_context,array $params){}
/** @return bool */ function stream_filter_register(string $filtername,string $classname){}
/** @return bool */ function stream_filter_remove(resource $stream_filter){}
/** @return array */ function stream_get_filters(){}
/** @return array */ function stream_get_meta_data(int $fp){}
/** @return array */ function stream_get_transports(){}
/** @return array */ function stream_get_wrappers(){}
/** @return bool */ function stream_is_local(mixed $stream_or_url){}
/** @return void */ function stream_notification_callback(int $notification_code,int $severity,string $message,int $message_code,int $bytes_transferred,int $bytes_max){}
/** @return boolean */ function stream_register_wrapper(string $protocol,string $classname){}
/** @return string */ function stream_resolve_include_path(string $filename){}
/** @return bool */ function stream_set_blocking(resource $stream,int $mode){}
/** @return int */ function stream_set_chunk_size(resource $fp,int $chunk_size){}
/** @return int */ function stream_set_read_buffer(resource $stream,int $buffer){}
/** @return int */ function stream_set_write_buffer(resource $stream,int $buffer){}
/** @return string */ function stream_socket_get_name(resource $handle,bool $want_peer){}
/** @return array */ function stream_socket_pair(int $domain,int $type,int $protocol){}
/** @return bool */ function stream_socket_shutdown(resource $stream,int $how){}
/** @return bool */ function stream_supports_lock(resource $stream){}
/** @return bool */ function stream_wrapper_restore(string $protocol){}
/** @return bool */ function stream_wrapper_unregister(string $protocol){}
/** @return string */ function stripcslashes(string $str){}
/** @return string */ function stripslashes(string $str){}
/** @return int */ function strlen(string $string){}
/** @return int */ function strnatcasecmp(string $str1,string $str2){}
/** @return int */ function strnatcmp(string $str1,string $str2){}
/** @return int */ function strncasecmp(string $str1,string $str2,int $len){}
/** @return int */ function strncmp(string $str1,string $str2,int $len){}
/** @return string */ function strpbrk(string $haystack,string $char_list){}
/** @return array */ function strptime(string $date,string $format){}
/** @return string */ function strrchr(string $haystack,mixed $needle){}
/** @return string */ function str_repeat(string $input,int $multiplier){}
/** @return string */ function strrev(string $string){}
/** @return string */ function str_rot13(string $str){}
/** @return string */ function str_shuffle(string $str){}
/** @return string */ function strtok(string $str,string $token){}
/** @return string */ function strtolower(string $str){}
/** @return string */ function strtoupper(string $string){}
/** @return string */ function strtr(string $str,string $from,string $to){}
/** @return string */ function strval(mixed $var){}
/** @return string */ function svn_auth_get_parameter(string $key){}
/** @return void */ function svn_auth_set_parameter(string $key,string $value){}
/** @return bool */ function svn_cleanup(string $workingdir){}
/** @return string */ function svn_client_version(){}
/** @return array */ function svn_diff(string $path1,int $rev1,string $path2,int $rev2){}
/** @return bool */ function svn_fs_abort_txn(resource $txn){}
/** @return resource */ function svn_fs_apply_text(resource $root,string $path){}
/** @return resource */ function svn_fs_begin_txn2(resource $repos,int $rev){}
/** @return bool */ function svn_fs_change_node_prop(resource $root,string $path,string $name,string $value){}
/** @return int */ function svn_fs_check_path(resource $fsroot,string $path){}
/** @return bool */ function svn_fs_contents_changed(resource $root1,string $path1,resource $root2,string $path2){}
/** @return bool */ function svn_fs_copy(resource $from_root,string $from_path,resource $to_root,string $to_path){}
/** @return bool */ function svn_fs_delete(resource $root,string $path){}
/** @return array */ function svn_fs_dir_entries(resource $fsroot,string $path){}
/** @return resource */ function svn_fs_file_contents(resource $fsroot,string $path){}
/** @return int */ function svn_fs_file_length(resource $fsroot,string $path){}
/** @return bool */ function svn_fs_is_dir(resource $root,string $path){}
/** @return bool */ function svn_fs_is_file(resource $root,string $path){}
/** @return bool */ function svn_fs_make_dir(resource $root,string $path){}
/** @return bool */ function svn_fs_make_file(resource $root,string $path){}
/** @return int */ function svn_fs_node_created_rev(resource $fsroot,string $path){}
/** @return string */ function svn_fs_node_prop(resource $fsroot,string $path,string $propname){}
/** @return bool */ function svn_fs_props_changed(resource $root1,string $path1,resource $root2,string $path2){}
/** @return string */ function svn_fs_revision_prop(resource $fs,int $revnum,string $propname){}
/** @return resource */ function svn_fs_revision_root(resource $fs,int $revnum){}
/** @return resource */ function svn_fs_txn_root(resource $txn){}
/** @return int */ function svn_fs_youngest_rev(resource $fs){}
/** @return bool */ function svn_import(string $path,string $url,bool $nonrecursive){}
/** @return resource */ function svn_repos_fs_begin_txn_for_commit(resource $repos,int $rev,string $author,string $log_msg){}
/** @return int */ function svn_repos_fs_commit_txn(resource $txn){}
/** @return resource */ function svn_repos_fs(resource $repos){}
/** @return bool */ function svn_repos_hotcopy(string $repospath,string $destpath,bool $cleanlogs){}
/** @return resource */ function svn_repos_open(string $path){}
/** @return bool */ function svn_repos_recover(string $path){}
/** @return bool */ function sybase_data_seek(resource $result_identifier,int $row_number){}
/** @return void */ function sybase_deadlock_retry_count(int $retry_count){}
/** @return array */ function sybase_fetch_array(resource $result){}
/** @return array */ function sybase_fetch_assoc(resource $result){}
/** @return array */ function sybase_fetch_row(resource $result){}
/** @return bool */ function sybase_field_seek(resource $result,int $field_offset){}
/** @return bool */ function sybase_free_result(resource $result){}
/** @return string */ function sybase_get_last_message(){}
/** @return void */ function sybase_min_client_severity(int $severity){}
/** @return void */ function sybase_min_error_severity(int $severity){}
/** @return void */ function sybase_min_message_severity(int $severity){}
/** @return void */ function sybase_min_server_severity(int $severity){}
/** @return int */ function sybase_num_fields(resource $result){}
/** @return int */ function sybase_num_rows(resource $result){}
/** @return string */ function sybase_result(resource $result,int $row,mixed $field){}
/** @return bool */ function symlink(string $target,string $link){}
/** @return array */ function sys_getloadavg(){}
/** @return string */ function sys_get_temp_dir(){}
/** @return bool */ function syslog(int $priority,string $message){}
/** @return float */ function tan(float $arg){}
/** @return float */ function tanh(float $arg){}
/** @return string */ function tempnam(string $dir,string $prefix){}
/** @return string */ function textdomain(string $text_domain){}
/** @return int */ function tidy_access_count(tidy $object){}
/** @return int */ function tidy_config_count(tidy $object){}
/** @return int */ function tidy_error_count(tidy $object){}
/** @return string */ function tidy_get_output(tidy $object){}
/** @return void */ function tidy_load_config(string $filename,string $encoding){}
/** @return bool */ function tidy_reset_config(){}
/** @return bool */ function tidy_save_config(string $filename){}
/** @return bool */ function tidy_set_encoding(string $encoding){}
/** @return bool */ function tidy_setopt(string $option,mixed $value){}
/** @return int */ function tidy_warning_count(tidy $object){}
/** @return int */ function time(){}
/** @return mixed */ function time_nanosleep(int $seconds,int $nanoseconds){}
/** @return bool */ function time_sleep_until(float $timestamp){}
/** @return string */ function timezone_version_get(){}
/** @return resource */ function tmpfile(){}
/** @return array */ function token_get_all(string $source){}
/** @return string */ function token_name(int $token){}
/** @return array */ function trader_acos(array $real){}
/** @return array */ function trader_ad(array $high,array $low,array $close,array $volume){}
/** @return array */ function trader_add(array $real0,array $real1){}
/** @return array */ function trader_asin(array $real){}
/** @return array */ function trader_atan(array $real){}
/** @return array */ function trader_avgprice(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_bop(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdl2crows(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdl3blackcrows(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdl3inside(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdl3linestrike(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdl3outside(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdl3starsinsouth(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdl3whitesoldiers(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdladvanceblock(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlbelthold(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlbreakaway(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlclosingmarubozu(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlconcealbabyswall(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlcounterattack(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdldoji(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdldojistar(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdldragonflydoji(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlengulfing(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlgapsidesidewhite(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlgravestonedoji(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlhammer(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlhangingman(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlharami(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlharamicross(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlhighwave(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlhikkake(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlhikkakemod(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlhomingpigeon(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlidentical3crows(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlinneck(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlinvertedhammer(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlkicking(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlkickingbylength(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlladderbottom(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdllongleggeddoji(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdllongline(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlmarubozu(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlmatchinglow(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlonneck(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlpiercing(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlrickshawman(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlrisefall3methods(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlseparatinglines(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlshootingstar(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlshortline(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlspinningtop(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlstalledpattern(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlsticksandwich(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdltakuri(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdltasukigap(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlthrusting(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdltristar(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlunique3river(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlupsidegap2crows(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_cdlxsidegap3methods(array $open,array $high,array $low,array $close){}
/** @return array */ function trader_ceil(array $real){}
/** @return array */ function trader_cos(array $real){}
/** @return array */ function trader_cosh(array $real){}
/** @return array */ function trader_div(array $real0,array $real1){}
/** @return integer */ function trader_errno(){}
/** @return array */ function trader_exp(array $real){}
/** @return array */ function trader_floor(array $real){}
/** @return integer */ function trader_get_compat(){}
/** @return integer */ function trader_get_unstable_period(integer $functionId){}
/** @return array */ function trader_ht_dcperiod(array $real){}
/** @return array */ function trader_ht_dcphase(array $real){}
/** @return array */ function trader_ht_phasor(array $real){}
/** @return array */ function trader_ht_sine(array $real){}
/** @return array */ function trader_ht_trendline(array $real){}
/** @return array */ function trader_ht_trendmode(array $real){}
/** @return array */ function trader_ln(array $real){}
/** @return array */ function trader_log10(array $real){}
/** @return array */ function trader_medprice(array $high,array $low){}
/** @return array */ function trader_mult(array $real0,array $real1){}
/** @return array */ function trader_obv(array $real,array $volume){}
/** @return void */ function trader_set_compat(integer $compatId){}
/** @return void */ function trader_set_unstable_period(integer $functionId,integer $timePeriod){}
/** @return array */ function trader_sin(array $real){}
/** @return array */ function trader_sinh(array $real){}
/** @return array */ function trader_sqrt(array $real){}
/** @return array */ function trader_sub(array $real0,array $real1){}
/** @return array */ function trader_tan(array $real){}
/** @return array */ function trader_tanh(array $real){}
/** @return array */ function trader_trange(array $high,array $low,array $close){}
/** @return array */ function trader_typprice(array $high,array $low,array $close){}
/** @return array */ function trader_wclprice(array $high,array $low,array $close){}
/** @return bool */ function uasort(array &$array,callable $cmp_function){}
/** @return string */ function ucfirst(string $str){}
/** @return bool */ function udm_add_search_limit(resource $agent,int $var,string $val){}
/** @return resource */ function udm_alloc_agent_array(array $databases){}
/** @return int */ function udm_api_version(){}
/** @return array */ function udm_cat_list(resource $agent,string $category){}
/** @return array */ function udm_cat_path(resource $agent,string $category){}
/** @return bool */ function udm_check_charset(resource $agent,string $charset){}
/** @return bool */ function udm_clear_search_limits(resource $agent){}
/** @return int */ function udm_crc32(resource $agent,string $str){}
/** @return int */ function udm_errno(resource $agent){}
/** @return string */ function udm_error(resource $agent){}
/** @return resource */ function udm_find(resource $agent,string $query){}
/** @return int */ function udm_free_agent(resource $agent){}
/** @return bool */ function udm_free_ispell_data(int $agent){}
/** @return bool */ function udm_free_res(resource $res){}
/** @return int */ function udm_get_doc_count(resource $agent){}
/** @return string */ function udm_get_res_field(resource $res,int $row,int $field){}
/** @return string */ function udm_get_res_param(resource $res,int $param){}
/** @return int */ function udm_hash32(resource $agent,string $str){}
/** @return bool */ function udm_load_ispell_data(resource $agent,int $var,string $val1,string $val2,int $flag){}
/** @return bool */ function udm_set_agent_param(resource $agent,int $var,string $val){}
/** @return bool */ function uksort(array &$array,callable $cmp_function){}
/** @return array */ function unpack(string $format,string $data){}
/** @return void */ function unregister_tick_function(string $function_name){}
/** @return mixed */ function unserialize(string $str){}
/** @return void */ function uopz_backup(string $class,string $function){}
/** @return Closure */ function uopz_copy(string $class,string $function){}
/** @return void */ function uopz_delete(string $class,string $function){}
/** @return void */ function uopz_extend(string $class,string $parent){}
/** @return int */ function uopz_flags(string $class,string $function,int $flags){}
/** @return void */ function uopz_implement(string $class,string $interface){}
/** @return void */ function uopz_overload(int $opcode,Callable $callable){}
/** @return void */ function uopz_redefine(string $class,string $constant,mixed $value){}
/** @return void */ function uopz_rename(string $class,string $function,string $rename){}
/** @return void */ function uopz_restore(string $class,string $function){}
/** @return void */ function uopz_undefine(string $class,string $constant){}
/** @return string */ function urldecode(string $str){}
/** @return string */ function urlencode(string $str){}
/** @return void */ function usleep(int $micro_seconds){}
/** @return bool */ function usort(array &$array,callable $cmp_function){}
/** @return string */ function utf8_decode(string $data){}
/** @return string */ function utf8_encode(string $data){}
/** @return mixed */ function variant_abs(mixed $val){}
/** @return mixed */ function variant_add(mixed $left,mixed $right){}
/** @return mixed */ function variant_and(mixed $left,mixed $right){}
/** @return variant */ function variant_cast(variant $variant,int $type){}
/** @return mixed */ function variant_cat(mixed $left,mixed $right){}
/** @return variant */ function variant_date_from_timestamp(int $timestamp){}
/** @return int */ function variant_date_to_timestamp(variant $variant){}
/** @return mixed */ function variant_div(mixed $left,mixed $right){}
/** @return mixed */ function variant_eqv(mixed $left,mixed $right){}
/** @return mixed */ function variant_fix(mixed $variant){}
/** @return int */ function variant_get_type(variant $variant){}
/** @return mixed */ function variant_idiv(mixed $left,mixed $right){}
/** @return mixed */ function variant_imp(mixed $left,mixed $right){}
/** @return mixed */ function variant_int(mixed $variant){}
/** @return mixed */ function variant_mod(mixed $left,mixed $right){}
/** @return mixed */ function variant_mul(mixed $left,mixed $right){}
/** @return mixed */ function variant_neg(mixed $variant){}
/** @return mixed */ function variant_not(mixed $variant){}
/** @return mixed */ function variant_or(mixed $left,mixed $right){}
/** @return mixed */ function variant_pow(mixed $left,mixed $right){}
/** @return mixed */ function variant_round(mixed $variant,int $decimals){}
/** @return void */ function variant_set_type(variant $variant,int $type){}
/** @return void */ function variant_set(variant $variant,mixed $value){}
/** @return mixed */ function variant_sub(mixed $left,mixed $right){}
/** @return mixed */ function variant_xor(mixed $left,mixed $right){}
/** @return int */ function vfprintf(resource $handle,string $format,array $args){}
/** @return bool */ function virtual(string $filename){}
/** @return bool */ function vpopmail_add_alias_domain(string $domain,string $aliasdomain){}
/** @return bool */ function vpopmail_add_alias_domain_ex(string $olddomain,string $newdomain){}
/** @return bool */ function vpopmail_add_domain(string $domain,string $dir,int $uid,int $gid){}
/** @return bool */ function vpopmail_alias_add(string $user,string $domain,string $alias){}
/** @return bool */ function vpopmail_alias_del(string $user,string $domain){}
/** @return bool */ function vpopmail_alias_del_domain(string $domain){}
/** @return array */ function vpopmail_alias_get_all(string $domain){}
/** @return array */ function vpopmail_alias_get(string $alias,string $domain){}
/** @return bool */ function vpopmail_del_domain(string $domain){}
/** @return bool */ function vpopmail_del_domain_ex(string $domain){}
/** @return bool */ function vpopmail_del_user(string $user,string $domain){}
/** @return string */ function vpopmail_error(){}
/** @return bool */ function vpopmail_set_user_quota(string $user,string $domain,string $quota){}
/** @return int */ function vprintf(string $format,array $args){}
/** @return string */ function vsprintf(string $format,array $args){}
/** @return mixed */ function wddx_deserialize(string $packet){}
/** @return string */ function wddx_packet_end(resource $packet_id){}
/** @return int */ function win32_get_last_control_message(){}
/** @return array */ function win32_ps_list_procs(){}
/** @return array */ function win32_ps_stat_mem(){}
/** @return mixed */ function win32_start_service_ctrl_dispatcher(string $name){}
/** @return array */ function wincache_fcache_meminfo(){}
/** @return array */ function wincache_ocache_meminfo(){}
/** @return array */ function wincache_rplist_meminfo(){}
/** @return array */ function wincache_scache_meminfo(){}
/** @return bool */ function wincache_ucache_cas(string $key,int $old_value,int $new_value){}
/** @return bool */ function wincache_ucache_clear(){}
/** @return bool */ function wincache_ucache_delete(mixed $key){}
/** @return bool */ function wincache_ucache_exists(string $key){}
/** @return array */ function wincache_ucache_meminfo(){}
/** @return bool */ function wincache_unlock(string $key){}
/** @return bool */ function xdiff_file_bdiff(string $old_file,string $new_file,string $dest){}
/** @return int */ function xdiff_file_bdiff_size(string $file){}
/** @return bool */ function xdiff_file_bpatch(string $file,string $patch,string $dest){}
/** @return bool */ function xdiff_file_diff_binary(string $old_file,string $new_file,string $dest){}
/** @return mixed */ function xdiff_file_merge3(string $old_file,string $new_file1,string $new_file2,string $dest){}
/** @return bool */ function xdiff_file_patch_binary(string $file,string $patch,string $dest){}
/** @return bool */ function xdiff_file_rabdiff(string $old_file,string $new_file,string $dest){}
/** @return int */ function xdiff_string_bdiff_size(string $patch){}
/** @return string */ function xdiff_string_bdiff(string $old_data,string $new_data){}
/** @return string */ function xdiff_string_bdiff(string $old_data,string $new_data){}
/** @return string */ function xdiff_string_bdiff(string $old_data,string $new_data){}
/** @return string */ function xdiff_string_bpatch(string $str,string $patch){}
/** @return string */ function xdiff_string_patch_binary(string $str,string $patch){}
/** @return array */ function xhprof_disable(){}
/** @return array */ function xhprof_sample_disable(){}
/** @return void */ function xhprof_sample_enable(){}
/** @return string */ function xml_error_string(int $code){}
/** @return int */ function xml_get_current_byte_index(resource $parser){}
/** @return int */ function xml_get_current_column_number(resource $parser){}
/** @return int */ function xml_get_current_line_number(resource $parser){}
/** @return int */ function xml_get_error_code(resource $parser){}
/** @return bool */ function xml_parser_free(resource $parser){}
/** @return mixed */ function xml_parser_get_option(resource $parser,int $option){}
/** @return bool */ function xml_parser_set_option(resource $parser,int $option,mixed $value){}
/** @return string */ function xmlrpc_encode(mixed $value){}
/** @return string */ function xmlrpc_get_type(mixed $value){}
/** @return bool */ function xmlrpc_is_fault(array $arg){}
/** @return array */ function xmlrpc_parse_method_descriptions(string $xml){}
/** @return int */ function xmlrpc_server_add_introspection_data(resource $server,array $desc){}
/** @return resource */ function xmlrpc_server_create(){}
/** @return int */ function xmlrpc_server_destroy(resource $server){}
/** @return bool */ function xmlrpc_server_register_introspection_callback(resource $server,string $function){}
/** @return bool */ function xmlrpc_server_register_method(resource $server,string $method_name,string $function){}
/** @return bool */ function xmlrpc_set_type(string &$value,string $type){}
/** @return bool */ function xml_set_character_data_handler(resource $parser,callable $handler){}
/** @return bool */ function xml_set_default_handler(resource $parser,callable $handler){}
/** @return bool */ function xml_set_element_handler(resource $parser,callable $start_element_handler,callable $end_element_handler){}
/** @return bool */ function xml_set_end_namespace_decl_handler(resource $parser,callable $handler){}
/** @return bool */ function xml_set_external_entity_ref_handler(resource $parser,callable $handler){}
/** @return bool */ function xml_set_notation_decl_handler(resource $parser,callable $handler){}
/** @return pool */ function xml_set_object(resource $parser,object &$object){}
/** @return bool */ function xml_set_processing_instruction_handler(resource $parser,callable $handler){}
/** @return bool */ function xml_set_start_namespace_decl_handler(resource $parser,callable $handler){}
/** @return bool */ function xml_set_unparsed_entity_decl_handler(resource $parser,callable $handler){}
/** @return string */ function yaz_addinfo(resource $id){}
/** @return void */ function yaz_ccl_conf(resource $id,array $config){}
/** @return bool */ function yaz_ccl_parse(resource $id,string $query,array &$result){}
/** @return bool */ function yaz_close(resource $id){}
/** @return bool */ function yaz_database(resource $id,string $databases){}
/** @return bool */ function yaz_element(resource $id,string $elementset){}
/** @return int */ function yaz_errno(resource $id){}
/** @return string */ function yaz_error(resource $id){}
/** @return array */ function yaz_es_result(resource $id){}
/** @return void */ function yaz_es(resource $id,string $type,array $args){}
/** @return string */ function yaz_get_option(resource $id,string $name){}
/** @return void */ function yaz_itemorder(resource $id,array $args){}
/** @return bool */ function yaz_present(resource $id){}
/** @return void */ function yaz_range(resource $id,int $start,int $number){}
/** @return string */ function yaz_record(resource $id,int $pos,string $type){}
/** @return void */ function yaz_schema(resource $id,string $schema){}
/** @return bool */ function yaz_search(resource $id,string $type,string $query){}
/** @return void */ function yaz_set_option(resource $id,string $name,string $value){}
/** @return void */ function yaz_sort(resource $id,string $criteria){}
/** @return void */ function yaz_syntax(resource $id,string $syntax){}
/** @return void */ function yp_all(string $domain,string $map,string $callback){}
/** @return array */ function yp_cat(string $domain,string $map){}
/** @return int */ function yp_errno(){}
/** @return string */ function yp_err_string(int $errorcode){}
/** @return array */ function yp_first(string $domain,string $map){}
/** @return string */ function yp_get_default_domain(){}
/** @return string */ function yp_master(string $domain,string $map){}
/** @return string */ function yp_match(string $domain,string $map,string $key){}
/** @return array */ function yp_next(string $domain,string $map,string $key){}
/** @return int */ function yp_order(string $domain,string $map){}
/** @return string */ function zend_logo_guid(){}
/** @return int */ function zend_thread_id(){}
/** @return string */ function zend_version(){}
/** @return void */ function zip_close(resource $zip){}
/** @return bool */ function zip_entry_close(resource $zip_entry){}
/** @return int */ function zip_entry_compressedsize(resource $zip_entry){}
/** @return string */ function zip_entry_compressionmethod(resource $zip_entry){}
/** @return int */ function zip_entry_filesize(resource $zip_entry){}
/** @return string */ function zip_entry_name(resource $zip_entry){}
/** @return resource */ function zip_open(string $filename){}
/** @return resource */ function zip_read(resource $zip){}
/** @return string */ function zlib_get_coding_type(){} 
