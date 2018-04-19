<?php

namespace payment\Log;

interface Logable
{
    public function toLog(): Log;
}