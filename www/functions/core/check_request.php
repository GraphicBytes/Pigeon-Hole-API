<?php

//checks for SQL shenanegans in the URL request by making sure only numbers, letter, underscores and dashes are used

function check_request()
{

    $isThisASafeRequest = 1;
    $return = array();

    // get the request
    if (isset($_GET['get1'])) {
        $get1 = $_GET['get1'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get1)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get1 = NULL;
    }

    if (isset($_GET['get2'])) {
        $get2 = $_GET['get2'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get2)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get2 = NULL;
    }

    if (isset($_GET['get3'])) {
        $get3 = $_GET['get3'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get3)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get3 = NULL;
    }

    if (isset($_GET['get4'])) {
        $get4 = $_GET['get4'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get4)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get4 = NULL;
    }

    if (isset($_GET['get5'])) {
        $get5 = $_GET['get5'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get5)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get5 = NULL;
    }

    if (isset($_GET['get6'])) {
        $get6 = $_GET['get6'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get6)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get6 = NULL;
    }

    if (isset($_GET['get7'])) {
        $get7 = $_GET['get7'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get7)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get7 = NULL;
    }

    if (isset($_GET['get8'])) {
        $get8 = $_GET['get8'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get8)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get8 = NULL;
    }

    if (isset($_GET['get9'])) {
        $get9 = $_GET['get9'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get9)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get9 = NULL;
    }

    if (isset($_GET['get10'])) {
        $get10 = $_GET['get10'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get10)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get10 = NULL;
    }

    if (isset($_GET['get11'])) {
        $get11 = $_GET['get11'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get11)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get11 = NULL;
    }

    if (isset($_GET['get12'])) {
        $get12 = $_GET['get12'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get12)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get12 = NULL;
    }

    if (isset($_GET['get13'])) {
        $get13 = $_GET['get13'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get13)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get13 = NULL;
    }

    if (isset($_GET['get14'])) {
        $get14 = $_GET['get14'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get14)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get14 = NULL;
    }

    if (isset($_GET['get15'])) {
        $get15 = $_GET['get15'];
        if (!preg_match('/^[a-z_\-\d]+$/i', $get15)) {
            $isThisASafeRequest = 0;
        }
    } else {
        $get15 = NULL;
    }


    $return['is_this_a_safe_request'] = $isThisASafeRequest;
    $return['get1'] = $get1;
    $return['get2'] = $get2;
    $return['get3'] = $get3;
    $return['get4'] = $get4;
    $return['get5'] = $get5;
    $return['get6'] = $get6;
    $return['get7'] = $get7;
    $return['get8'] = $get8;
    $return['get9'] = $get9;
    $return['get10'] = $get10;
    $return['get11'] = $get11;
    $return['get12'] = $get12;
    $return['get13'] = $get13;
    $return['get14'] = $get14;
    $return['get15'] = $get15;

    return $return;
}
