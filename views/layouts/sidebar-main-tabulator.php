<?php
echo \hail812\adminlte\widgets\Menu::widget([

    'items' => [
         
        ['label' => 'Dashboard', 'url' => ['site/index'], 'iconStyle' => 'fa', 'icon' => 'chart-pie'], 
        ['label' => 'Score Card', 'url' => ['event-sports/index'], 'iconStyle' => 'fa', 'icon' => 'star'],
        
    ],
]);
