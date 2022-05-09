<?php

$path = $_SERVER['DOCUMENT_ROOT'] . "/concessionaire/framework/";
include($path . 'module/login/model/DAOLogin.php');
include($path . 'model/middleware_auth.php');
@session_start();

$dao = new DAOLogin();

switch ($_GET['op']) {
    case 'login_view';
        include('module/login/view/login.html');
        break;
    case 'regis_view';
        include('module/login/view/register.html');
        break;
    case 'register';
        $check = validate($_POST['username']);

        if ($check) {
            try {
                $rdo = $dao->insert_user($_POST['username'], $_POST['email'], $_POST['password']);
            } catch (Exception $e) {
                echo json_encode("errora");
                exit;
            }
            if (!$rdo) {
                echo json_encode("errorb");
                exit;
            } else {
                echo json_encode("ok");
                exit;
            }
        } else {
            echo json_encode("errorc");
            exit;
        }
        break;

    case 'login':
        $check = validate($_POST['username']);

        if ($check) {
            echo json_encode("username");
        } else {
            try {
                $dao = new DAOLogin();
                $rdo = $dao->select_user($_POST['username']);
                $token = tokencreate($rdo['username']);
                $_SESSION['username'] = $rdo['username'];
                $_SESSION['tiempo'] = time();
            } catch (Exception $e) {
                echo json_encode("errora");
                exit;
            }
            if (!$rdo) {
                echo json_encode("errorb");
                exit;
            } else {
                if (password_verify($_POST['password'], $rdo['passwd'])) {
                    echo json_encode($token);
                    exit;
                } else {
                    echo json_encode("error_passwd");
                    exit;
                }
            }
        }
        break;


    case 'data_user':
        $jwt = parse_ini_file($path . "model/jwt.ini");
        $secret = $jwt['secret'];
        $token = $_POST['token'];

        $JWT = new JWT;
        $json = $JWT->decode($token, $secret);
        $json = json_decode($json, TRUE);

        $dao = new DAOLogin();
        $rdo = $dao->select_user($json['username']);
        echo json_encode($rdo);
        exit;
        break;

    case 'actividad':
        if (!isset($_SESSION["tiempo"])) {
            echo json_encode("tiempo");
            exit;
        } else {
            if ((time() - $_SESSION["tiempo"]) >= 1800) {
                echo json_encode("inactivo");
                exit;
            } else {
                echo json_encode("activo");
                exit;
            }
        }
        break;

    case 'controluser':
        if (empty($_POST['token'])) {
            echo json_encode("nada");
            exit;
        } else {
            $jwt = parse_ini_file($path . "model/jwt.ini");
            $secret = $jwt['secret'];
            $token = $_POST['token'];

            $JWT = new JWT;
            $json = $JWT->decode($token, $secret);
            $json = json_decode($json, TRUE);
        }

        if (!isset($_SESSION['username'])) {
            echo json_encode('nookay');
            exit;
        } else {
            if ($_SESSION['username'] == $json['username']) {
                echo json_encode('okay');
                exit;
            } else {
                echo json_encode('nookay');
            }
        }
        break;

    case 'logout':
        unset($_SESSION['username']);
        unset($_SESSION['tiempo']);
        session_destroy();
        exit;
        break;

    case 'refresh_token':
        $json = tokendecode($_POST['token']);
        $tokenn = tokencreate($json['username']);
        echo json_encode($tokenn);

        break;
    case 'refresh_cookie':
        session_regenerate_id();
        echo json_encode("sessionregenerate");
        break;

    case 'likeoption':

        if ($_POST['op'] == 'like_select') {
            $json = tokendecode($_POST['token']);

            $dao = new DAOLogin();
            $rdo = $dao->select_like($json['username']);
            echo json_encode($rdo);
            break;
        } else if ($_POST['op'] == 'like') {
            $json = tokendecode($_POST['token']);

            $dao = new DAOLogin();
            $rdo = $dao->like($json['username'], $_POST['idcar']);
            echo json_encode("like");
            break;
        } else if ($_POST['op'] == 'unlike') {
            $json = tokendecode($_POST['token']);

            $dao = new DAOLogin();
            $rdo = $dao->unlike($json['username'], $_POST['idcar']);
            echo json_encode("unlike");
            break;
        }
        break;

    default;
        include('view/inc/error404.html');
        break;
}

function validate($username)
{
    $dao = new DAOLogin();
    $rsl = $dao->select_username($username);

    if (!empty($rsl)) {
        $check = false;
    } else {
        $check = true;
    }
    return $check;
}

// function jsontoken($token)
// {
//     $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/concessionaire/framework/model/jwt.ini");
//     $secret = $jwt['secret'];
//     $token = $_POST['token'];

//     $JWT = new JWT;
//     $json = $JWT->decode($token, $secret);
//     $json = json_decode($json, TRUE);
//     return $json;
// }

// end_switch