<?php
function clean( $str ){
    return strip_tags(stripslashes(mysql_real_escape_string( $str ) ) );
}

class DB 
{
    var $_dbConn = 0;
    var $_queryResource = 0;
    
    function DB()
    {
        require('config.php');
        $this->connect_db(  $_db['dbhost'], $_db['dbuser'] ,$_db['dbpass'], $_db['dbname']);
        //do nothing
    }
    
    function connect_db($host, $user, $pwd, $dbname)
    {
        //echo sprintf( "%s<br>%s<br>%s<br>%s<br>", $host, $user, $pwd, $dbname );
        $dbConn = mysql_connect($host, $user, $pwd);
        if (! $dbConn)
            die ("MySQL Connect Error");
        mysql_query("SET NAMES utf8");
        if (! mysql_select_db($dbname, $dbConn))
            die ("MySQL Select DB Error");
        $this->_dbConn = $dbConn;
        return true;
    }
    function close(){
        if( !isset( $this->_dbConn ) || !$this->_dbConn) die( "Did not connect to sql server.");

        mysql_close( $this->_dbConn );
    }
    
    function query($sql)
    {
        print_r( $sql );
        echo "<br>";
        if (! $queryResource = mysql_query($sql, $this->_dbConn) ){
            return null; 
        }
        $this->_queryResource = $queryResource;
        return $queryResource;        
    }
    
    function fetch_object()
    {   
        return mysql_fetch_object( $this->_queryResource );
    }

    /** Get array return by MySQL */
    function fetch_array()
    {
        return mysql_fetch_array($this->_queryResource, MYSQL_ASSOC);
    }
    
    function get_num_rows()
    {
        return mysql_num_rows($this->_queryResource);
    }

    /** Get the cuurent id */    
    function get_insert_id()
    {
        return mysql_insert_id($this->_dbConn);
    } 
    
}

    function create_table( $db, $tablename  ,$schema, $key_id  ){
        $sql = "";
        $tmp = Array();
        foreach( $schema as $row_schema ){
            $row_name = $row_schema[0];
            $row_type = $row_schema[1];
            $tmp[] = sprintf("%s %s", $row_name, $row_type );
        }
        if( !is_null($key_id) ){
            $sql = sprintf( "CREATE TABLE IF NOT EXISTS %s (%s, PRIMARY KEY(%s)) ", $tablename, join(", ", $tmp ) , $key_id );
        }else{
            $sql = sprintf( "CREATE TABLE IF NOT EXISTS %s (%s)  ", $tablename, join(", ", $tmp )  );
        }
        if( is_null($db->query( $sql )) ){ die("SQL Error.") ; }
        
    }

    class User{
        var $_name = null  ;
        var $_password = null; // hashed password by md5
        var $_department = null;
        var $_user_id = null;
        function setName( $name ){ $this->_name = $name ; }
        function setPassword( $password ){ $this->_password = $password;}
        function setDepartment( $department ){ $this->_department = $department; }
        function setUserId( $user_id ){ $this->_user_id = $user_id ;}
        function getName( ){
            if( !isset( $this->_name )){
                return null;
            }
            return $this->_name ;
        }
        function getPassword( ){
            if( !isset( $this->_password )){
                return null;
            }
            return $this->_password ;
        }
        function getDepartment(){
            if( !isset( $this->_department )){
                return null;
            }
            return $this->_department ;
        }
        function getUserId(){
            if( !isset( $this->_user_id )){
                return null;
            }
            return $this->_user_id ;
        }
    }

    class UserDAO extends DB
    {
        function getUserByName( $name ){
            $sql = sprintf("SELECT name, password FROM users WHERE name = '%s'" ,  clean( $name )  );
            $this->query( $sql );
            $tmpUser = $this->fetch_object();
            if( $tmpUser == null ){ return null; }

            $retUser = new User();
            $retUser->setName( $tmpUser->name );
            $retUser->setPassword( $tmpUser->password);
            $retUser->setDepartment( $tmpUser->department );
            $retUser->setUserId( $tmpUser->user_id );
            return $retUser;
        }

        function insertUser( $user){
            $sql = sprintf("INSERT INTO users (name, password, department) VALUES ( '%s', '%s', '%s')", 
                            clean( $user->getName() ), 
                            clean( $user->getPassword() ),
                            clean( $user->getDepartment() ) );
            $this->query( $sql );
            return $this->get_insert_id();
        }
    }

    class Option{
        var $_option_id = null;
        var $_img_filename = null;
        var $_descrption = null;
        var $_poll_id = null; 
        var $_rank = null;
        function getOptionId(){ return $this->_option_id; }
        function setOptionId( $option_id ){ $this->_option_id = $option_id;}
        function getImgFilename(){ return $this->_img_filename; }
        function setImgFilename( $img_filename ){ $this->_img_filename = $img_filename;}       
        function getDescription(){ return $this->_descrption; }
        function setDescription( $description ){ $this->_descrption = $description; }
        function getPollId(){ return $this->_poll_id; }
        function setPollId( $poll_id ){ $this->_poll_id = $poll_id;}
        function getRank(){ return $this->_rank; }
        function setRank( $rank ) { $this->_rank = $rank;} 
    }

    class OptionDAO extends DB {
        function getOptionByPollId( $poll_id ){
            $sql = sprintf("SELECT * FROM options WHERE poll_id = %d ORDER BY rank", clean( $user_id )); 
            $ret = Array();
            $this->query( $sql );
            while( ($tmp_option = $this->fetch_object()) != null ){
                $option = new Poll();
                $option->setOptionId( $tmp_option->poll_id );
                $option->setImgFilename( $tmp_option->img_filename);
                $option->setDescription( $tmp_option->description );
                $option->setPollId( $tmp_option->poll_id );
                $option->setRank( $tmp_option->rank);
                $ret[] = $option ; 
            }
            return $ret ;
        }
    }


    class Poll{
        var $_poll_id = null;
        var $_title = null;
        var $_descrption = null; 
        var $_department = null;
        var $_start_date =null;
        var $_due_date = null;
        var $_user_id = null;
        var $_choice = null; 
        var $_img_filename = null;
        var $_options = null; 
        function getPollId( ){ return $this->_poll_id; }
        function setPollId( $poll_id ){ $this->_poll_id = $poll_id ; }
        function getTitle( ){ return $this->_title; }
        function setTitle( $title ){ $this->_title = $title; }
        function getDescription( ){ return $this->_descrption; }
        function setDescription( $description ){ $this->_descrption = $description ;}
        function getDepartment( ){ return $this->_department;}
        function setDepartment( $department ){ $this->_department = $department; }
        function getStartDate( ){ return $this->_start_date;}
        function setStartDate( $start_date ){ $this->_start_date = $start_date ;}
        function getDueDate( ) {return $this->_due_date;}
        function setDueDate( $due_date ){ $this->_due_date = $due_date;}
        function getUserId(){ return $this->_user_id;}
        function setUserId( $user_id ){ $this->_user_id = $user_id;}
        function getImgFilename( ){ return $this->_img_filename; }
        function setImgFilename( $img_filename ){ $this->_img_filename = $img_filename; }
        function getOptions( ){ return $this->_options;}
        function setOptions( $options }{ $this->_options = $options ; }
    }

    class PollDAO extends DB {
        function getPollByUserId( $user_id ){
            $sql = sprintf("SELECT * FROM polls WHERE user_id = '%s' ORDER BY due_date DESC", clean( $user_id )); 
            $ret = Array();
            $this->query( $sql );

            $optionDao = new OptionDAO(); 
            
            while( ($tmp_poll = $this->fetch_object()) != null ){
                $poll = new Poll();
                $poll->setPollId( $tmp_poll->poll_id );
                $poll->setTitle( $tmp_poll->title );
                $poll->setDepartment( $tmp_poll->department);
                $poll->setStartDate( $tmp_poll->start_date );
                $poll->setDueDate( $tmp_poll->due_date);
                $poll->setUserId( $tmp_poll->user_id);
                $poll->setImgFilename( $tmp_poll->img_filename );
                $poll->setOptions( $optionDao->getOptionByPollId( $poll->getPollId()) );
                $ret[] = $poll ; 
            }
            return $ret ;
        }
        function insertPoll( $poll ){
            $sql = sprintf("INSERT INTO polls (name, password, department) VALUES ( '%s', '%s', '%s')", 
                            clean( $user->getName() ), 
                            clean( $user->getPassword() ),
                            clean( $user->getDepartment() ) );
            $this->query( $sql );
            return $this->get_insert_id();

        }
    }



?>