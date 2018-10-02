<?php

namespace Galileo;

use Nette\Application\Responses\JsonResponse,
    Nette\Application\UI\Control,
    Nette\ComponentModel\IComponent,
    Nette\Http\IRequest,
    Nette\Localization\ITranslator;

final class SeznamMap extends Control implements ISeznamMapFactory {

    /** @var string */
    private $assets;

    /** @var bool */
    private $hide = false;

    /** @var bool */
    private static $render = true;

    /** @var ISeznam */
    private $seznam;

    /** @var ITranslator */
    private $translatorRepository;

    public function __construct(string $assets, IRequest $request, ITranslator $translatorRepository) {
        $this->assets = rtrim($request->getUrl()->getScriptPath(), '/') . $assets;
        $this->translatorRepository = $translatorRepository;
    }
    
    protected function attached(IComponent $presenter): void {
        parent::attached($presenter);
        if ($presenter instanceof IPresenter) {

        }
    }

    public function create(): SeznamMap {
        return $this;
    }

    public function handleMarkers(): void {
        $this->getPresenter()->sendResponse(new JsonResponse($this->seznam->markers()));
    }

    public function hide(): ISeznamMapFactory {
        $this->hide = true;
        return $this;
    }

    public function render(...$args): void {
        $this->seznam->setComponent($this->getName());
        $this->template->center = json_encode($this->seznam->center());
        $this->template->height = $this->seznam->height();
        $this->template->hide = $this->hide;
        $this->template->icon = $this->seznam->icon();
        $this->template->id = 'mapa';
        $this->template->js = $this->assets . 'js/seznammap.js';
        $this->template->link = $this->link('markers');
        $this->template->map = $this->seznam->map();
        $this->template->render = self::$render;
        $this->template->styles = $this->seznam->cluster();
        $this->template->setFile(__DIR__ . '/../templates/seznamMap.latte');
        $this->template->render();
        self::$render = false;
    }

    public function renderShow(): void {
        $this->template->close = $this->seznam->close();
        $this->template->open = $this->seznam->open();
        $this->template->setFile(__DIR__ . '/../templates/show.latte');
        $this->template->setTranslator($this->translatorRepository);
        $this->template->render();
    }

    public function setSeznam(ISeznam $seznam): ISeznamMapFactory {
        $this->seznam = $seznam;
        return $this;
    }

}

interface ISeznamMapFactory {

    public function create(): SeznamMap;
}
