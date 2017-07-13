<?php


$json = file_get_contents('places/all_wales.json');

$data = json_decode($json, true);

echo '<ul>';
foreach ($data['cymru'] as $key => $val) {
    echo '<li><a target="_blank" href="view.php?place=' . $val['geoJson'] . '">' . $val['name'] . ' ' . getNumbers($val['geoJson']) . ' places</a></li>';
    
    echo '<ul>';
    echo '<li><strong>Communities</strong></li>';
    foreach ($val['communities'] as $keycommunities => $valuecommunities) {
        echo '<li><a target="_blank" href="view.php?place=' . $valuecommunities['geoJson'] . '">' . $valuecommunities['name'] . '</a></li>';
    }
    echo '</ul>';
    
    // echo '<ul>';
    // echo '<li><strong>electoral_ward</strong></li>';
    // foreach ($val['electoral_ward'] as $keyelectoral_ward => $valueelectoral_ward) {
    //   echo '<li><a target="_blank" href="view.php?place='.$valueelectoral_ward['geoJson'].'">'.$valueelectoral_ward['name']. '</a></li>';
    // }
    // echo '</ul>';
    
}
echo '</ul>';