<?php
/**
 * Created by PhpStorm.
 * User: Zuxriddin
 * Date: 05.07.2018
 * Time: 2:37
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function logging($result) {
    $log_file = fopen(__DIR__."/log_file.txt", "a");
    fwrite($log_file, sprintf("\n--------------------  %s  -------------------\n", date("Y-m-d H:i:s")));
    fwrite($log_file, $result);
    fwrite($log_file, "\n--------------------------------------------------------------\n");
    fclose($log_file);
}

function curl_basic($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    echo $output;
}