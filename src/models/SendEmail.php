<?php

require_once "../config/koneksi.php";

class SendEmail {
    public function getList() {
        global $dbconn;
        $sql = "SELECT * FROM send_emails";
        $result = pg_query($sql);
        
        $data = [];
        while($row = pg_fetch_object($result)) {
            $data[] = $row;
            
        }

        return $data;
    }

    public function find($id=0) {
        global $dbconn;

        $sql = "SELECT * FROM send_emails where id = $id";
        $result = pg_query($sql);

        $data = [];
        while($row = pg_fetch_object($result)) {
            $data[] = $row;
            
        }

        return $data;
    }

    public function save($post=array()) {
        global $dbconn;
        $result = pg_query($dbconn, "INSERT INTO send_emails (message, email, user_id) VALUES (
                                    '".$post['message']."', '".$post['email']."', ".$post['user_id'].")");

        return $result;
    }

    public function update($post=array(), $id=0) {
        global $dbconn;
        $result = pg_query($dbconn, "UPDATE send_emails SET message='".$post['message']."', 
                                email='".$post['email']."', user_id=".$post['user_id']." where id = ".$id);

        return $result;
    }

    public function delete($id=0) {
        global $dbconn;

        $sql = "DELETE FROM send_emails where id = $id";
        $result = pg_query($sql);

        return $result;
    }
}