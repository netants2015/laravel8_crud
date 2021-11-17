<?php
function changeDateFormate($date,$date_format){
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function print_rr($data, $exit = true)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}
