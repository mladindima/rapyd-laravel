<?php namespace Mladindima\Rapyd\Demo;

/**
 * Article
 */
class Article extends \Eloquent
{
    protected $table = 'demo_articles';

    public function author()
    {
        return $this->belongsTo('Mladindima\Rapyd\Demo\Author', 'author_id');
    }

    public function comments()
    {
        return $this->hasMany('Mladindima\Rapyd\Demo\Comment', 'article_id');
    }

    public function categories()
    {
        return $this->belongsToMany('Mladindima\Rapyd\Demo\Category', 'demo_article_category', 'article_id','category_id');
    }

    public function detail()
    {
        return $this->hasOne('Mladindima\Rapyd\Demo\ArticleDetail', 'article_id');
    }

    public function scopeFreesearch($query, $value)
    {
        return $query->where('title','like','%'.$value.'%')
            ->orWhere('body','like','%'.$value.'%')
            ->orWhereHas('author', function ($q) use ($value) {
                $q->whereRaw(" CONCAT(firstname, ' ', lastname) like ?", array("%".$value."%"));
            })->orWhereHas('categories', function ($q) use ($value) {
                $q->where('name','like','%'.$value.'%');
            });

    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($article) {
            $article->detail()->delete();
            if ($article->photo)  @unlink(public_path().'/uploads/demo/'.$article->photo);
        });
    }
}
