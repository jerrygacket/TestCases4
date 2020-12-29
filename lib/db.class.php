<?php
class db
{
    private static $_instance = null;

    private $db; // Ресурс работы с БД

    /*
     * Получаем объект для работы с БД
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new db();
        }
        return self::$_instance;
    }

    /*
     * Запрещаем копировать объект
     */
    private function __construct() {
        // Формируем строку соединения с сервером
        $connectString = 'mysql'
            . ':host=' . Config::get('db_host')
            . ';port=' . Config::get('db_port')
            . ';dbname=' . Config::get('db_base')
            . ';charset='. Config::get('db_charset') .';';
        $this->db = new PDO($connectString, Config::get('db_user'), Config::get('db_password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // возвращать ассоциативные массивы
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // возвращать Exception в случае ошибки
            ]
        );
    }

    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}

    public function Query($query, $data = [], $one = false) {

        $q = $this->db->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $q->execute($data);

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            Logger::Write($info[2]);
            return false;
        }

        return $one ? $q->fetch() : $q->fetchAll();
    }

    public function Update($query, $data = []) {

        $q = $this->db->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $q->execute($data);

        if ($q->errorCode() != PDO::ERR_NONE) {
            $info = $q->errorInfo();
            Logger::Write($info[2]);
            return false;
        }

        return $q->rowCount();
    }

    public function Insert($query, $data = []) {

        $q = $this->db->prepare($query);
        $q->execute($data);

        if ($q->errorCode() != PDO::ERR_NONE) {
            return false;
        }

        return $this->db->lastInsertId();
    }
}
?>
