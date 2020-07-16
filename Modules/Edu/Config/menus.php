<?php
return [
    [
        'title' => '基本设置',
        'icon' => 'fab fa-app-store-ios',
        'show' => true,
        'items' => [
            ['title' => '内容标签管理', 'permission' => 'tag', 'route' => 'Edu.admin.tag.edit'],
            // ['title' => '直播推流配置', 'permission' => 'live'],
        ],
    ],
    [
        'title' => '课程管理',
        'icon' => 'fas fa-camera',
        'show' => true,
        'items' => [
            ['title' => '课程列表', 'permission' => 'lesson-index', 'route' => 'Edu.admin.lesson.index'],
            ['title' => '发布课程', 'permission' => 'lesson-add', 'route' => 'Edu.admin.lesson.create'],
        ],
    ],
    [
        'title' => '系统课程',
        'icon' => 'fa fa-magnet',
        'show' => true,
        'items' => [
            ['title' => '系统课程列表', 'permission' => 'system-lesson', 'route' => 'Edu.admin.system.index'],
            ['title' => '发布系统课程', 'permission' => 'system-lesson-add', 'route' => 'Edu.admin.system.create'],
        ],
    ],
    [
        'title' => '订阅设置',
        'icon' => 'fa fa-tasks',
        'show' => true,
        'items' => [
            ['title' => '会员周期定价', 'permission' => 'subscribe', 'route' => 'Edu.admin.subscribe.index'],
            ['title' => '订阅订单管理', 'permission' => 'orders'],
        ],
    ],
];