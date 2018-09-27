<?php

namespace Galileo;

use Nette\Application\UI\Control,
    Nette\Http\IRequest;

/** @author Lubomir Andrisek */
final class SvgMap extends Control implements ISvgMapFactory {

    /** @var string */
    private $assets;

    /** @var bool */
    private static $render = true;

    /** @var ISvg */
    private $svg;

    public function __construct(string $assets, IRequest $request) {
        $this->assets = rtrim($request->getUrl()->getScriptPath(), '/') . $assets;
    }

    public function clone(): SvgMap {
        return clone $this;
    }

    public function create(): SvgMap {
        return $this;
    }

    public function render(): void {
        $this->svg->setComponent($this->getName());
        $this->template->colors = json_encode($this->svg->colors());
        $this->template->data = json_encode($this->svg->data());
        $this->template->height = $this->svg->height();
        $this->template->id = strtolower(preg_replace('/\\\/', '-', get_class())) . '-' . strtolower($this->getName());
        $this->template->image = $this->svg->image();
        $this->template->js = $this->assets . 'js/svgmap.js';
        $this->template->raphael = $this->assets . 'js/raphael.min.js';
        $this->template->render = self::$render;
        $this->template->styles = $this->svg->marker();
        $this->template->width = $this->svg->width();
        $this->template->setFile(__DIR__ . '/../templates/svgmap.latte');
        $this->template->render();
        self::$render = false;
    }

    public function setSvg(ISvg $svg): ISvgMapFactory {
        $this->svg = $svg;
        return $this;
    }

}

interface ISvgMapFactory {

    public function create(): SvgMap;
}
