<?php

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\ArticleManager;
use App\Presenters\BasePresenter;
use Nette\Application\BadRequestException;

/**
 * Presenter pro vykreslování článků.
 * @package App\CoreModule\Presenters
 */
class ArticlePresenter extends BasePresenter
{
    /** @var string URL výchozího článku. */
    private $defaultArticleUrl;

    /** @var ArticleManager Model pro správu s článků. */
    private $articleManager;

    /**
     * Konstruktor s nastavením URL výchozího článku a injektovaným modelem pro správu článků.
     * @param string         $defaultArticleUrl URL výchozího článku
     * @param ArticleManager $articleManager    automaticky injektovaný model pro správu článků
     */
    public function __construct($defaultArticleUrl, ArticleManager $articleManager)
    {
        parent::__construct();
        $this->defaultArticleUrl = $defaultArticleUrl;
        $this->articleManager = $articleManager;
    }

    /**
     * Načte a předá článek do šablony podle jeho URL.
     * @param string|null $url URL článku
     * @throws BadRequestException Jestliže článek s danou URL nebyl nalezen.
     */
    public function renderDefault($url = null)
    {
        if (!$url) $url = $this->defaultArticleUrl; // Pokud není zadaná URL, vezme se URL výchozího článku.
		//echo "url: -$url-";
		//exit;
        // Pokusí se načíst článek s danou URL a pokud nebude nalezen vyhodí chybu 404.
        if (!($article = $this->articleManager->getArticle($url)))
            $this->error(); // Vyhazuje výjimku BadRequestException.

        $this->template->article = $article; // Předá článek do šablony.
    }
}