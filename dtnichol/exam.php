<?php
$json = '{"item": [
        {"name":"Bill", "id": 2, "school":"SVSU", "clubs":{"A":"VR-DEV", "B":"ACM"}},
        {"name":"Jean", "id": 4, "school":"MSU", "clubs":{"A":"ABC", "B":"DEF"}},
        {"name":"Jon", "id": 6, "school":"GVSU", "clubs":{"A":"XYZ", "B":"PDQ"}},
        {"name":"Tim", "id": 12, "school":"UM", "clubs":{"A":"GHI", "B":"JKL"}},
        {"name":"River", "id": 30, "school":"MYU", "clubs":{"A":"MNO", "B":"TUV"}}
        ]}';
$obj = json_decode ($json);
// put echo statement here
//echo ($obj->item[2]->clubs->[A]);
//echo ($obj[2]->item->clubs->[A]);
//echo ($obj[2]->item->clubs[A]);
//echo ($obj->item[2]->clubs[A]);
echo ($obj->item[2]->clubs->A);
?>