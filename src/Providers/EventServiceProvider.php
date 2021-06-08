<?php
/**
 * 创建事件服务提供者
 * EventServiceProvider
 * @author tan bing
 * @date 2021-06-04 10:49
 */


namespace Tanbing\BlogPackage\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Tanbing\BlogPackage\Events\PostWasCreated;
use Tanbing\BlogPackage\Listeners\UpdatePostTitle;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var \string[][]
     * @author tan bing
     */
    protected $listen = [
        PostWasCreated::class => [
            UpdatePostTitle::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}