<?php

namespace Galileo;

use Galileo\ISeznam,
    Nette\Application\LinkGenerator;

/** @author Lubomir Andrisek */
final class SeznamFacade implements ISeznam {

    /** @var array */
    private $center = ['latitude' => 50.08, 'longitude' => 14.41, 'zoom' => 10];

    /** @var string */
    private $id;

    /** @var LinkGenerator */
    private $linkGenerator;

    public function __construct(LinkGenerator $linkGenerator) {
        $this->linkGenerator = $linkGenerator;
    }

    public function center(): array {
        return $this->center;
    }

    public function close(): array {
        return ['background-color' => 'rgb(255, 255, 255)',
                'border' => '1px solid rgb(113, 123, 135)',
                'box-shadow' => 'rgba(0, 0, 0, 0.4) 0px 2px 4px',
                'color' => 'rgb(0, 0, 0)',
                'cursor' => 'pointer',
                'display' => 'none',
                'font-family' => 'Arial, sans-serif',
                'font-weight' => 'bold',
                'font-size' => '13px',
                'margin' => '5px',
                'padding' => '2px 8px',
                'text-align' => 'center',
                'text-decoration' => 'none'];
    }

    public function style(): array {
        return ['.smap .cluster div' => ['background' => 'url("../assets/images/myCluster.png") 0px 0px no-repeat',
                'border' => 'none',
                'border-radius' => '0%',
                'color' => '#1b8a26',
                'display' => 'block',
                'height' => '19px',
                'overflow' => 'hidden',
                'width' => '110px']];
    }

    public function height(): int {
        return 400;
    }

    public function icon(): string {
        return '/images/icon.png';
    }


    public function id(string $id): ISeznam {
        $this->id = $id;
        return $this;
    }

    public function map(): string {
        return SeznamVO::TURISTIC;
    }

    public function markers(): array {
        $markers = [];
        $markers[] = ['header' => '<strong>name</strong>',
                      'html' => '<a href="' . $this->linkGenerator->link('Default:detail', ['id' => 'myMarkerId']) . '"> '
                           . '<img alt="name" class="myClass" height="198" src="' . $this->linkGenerator->link('Default:image', ['id' => 'imageId']) . '" width="251" /></a>',
                      'lat' => $this->center['latitude'],
                      'lng' => $this->center['longitude'],
                      'name' => 'name'];
        return $markers;
    }

    public function open(): array {
        return ['background' => 'url("../assets/images/map.png") 0 0 no-repeat',
                'display' => 'block',
                'height' => '103px',
                'position' => 'absolute',
                'right' => '-2px',
                'width' => '102px',
                'top' => '0px',
                'z-index' => '4'];
    }

}
