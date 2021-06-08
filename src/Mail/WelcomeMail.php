<?php
/**
 *WelcomeMail
 * @author tan bing
 * @date 2021-06-04 11:32
 */


namespace Tanbing\BlogPackage\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Tanbing\BlogPackage\Models\Post;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->view('blogpackage::emails.welcome');
    }
}