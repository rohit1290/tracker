<?php
echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('tracker:searchip'),
    'name' => 'ip',
    'value' => $vars['ip'] ?? '',
    'placeholder' => elgg_echo('tracker:search:ip'),
    'class' => 'mbm',
]);

echo elgg_view_field([
    '#type' => 'submit',
    'text' => elgg_echo('search'),
]);