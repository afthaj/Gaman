<?php

require_once("../includes/initialize.php");

switch (true) {
    case $_SERVER['REQUEST_URI'] == "/":
        require_once("home.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/index.php":
        header("Location: /");
        break;

    case $_SERVER['REQUEST_URI'] == "/login":
        require_once("login.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/logout":
        require_once("logout.php");
        break;

    case $_SERVER['REQUEST_URI'] == "/test":
        require_once("test.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/user-manual":
        require_once("user_manual.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/survey":
        require_once("survey_info.php");
        break;

    case $_SERVER['REQUEST_URI'] == "/routes":
        require_once("public_list_routes.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/stops":
        require_once("public_list_stops.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/buses":
        require_once("public_list_buses.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/bus-personnel":
        require_once("public_list_bus_personnel.php");
        break;
        
    case $_SERVER['REQUEST_URI'] == "/complaints":
        require_once("public_list_complaints.php");
        break;
    case $_SERVER['REQUEST_URI'] == "/feedback":
        require_once("public_list_feedback_items.php");
        break;

    case $_SERVER['REQUEST_URI'] == "/route/177":
        $_GET['routeid'] = 1;
        require_once("public_read_route.php"); //
        break;

}

?>