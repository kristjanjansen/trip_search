<?php
return [
  'host' => env('ELASTICSEARCH_HOST'),
  'indices' => [
    'mappings' => [
      'content' => [
          'properties' => [
            'title' => [
              'type' => 'text',
            ],
          ],
      ],
    ],
    'settings' => [
      'default' => [
        'number_of_shards' => 1,
        'number_of_replicas' => 0,
      ],
    ],
  ],
];
