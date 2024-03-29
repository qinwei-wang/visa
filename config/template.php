<?php
/**
 * Created by PhpStorm.
 * User: patpat
 * Date: 2019/5/3
 * Time: 13:56
 */



return [
    'menus' => [
        [
            'roles' => '*',
            'is_open' => false,
            'icon' => 'fa fa-gear',
            'site' => '*',
            'title' => '基础配置',
            'menus' => [

                [
                    'icon' => 'fa fa-fire',
                    'title' => 'banner',
                    'site' => '*',
                    'link' => '/base-config/banner',
                    'roles' => '*',
                    'is_active' => false,
                ],
                [
                    'icon' => 'fa fa-fire',
                    'title' => '签证类型',
                    'site' => '*',
                    'link' => '/base-config/visa_type',
                    'roles' => '*',
                    'is_active' => false,
                ],
                [
                    'icon' => 'fa fa-fire',
                    'title' => '适用人群',
                    'site' => '*',
                    'link' => '/base-config/user_type',
                    'roles' => '*',
                    'is_active' => false,
                ],
                [
                    'icon' => 'fa fa-fire',
                    'title' => '申请条件',
                    'site' => '*',
                    'link' => '/base-config/apply_condition',
                    'roles' => '*',
                    'is_active' => false,
                ],
                [
                    'icon' => 'fa fa-fire',
                    'title' => '标签',
                    'site' => '*',
                    'link' => '/base-config/tag',
                    'roles' => '*',
                    'is_active' => false,
                ],
                [
                    'icon' => 'fa fa-fire',
                    'title' => '国家列表',
                    'site' => '*',
                    'link' => '/base-config/country',
                    'roles' => '*',
                    'is_active' => false,
                ],

            ]
        ],
        [
            'roles' => '*',
            'is_open' => false,
            'icon' => 'fa fa-gear',
            'site' => '*',
            'title' => '客户管理',
            'menus' => [

                [
                    'icon' => 'fa fa-fire',
                    'title' => '咨询客户',
                    'site' => '*',
                    'link' => '/customers',
                    'roles' => '*',
                    'is_active' => false,
                ],

            ]
        ],
        [
            'roles' => '*',
            'is_open' => false,
            'icon' => 'fa fa-gear',
            'site' => '*',
            'title' => '新闻管理',
            'menus' => [

                [
                    'icon' => 'fa fa-fire',
                    'title' => '新闻',
                    'site' => '*',
                    'link' => '/news',
                    'roles' => '*',
                    'is_active' => false,
                ],

            ]
        ]
    ]
];



