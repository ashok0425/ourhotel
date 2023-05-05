<?php

if (! function_exists('getImage')) {
function getImage($file){
return asset('storage/uploads/'.$file);
}
}