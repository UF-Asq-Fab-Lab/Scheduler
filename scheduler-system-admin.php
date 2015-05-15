<?php
$scheduler = wire('modules')->get("SchedulerSystem");
echo $scheduler->getTableInterface();
?>