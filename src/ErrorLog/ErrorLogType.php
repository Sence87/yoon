<?php

namespace Yoon\YoonMvp\ErrorLog;


abstract class ErrorLogType {
    const Captcha = 'Captcha';
    const Database = 'Database';
    const Rest = 'REST API';
    const Logical = 'Logical';
    const Unexpected = 'Unexpected';
}

?>