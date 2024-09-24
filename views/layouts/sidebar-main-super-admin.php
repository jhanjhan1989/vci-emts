<?php
echo \hail812\adminlte\widgets\Menu::widget([

    'items' => [
         
        ['label' => 'Dashboard', 'url' => ['site/index'], 'iconStyle' => 'fa', 'icon' => 'chart-pie'],
        ['label' => 'Events', 'url' => ['events/index'], 'iconStyle' => 'fa', 'icon' => 'calendar-plus'],
        ['label' => 'Score Card', 'url' => ['event-sports/index'], 'iconStyle' => 'fa', 'icon' => 'star'],
        ['label' => 'Players / Contestants', 'url' => ['contestants/index'], 'iconStyle' => 'fa', 'icon' => 'user-clock'],

        ['label' => 'LIBRARIES', 'header' => true],

        ['label' => 'Sports / Competitions', 'url' => ['sports/index'], 'iconStyle' => 'fa', 'icon' => 'futbol'],
        ['label' => 'Venues', 'url' => ['venues/index'], 'iconStyle' => 'fa', 'icon' => 'map-marker-alt'],
        ['label' => 'Teams/ Departments', 'url' => ['teams/index'], 'iconStyle' => 'fa', 'icon' => 'users'],
        // ['label' => 'Criteria', 'iconStyle' => 'fa', 'icon' => 'file'], 

        ['label' => 'SETTINGS', 'header' => true],
        ['label' => 'Publish Results', 'url' => ['event-sports/index'], 'iconStyle' => 'fa', 'icon' => 'upload'],
        ['label' => 'User Accounts', 'url' => ['member/index'], 'iconStyle' => 'fa', 'icon' => 'users-cog'],

    ],
]);
