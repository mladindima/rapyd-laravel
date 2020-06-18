<?php namespace Mladindima\Rapyd\Demo;

/**
 * Comment
 */
class Comment extends \Eloquent
{

    protected $table = 'demo_comments';

    public function article()
    {
        return $this->belongsTo('Mladindima\Rapyd\Models\Article', 'article_id');
    }

    public function author()
    {
        return $this->belongsTo('Mladindima\Rapyd\Models\Author', 'author_id');
    }
}
