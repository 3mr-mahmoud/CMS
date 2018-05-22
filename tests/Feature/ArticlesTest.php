<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArticlesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authenticated_user_only_can_see_articles_in_control_panel()
    {
    	$article = create('App\Article');
        $this->get(controlPanelUrl('articles'))->assertRedirect(controlPanelUrl('login'));
        $this->signIn()->get(controlPanelUrl('articles'))->assertSee($article->title);
    }
    public function authenticated_user_only_can_update_article()
    {
    	$article = create('App\Article');
    	$newArticle = make('App\Article');
        $this->signIn()->patch(controlPanelUrl('article/'.$article->id),$newArticle);
        $this->get(controlPanelUrl('article/'.$article->id.'/edit'))->assertSee($newArticle->title);
    }
}