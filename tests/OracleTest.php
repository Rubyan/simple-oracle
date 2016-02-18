<?php
 
use Rubyan\Oracle\Oracle;
 
class OracleTest extends PHPUnit_Framework_TestCase {
 
    public function testInit()
    {
        $config['host'] = 'localhost';
        $config['username'] = 'demo';
        $config['password'] = 'demo';
        $config['port'] = 1521;
        $config['instance_name'] = 'xe';
        $config['charset'] = 'UTF8';
        
        // The user should log in
        $db = new Oracle($config);
        $this->assertTrue($db->enabled());
        
        // simple query
        $sql = "SELECT * FROM HR.JOBS WHERE JOB_ID = 'AD_PRES'";
        $stid = $db->query($sql);
        
        oci_fetch_all($stid, $res);
        $this->assertNotEmpty($res);
        
    }
    
    public function testExecute() {
        $config['host'] = 'localhost';
        $config['username'] = 'demo';
        $config['password'] = 'demo';
        $config['port'] = 1521;
        $config['instance_name'] = 'xe';
        $config['charset'] = 'UTF8';
        
        $db = new Oracle($config);   
        $sql = 'SELECT * FROM HR.JOBS';
        $db->execute($sql);
    }
    
    public function testExecuteWithBind() {
        $config['host'] = 'localhost';
        $config['username'] = 'demo';
        $config['password'] = 'demo';
        $config['port'] = 1521;
        $config['instance_name'] = 'xe';
        $config['charset'] = 'UTF8';
        
        // The user should log in
        $db = new Oracle($config);   
        
        $c1 = 'AD_PRES';
        $sql = 'SELECT * FROM HR.JOBS WHERE JOB_ID = :c1';
        
        $db->execute($sql, [[":c1", $c1, -1]]);
    }

    public function testExecFetchAll() {
        $config['host'] = 'localhost';
        $config['username'] = 'demo';
        $config['password'] = 'demo';
        $config['port'] = 1521;
        $config['instance_name'] = 'xe';
        $config['charset'] = 'UTF8';
        
        // The user should log in
        $db = new Oracle($config);   
        
        $c1 = 'AD_PRES';
        $sql = 'SELECT * FROM HR.JOBS WHERE JOB_ID = :c1';
        
        $res = $db->execFetchAll($sql, [[":c1", $c1, -1]]);
        $this->assertNotEmpty($res);
    }
}