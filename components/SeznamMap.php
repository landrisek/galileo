<?php

namespace Galileo;

use Nette\Application\Responses\JsonResponse,
    Nette\Application\UI\Control,
    Nette\ComponentModel\IComponent,
    Nette\Http\IRequest,
    Nette\Localization\ITranslator;

/** @author Lubomir Andrisek */
final class SeznamMap extends Control implements ISeznamMapFactory {

    /** @var string */
    private $assets;

    /** @var int */
    private $id;

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

    public function clone(): ISeznamMapFactory {
        return clone $this;
    }

    public function create(): SeznamMap {
        return $this;
    }

    public function handleMarkers(string $id): void {
        $this->getPresenter()->sendResponse(new JsonResponse($this->seznam->id($id)->markers()));
    }

    public function hide(bool $clause): ISeznamMapFactory {
        $this->hide = $clause;
        return $this;
    }

    public function render(...$args): void {
        $this->seznam->id($id = $this->getName() . '-' . intval(reset($args)));
        $this->template->center = json_encode($this->seznam->center());
        $this->template->data = json_encode([]);
        $this->template->height = $this->seznam->height();
        $this->template->hide = $this->hide;
        $this->template->icon = $this->seznam->icon();
        $this->template->id = $id;
        $this->template->images = $this->assets . 'images/';
        $this->template->js = $this->assets . 'js/' . strtolower($this->getName()) . '.js';
        $this->template->link = $this->link('markers', ['id' => $id]);
        $this->template->map = $this->seznam->map();
        $this->template->markers = json_encode($this->seznam->markers());
        $this->template->render = self::$render;
        $this->template->styles = $this->seznam->style();
        $this->template->setFile(__DIR__ . '/../templates/seznamMap.latte');
        $this->template->render();
        self::$render = false;
    }

    public function renderShow(...$args): void {
        $this->seznam->id($id = $this->getName() . '-' . intval(reset($args)));
        $this->template->close = '';
        foreach($this->seznam->close($this->getName() . '-' . intval(reset($args))) as $key => $value) {
            $this->template->close .= $key . ':' . $value . ';';
        }
        $this->template->id = $id;
        $this->template->open = '';
        foreach($this->seznam->open($this->getName() . '-' . intval(reset($args))) as $key => $value) {
            $this->template->open .= $key . ':' . $value . ';';
        }
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
