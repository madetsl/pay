<?php

namespace payment\Gateway;

interface Response
{
    public function isSuccess(): bool;
}