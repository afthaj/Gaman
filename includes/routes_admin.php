<?php

switch ($_SERVER['REQUEST_URI']) {
    
    case "/admin":
        require_once("admin_home.php");
        break;
    case "/admin/index.php":
        header("Location: /admin");
        break;
    
    case "/admin/login":
        require_once("./login.php");
        break;
    case "/admin/logout":
        require_once("./logout.php");
        break;

    case "/test":
        require_once("test.php");
        break;
    case "/user-manual":
        require_once("user_manual.php");
        break;
    case "/survey":
        require_once("survey_info.php");
        break;

    case "/routes":
        require_once("public_list_routes.php");
        break;
    case "/stops":
        require_once("public_list_stops.php");
        break;
    case "/buses":
        require_once("public_list_buses.php");
        break;
    case "/bus-personnel":
        require_once("public_list_bus_personnel.php");
        break;
        
    case "/complaints":
        require_once("public_list_complaints.php");
        break;
    case "/feedback":
        require_once("public_list_feedback_items.php");
        break;

    case "/route/177":
        $_GET['routeid'] = 1;
        require_once("public_read_route.php"); //
        break;
}

?>