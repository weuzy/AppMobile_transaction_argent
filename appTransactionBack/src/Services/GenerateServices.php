<?php


namespace App\Services;


class GenerateServices
{
    public function generateCodeTransaction() {
        return substr(md5(time()), 0, 7);
    }
}
