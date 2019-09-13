<?php

return [
  'multibite_replacement_character' => [
    'name'        => 'multibite_replacement_character',
    'type'        => 'String',
    'default'     => '�',
    'html_type'   => 'text',
    'add'         => '4.7',
    'title'       => ts('Mailbite Replacement Character'),
    'is_domain'   => 1,
    'is_contact'  => 0,
    'description' => ts('Replacement character used in place of unsupported multi-byte characters.'),
  ],
];
