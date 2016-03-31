<?php
/**
 * PDO单例模型
 * PDO连接
 *
 * @author by wangqiang <wangqiang@e.hunantv.com>
 */
namespace PhpDb\Pdo;

/**
 * Pdo连接
 *
 * PhpDb\Pdo\PhpPdo
 * PhpDb\Pdo\PhpPdo::getInstance()->connect($config)
 */
class PhpPdo
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
     * 连接Pdo Mysql pgsql
     *
     * @param array  $config 
     * array('host'=>'', 'dbName'=>'', 'user'=>'','pass'=>'')
     * @param string $driver mysql, pgsql
     *
     * @return \PDO
     */
    public function connect(array $config = array(), $driver='mysql')
    {
        $dsn = "{$driver}:dbname={$config['dbName']};host={$config['host']}";
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


