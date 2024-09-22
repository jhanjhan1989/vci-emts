<?php
echo \hail812\adminlte\widgets\Menu::widget([

    'items' => [
         
        ['label' => 'Dashboard', 'url' => ['site/index'], 'iconStyle' => 'fa', 'icon' => 'chart-pie'], 
        ['label' => 'LIBRARIES', 'header' => true],

        ['label' => 'Sports / Competitions', 'url' => ['sports/index'], 'iconStyle' => 'fa', 'icon' => 'futbol'],
        ['label' => 'Venues', 'url' => ['venues/index'], 'iconStyle' => 'fa', 'icon' => 'map-marker-alt'],
        ['label' => 'Teams/ Departments', 'url' => ['teams/index'], 'iconStyle' => 'fa', 'icon' => 'users'],
        // ['label' => 'Criteria', 'iconStyle' => 'fa', 'icon' => 'file'], 

    ],
]);
