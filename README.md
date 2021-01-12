# fc8215b264fe3fcb95fb57cc84cbcf84
REST API To Send Email

>> REQUIREMENT
-- Set GMAIL Security Account : LESS SECURE APP ON
-- Import SQL File world_x_db.sql

>> RUN APPLICATION
$ php -S local.testing:8008 -t api

>> RUN WORKER
$ php worker.php

>> API ENDPOINT : http://local.testing:8008/post

>> This API using GET method because using Github OAuth, access API from your favourite browser.