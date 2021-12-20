<?php

require_once "./config/APP.php";
require_once "./controllers/viewController.php";

$template = new viewController();
$template->obtain_template_controller();
