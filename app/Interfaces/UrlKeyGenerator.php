<?php

namespace App\Interfaces;

interface UrlKeyGenerator
{
    //
    public function generateRandom(): string; 

    public function generateKeyUsing(int $seed = null): string;
}
