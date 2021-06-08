<?php
/**
 *BlogPackagesServiceProvider
 * @author tan bing
 * @date 2021-06-03 9:40
 */

namespace Tanbing\BlogPackage;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Tanbing\BlogPackage\Console\InstallBlogPackage;
use Tanbing\BlogPackage\Console\MakeFooCommand;
use Tanbing\BlogPackage\Http\Middleware\CapitalizeTitle;
use Tanbing\BlogPackage\Providers\EventServiceProvider;

class BlogPackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('calculator', function ($app) {
            return new Calculator();
        });
//        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'blogpackage');

        // 注册事件服务提供者
        $this->app->register(EventServiceProvider::class);
    }

    public function boot()
    {
        // Register the command if we are using the application via the CLI
        if($this->app->runningInConsole()) {
            //================================注册命令==========================================================
            $this->commands([
                InstallBlogPackage::class,
                MakeFooCommand::class,
            ]);
            //================================注册命令==========================================================

            //================================发布配置文件==========================================================
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('blogpackage.php')
            ], 'config');
            //================================发布配置文件==========================================================

            //================================数据库迁移==========================================================
            /**
             * 发布迁移（方法 1）
             *   文件路径数组（“源路径”=>“目标路径”）
             *   我们分配给这组相关可发布资产的名称（“标签”）
             */
            if (! class_exists('CreatePostsTable')) {   // 检查是否已经发布迁移
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_posts_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_posts_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }
            /**
             * 自动加载迁移（方法 2）
             *  Laravel 提供了一种使用loadMigrationsFrom助手的替代方法（请参阅文档 （打开新窗口））。
             *  通过在包的服务提供者中指定一个迁移目录，当最终用户php artisan migrate从他们的 Laravel 应用程序中执行时，所有迁移都将被执行
             *  确保在迁移中包含正确的时间戳，否则 Laravel 无法处理它们。例如：2018_08_08_100000_example_migration.php。选择此方法时，您不能使用存根（如方法 1）
             */
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            //================================数据库迁移==========================================================

            // Register the model factories
            $this->app->make('Illuminate\Database\Eloquent\Factory')
                ->load(__DIR__.'/../database/factories');
        }

        //================================配置路由==========================================================
        // 在服务提供者中注册路由
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        // 在服务提供者中注册路由时配置的路由前缀和中间件
        $this->registerRoutes();
        //================================配置路由==========================================================

        //================================视图配置==========================================================
        // 在服务提供者中注册视图
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blogpackage');
        // 让包的用户自定义视图   --发布视图文件到 项目views/vendor/blogpackage目录
        if($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/blogpackage')
            ], 'views');
        }
        //================================配置路由==========================================================

        //================================发布资源文件==========================================================
        if($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('blogpackage')
            ], 'assets');
        }
        //================================发布资源文件==========================================================

        //================================注册中间件 到应用程序的全局注册中间件数组中==========================================================
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(CapitalizeTitle::class);

        // 路由中间件 --注册中间件别名
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('capitalize', CapitalizeTitle::class);
        // 将中间件推送到特定组 例中为 web
        $router->pushMiddlewareToGroup('web', CapitalizeTitle::class);
        //================================注册中间件 到应用程序的全局注册中间件数组中==========================================================
    }

    /**
     * 配置的路由前缀和中间件
     * @author tan bing
     * @date 2021-06-04 9:30
     */
    public function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * 配置的路由前缀和中间件
     * @return array
     * @author tan bing
     * @date 2021-06-04 9:33
     */
    public function routeConfiguration()
    {
        return [
            'prefix' => config('blogpackage.prefix'),
            'middleware' => config('blogpackage.middleware'),
        ];
    }

}