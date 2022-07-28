<?php

namespace App\Services;

interface MustHaveTypeDefined
{
    public function getType(): string;
}