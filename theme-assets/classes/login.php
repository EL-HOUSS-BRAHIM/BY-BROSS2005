<?php
class Login extends Dph {

    protected function getUser($uid, $pwd) {
        $stmt = $this->connect()->prepare('SELECT users_uid, users_pwd FROM users WHERE users_uid = ? OR users_email = ?;');
        if(!$stmt->execute(array($uid, $uid))) {
            $stmt = null;
            header("location: ../../login.php?error=stmtfailed");
            exit();
        }
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($pwdHashed) == 0) {
            $stmt = null;
            header("location: ../../login.php?error=usernotfound");
            exit();
        }
        $checkPwd = password_verify($pwd, $pwdHashed[0]["users_pwd"]);

        if($checkPwd == false) 
        {
            $stmt = null;
            header("location: ../../login.php?error=wrongpassword");
            exit();
        } 
        elseif ($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE users_uid = ? OR users_email = ? AND users_pwd = ?;');

            if(!$stmt->execute(array($uid, $uid, $pwdHashed[0]["users_pwd"]))) {
                $stmt = null;
                header("location: ../../login.php?error=stmtfailed");
                exit();
            }
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($user) == 0) 
            {
                $stmt = null;
                header("location: ../../login.php?error=usernotfound");
                exit();
            }
            session_start();
            $_SESSION['userid'] = $user[0]["users_id"];
            $_SESSION['useruid'] = $user[0]["users_uid"];
            $stmt = null;
        }
    }
}