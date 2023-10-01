<?php

require_once('vendor/autoload.php');

use \Proloweb\WebformClient\App;
use \Proloweb\WebformClient\Webform;

App::instantiate();

// crmInstanceId must be defined into your .env file
// if you don't have your instance id, please contact your crm administrator.
$crmInstanceId = App::getEnv('CRM_INSTANCE_ID');

$webform = new Webform($crmInstanceId);
$webform->init();

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $webform->showTitle(); ?></title>
    <meta charset="utf-8">
    <script type="text/javascript" src="assets/jquery.min.js"></script>

    <link href="assets/style.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" src="assets/webform.jquery.min.js"></script>
    <script type="text/javascript" src="assets/webform.js"></script>

    <?php
    if ($webform->hasForm()) {
        $jsonData = $webform->getJsonData();
        ?>
    <script type="text/javascript">
        Webform.show(<?= $jsonData; ?>, function(data) {
            $.ajax({
                type: 'POST',
                url: 'index.php?slug=<?= $webform->getSlug(); ?>',
                data,
                dataType: 'json'
            })
        })
    </script>
        <?php
    }
    ?>
</head>
<body>
<div id="webformContainer"></div>
</body>
</html>
