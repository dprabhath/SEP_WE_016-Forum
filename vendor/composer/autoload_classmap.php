<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'BaseController' => $baseDir . '/app/controllers/BaseController.php',
    'CreateForumCategoriesTable' => $baseDir . '/app/database/migrations/2016_03_07_113347_create_forum_categories_table.php',
    'CreateForumCommentsTable' => $baseDir . '/app/database/migrations/2016_03_07_113742_create_forum_comments_table.php',
    'CreateForumGroupsTable' => $baseDir . '/app/database/migrations/2016_03_07_113251_create_forum_groups_table.php',
    'CreateForumThreadsTable' => $baseDir . '/app/database/migrations/2016_03_07_113511_create_forum_threads_table.php',
    'CreateUsersTable' => $baseDir . '/app/database/migrations/2016_03_07_112944_create_users_table.php',
    'DatabaseSeeder' => $baseDir . '/app/database/seeds/DatabaseSeeder.php',
    'ForumCategory' => $baseDir . '/app/models/ForumCategory.php',
    'ForumComment' => $baseDir . '/app/models/ForumComment.php',
    'ForumController' => $baseDir . '/app/controllers/ForumController.php',
    'ForumGroup' => $baseDir . '/app/models/ForumGroup.php',
    'ForumTableSeeder' => $baseDir . '/app/database/seeds/ForumTableSeeder.php',
    'ForumThread' => $baseDir . '/app/models/ForumThread.php',
    'HomeController' => $baseDir . '/app/controllers/HomeController.php',
    'IlluminateQueueClosure' => $vendorDir . '/laravel/framework/src/Illuminate/Queue/IlluminateQueueClosure.php',
    'Normalizer' => $vendorDir . '/patchwork/utf8/src/Normalizer.php',
    'SessionHandlerInterface' => $vendorDir . '/symfony/http-foundation/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php',
    'TestCase' => $baseDir . '/app/tests/TestCase.php',
    'User' => $baseDir . '/app/models/User.php',
    'UserController' => $baseDir . '/app/controllers/UserController.php',
    'Whoops\\Module' => $vendorDir . '/filp/whoops/src/deprecated/Zend/Module.php',
    'Whoops\\Provider\\Zend\\ExceptionStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/ExceptionStrategy.php',
    'Whoops\\Provider\\Zend\\RouteNotFoundStrategy' => $vendorDir . '/filp/whoops/src/deprecated/Zend/RouteNotFoundStrategy.php',
);
