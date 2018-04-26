<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

setcookie("cpuser", "", time()-999);
setcookie("cpauth", "", time()-999);
header("Location: ?page=login");
exit;
?>