<?php

require 'Instagram.php';
use MetzWeb\Instagram\Instagram;

$instagram = new Instagram('your-api-secret');
$result = $instagram->getUserFollower(user-id);
echo "<pre>";
print_r($result);
echo "</pre>";
?>
