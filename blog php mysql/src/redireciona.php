<?php

function redireciona(string $url): void{
    header($url);
    die();
}

?>