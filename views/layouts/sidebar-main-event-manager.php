<?php
echo \hail812\adminlte\widgets\Menu::widget([

    'items' => [
         
        ['label' => 'Dashboard', 'url' => ['site/index'], 'iconStyle' => 'fa', 'icon' => 'chart-pie'],
        ['label' => 'Events', 'url' => ['events/index'], 'iconStyle' => 'fa', 'icon' => 'calendar-plus'],
        ['label' => 'Players / Contestants', 'url' => ['contestants/index'], 'iconStyle' => 'fa', 'icon' => 'user-clock'],
        
    ],
]);
