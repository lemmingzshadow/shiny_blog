<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Action;

use Nekudo\ShinyBlog\Domain\ShowArticleDomain;
use Nekudo\ShinyBlog\Exception\NotFoundException;
use Nekudo\ShinyBlog\Responder\ShowArticleResponder;

class ShowArticleAction extends BaseAction
{
    /** @var ShowArticleDomain $domain */
    protected $domain;

    /** @var ShowArticleResponder $responder */
    protected $responder;

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->domain = new ShowArticleDomain($this->config);
        $this->responder = new ShowArticleResponder($this->config);
    }

    /**
     * Renders requested article and sends it to client.
     *
     * @param array $arguments
     */
    public function __invoke(array $arguments)
    {
        try {
            $slug = $arguments['slug'];
            $article = $this->domain->getArticleBySlug($slug);
            $this->responder->renderArticle($article);
        } catch (NotFoundException $e) {
            $this->responder->notFound($e->getMessage());
        }
    }
}