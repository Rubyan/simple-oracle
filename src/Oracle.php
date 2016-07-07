<?php namespace Rubyan\Oracle;
 
class Oracle {
 
    private $_connection;
    protected $stid = null;

    public function enabled()
    {
        return function_exists('oci_connect');
    }
    
    public function __construct(array $config) 
    {
        $this->_connection = oci_connect(
            $config['username'], 
            $config['password'], 
            $config['host'] . ":" . $config['port'] . "/" . $config['instance_name'],
            $config['charset']);

        if (!$this->_connection) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }
    
    // query
    public function query($sql) 
    {
        $stid = oci_parse($this->_connection, $sql)  ;
        oci_execute($stid);
        return $stid;
    }
    
 /**
     * Run a SQL or PL/SQL statement
     *
     * Call like:
     *     Db::execute("insert into mytab values (:c1, :c2)",
     *                  [[":c1", $c1, -1],
     *                                      [":c2", $c2, -1]])
     *
     * For returned bind values:
     *     Db::execute("begin :r := myfunc(:p); end",
     *                  [[":r", &$r, 20],
     *                                    [":p", $p, -1]])
     *
     * Note: this performs a commit.
     *
     * @param string $sql The statement to run
     * @param array $bindvars Binds. An array of (bv_name, php_variable, length)
     */
    public function execute($sql, $bindvars = []) {
        $this->stid = oci_parse($this->_connection, $sql);

        foreach ($bindvars as $bv) {
            // oci_bind_by_name(resource, bv_name, php_variable, length)
            oci_bind_by_name($this->stid, $bv[0], $bv[1], $bv[2]);
        }
        //oci_set_action($this->_connection, $action);
        oci_execute($this->stid);              // will auto commit
    }
 
    /**
     * Run a query and return all rows.
     *
     * @param string $sql A query to run and return all rows
     * @param array $bindvars Binds. An array of (bv_name, php_variable, length)
     * @return array An array of rows
     */
    public function execFetchAll($sql, $bindvars = []) {
        $this->execute($sql, $bindvars);
        oci_fetch_all($this->stid, $res, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
        $this->stid = null;  // free the statement resource
        return($res);
    }
    
    // Get oci connection
    public function getConnection() 
    {
        return $this->_connection;
    }
    
    public function __destruct() 
    {
        if ($this->stid) {
            oci_free_statement($this->stid);
        }
        if ($this->_connection) 
        {
            oci_close($this->_connection);
        }
    }
    
}
