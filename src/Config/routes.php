<?php

return [
    '#^product/(\d+)$#' => [
        ['method' => 'GET', 'controller' => 'ProductController', 'action' => 'getProduct'],
        ['method' => 'PUT', 'controller' => 'ProductController', 'action' => 'updateProduct'],
        ['method' => 'PATCH', 'controller' => 'ProductController', 'action' => 'updateProductParam'],
        ['method' => 'DELETE', 'controller' => 'ProductController', 'action' => 'deleteProduct']
    ],

    '#^product$#' => [
        ['method' => 'POST', 'controller' => 'ProductController', 'action' => 'addProduct'],
        ['method' => 'GET', 'controller' => 'ProductController', 'action' => 'getProducts'],
    ],

    '#^product/my$#' => [
        ['method' => 'GET', 'controller' => 'ProductController', 'action' => 'getMyProducts']
    ]
];