<?php

$queryRes = 0; //assuming this returns 1 or 0
if($queryRes == 0) {
    echo "<a href='enable_member.php?enab=". urlencode($result['member_id'])."' class=\"button-small blue text_upper round\">Enable</a>";
} else {
    echo "<a href='disable_member.php?deac=" . urlencode($result['member_id'])."' class=\"button-small blue text_upper round\">Deactivate</a>";
}







 ?>
