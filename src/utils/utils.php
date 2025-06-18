<?php

date_default_timezone_set('America/Sao_Paulo');

function getDatetime() {
    $now = new \DateTime();
    
    return $now->format('Y-m-d H:i:s');
}