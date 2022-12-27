<?php
require_once "../env.php";
class Dbc
{
    protected $table_name;
    
    protected function dbConnect() {
            $host = DB_host;
            $db = DB_name;
            $user = DB_user;
            $pass = DB_pass;
        try {

            $option = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
                \PDO::ATTR_EMULATE_PREPARES => false
            );
            $dbh = new \PDO('mysql:charset=UTF8;dbname='.DB_name.';host='.DB_host , DB_user, DB_pass, $option);
            //echo "接続成功";

        } catch(\PDOException $e) {

            // 接続エラーのときエラー内容を取得する
            $error_message[] = $e->getMessage();
            echo "接続失敗";
            exit();
        }
        return $dbh;
    }

    public function getAll() {
        $dbh = $this->dbConnect();
        $sql = "SELECT * FROM $this->table_name";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchall(\PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
    }

    public function getById($id) {
        if(empty($id)) {
            exit('お探しのページは見つかりませんでした');
        }
        
        $dbh = $this->dbConnect();
        
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name Where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if(!$result) {
            exit('お探しのページは見つかりませんでした');
        }
        
        return $result;
    }

    public function delete($id) {
        if(empty($id)) {
            exit('お探しのページは見つかりませんでした');
        }
        
        $dbh = $this->dbConnect();
        
        $stmt = $dbh->prepare("DELETE FROM $this->table_name Where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        
        $stmt->execute();
        echo 'ブログを削除しました';
        //return $result;
    }  
}
?>