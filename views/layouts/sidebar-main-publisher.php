<?php
echo \hail812\adminlte\widgets\Menu::widget([

    'items' => [
         
        ['label' => 'Dashboard', 'url' => ['site/index'], 'iconStyle' => 'fa', 'icon' => 'chart-pie'],
        ['label' => 'Publish Results', 'url' => ['sports/index'], 'iconStyle' => 'fa', 'icon' => 'upload'], 

    ],
]);
