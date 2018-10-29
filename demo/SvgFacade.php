<?php

namespace Galileo;

use Galileo\ISvg,
    Nette\Application\LinkGenerator;

/** @author Lubomir Andrisek */
final class SvgFacade implements ISvg {

    /** @var string */
    private $component;

    /** @var LinkGenerator */
    private $linkGenerator;

    public function __construct(LinkGenerator $linkGenerator) {
        $this->linkGenerator = $linkGenerator;
    }

    public function colors(): array {
        return ['background-color' => '#eee',
                'border' => '2px solid #0be',
                'border-radius' => '3px',
                'color' => '#0e2652',
                'max-width' => '200px',
                'padding' => '5px 8px 4px 8px',
                'text-align' => 'center',
                'text-shadow' => 'none',
                '-moz-border-radius' => '3px',
                '-webkit-border-radius' => '3px'];
    }

    public function data(): array {
        $data = [];
        $data[] = ['attr' => ['href' => $this->linkGenerator->link('Default:default', ['id' => 'myId'])], 'tooltip' => 'name<br/><strong>(10)</strong>'];
        return $data;
    }

    public function height(): int {
        return 300;
    }

    public function image(): string {
        return '/images/mySvg.svg';
    }

    public function marker(): array {
        return ['background' =>  '#1b8a26',
                'border' => '1px solid #0f6d18',
                'color' => 'white',
                'font-size' => '14px',
                'padding' => '15px 10px',
                'text-align' => 'center'];
    }

    public function setComponent(string $component): ISvg {
        $this->component = $component;
        return $this;
    }

    public function width(): int {
        return 600;
    }

}
