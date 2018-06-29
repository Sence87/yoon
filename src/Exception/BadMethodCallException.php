<?php

namespace Yoon\YoonMvp\Exception;

use Yoon\YoonMvp\YoonException;

class BadMethodCallException extends \BadMethodCallException implements YoonException
{
}
