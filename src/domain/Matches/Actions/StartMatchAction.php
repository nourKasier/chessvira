<?php

namespace Domain\Matches\Actions;

use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class StartMatchAction
{
    use AsAction;

    protected $post;

    public function  __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle($postData)
    {
        $success = $this->post->create($postData);
        return $success ? true : false;
    }
}
