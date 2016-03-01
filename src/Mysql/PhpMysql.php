<?php
/**
 * Mysql单例模型
 * Mysql连接
 *
 * @author by wangqiang <wangqiang@e.hunantv.com>
 */
namespace PhpDb\Mysql;

/**
 * Mysql连接
 *
 * PhpDb\Mysql\PhpMysql
 * PhpDb\Mysql\PhpMysql::getInstance()->connect($config)
 */
class PhpMysql
{
    private $_dsns = array();
    private static $_instance = null; 

    /**
     * 构造函数
     */
    private function __construct()
    {
        //pass
    }

    /**
     * 单列模式
     *
     * @return PhpDb\Mysql\Connect
     */
    public static function getInstance()
    {
        if (!is_null(self::$_instance)) {
            return self::$_instance;
        }

        self::$_instance = new self();
        return self::$_instance;
    }
    /**
     * 连接Mysql
     *
     * @param array  $config 
     * array('host'=>'', 'dbName'=>'', 'user'=>'','pass'=>'')
     *
     * @return \PDO
     */
    public function connect(array $config = array())
    {
        $dsn = "mysql:dbname={$config['dbName']};host={$config['host']}";
        $md5 = md5($dsn);

        $attributes = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
        if (!empty($config['attributes'])) {
            $attributes = array_merge($attributes, $config['attributes']);
        }

        if (empty($this->_dsns[$md5])) {
            $this->_dsns[$md5] = new \PDO($dsn, $config['user'], $config['pass'], $attributes);
        }

        return $this->_dsns[$md5];
    }
}


