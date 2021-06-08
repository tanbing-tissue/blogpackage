<?php
/**
 *UpdatePostTitle
 * @author tan bing
 * @date 2021-06-04 10:45
 */


namespace Tanbing\BlogPackage\Listeners;

use Tanbing\BlogPackage\Events\PostWasCreated;

/**
 * 创建一个新的监听器
 * Class UpdatePostTitle
 * @package Tanbing\BlogPackage\Listeners
 * @author tan bing
 * @date 2021-06-04 10:45
 */
class UpdatePostTitle
{
    public function handle(PostWasCreated $event)
    {
        $event->post->update([
            'title' => 'New: ' . $event->post->title
        ]);
    }
}