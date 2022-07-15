<?php

namespace App\Library\HtmlHandler;

use League\Pipeline\StageInterface;
use App\Library\StringHelper;

class ReplaceBareLineFeed implements StageInterface
{
    public function __invoke($html)
    {
        return StringHelper::replaceBareLineFeed($html);
    }
}
