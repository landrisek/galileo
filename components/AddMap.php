<?php

namespace Galileo;

use Nette\Application\UI\Form,
    Nette\ComponentModel\IComponent,
    Nette\Forms\Controls\BaseControl,
    Nette\Http\IRequest;

/** @author Lubomir Andrisek */
final class AddMap extends BaseControl implements IAddMapFactory {

    /** @var string */
    private $assets;

    /** @var array */
    private $cookies;

    /** @var array */
    private $center = '{"latitude":50.43999582410241,"longitude":13.58970093439586,"zoom":7,"maxLatitude":50.795681,"minLatitude":49.88319,"maxLongitude":14.21241,"minLongitude":12.945251}';

    /** @var int */
    private $id;

    /** @var string */
    private $layer;

    /** @var string */
    private $link;

    /** @var string */
    private $key;

    /** @var array */
    private const LAYERS = [null => 'SMap.DEF_BASE',
                            'base' => 'SMap.DEF_BASE',
                            'geography' => 'SMap.DEF_GEOGRAPHY',
                            'histric' => 'SMap.DEF_HISTORIC',
                            'hybrid' => 'SMap.DEF_HYBRID',
                            'oblique' => 'SMap.DEF_OBLIQUE',
                            'ortho' => 'SMap.DEF_OPHOTO',
                            'ortho1012' => 'SMap.DEF_OPHOTO1012',
                            'ortho1415' =>  'SMap.DEF_OPHOTO1415',
                            'ortho203' => 'SMap.DEF_OPHOTO0203',
                            'ortho406' => 'SMap.DEF_OPHOTO0406',
                            'pano' => 'SMap.DEF_PANO',
                            'relief' => 'SMap.DEF_RELIEF',
                            'smartBase' => 'SMap.DEF_SMART_BASE',
                            'smartOrtho' => 'SMap.DEF_SMART_OPHOTO',
                            'smartTurist' => 'SMap.DEF_SMART_TURIST',
                            'smartWinter' => 'SMap.DEF_SMART_WINTER',
                            'smartSummer' => 'SMap.DEF_SMART_SUMMER',
                            'sparse' => 'SMap.DEF_HYBRID_SPARSE',
                            'turistic' => 'SMap.DEF_TURIST',
                            'turisticWinter' => 'SMap.DEF_TURIST_WINTER'];

    /** @var bool */
    private static $render = true;

    /** @var string */
    private $style = 'height:400px;width:auto;background: url(\'/assets/galileo/images/spinner.gif\') no-repeat center center;';

    public function __construct(string $assets, string $id, string $label, IRequest $request) {
        parent::__construct($label);
        $this->assets = $assets;
        $this->cookies = $request->getCookies();
        $this->id = $id;
    }

    public function attached(IComponent $form): void {
        parent::attached($form);
        if ($form instanceof Form) {
            $this->key = $form->getPresenter()->getName() . ':' . $form->getName() . ':' . $this->id;
        }
    }

    public function create(): AddMap {
        return $this;
    }

    public function getControl(): string {
        $component = '';
        if(self::$render) {
            $component = '<script src="https://api.mapy.cz/loader.js"></script><script>Loader.load()</script>';
            $component .= '<link href="https://api.mapy.cz/css/api/v4/smap-jak.css?v4.13.32" media="all" rel="stylesheet" />';
        }
        $component .= '<div data-center=' . $this->center .  ' '
                         . 'data-drag="' . $this->key . '" '
                         . 'data-map="' . self::LAYERS[$this->layer] . '" '
                         . 'data-markers="{}" '
                         . 'id="seznamMap-' . $this->id .'" '
                         . 'style="' . $this->style . '"></div>';
        $component .= '<script id="galileo-seznammap-loader" '
                            . 'loaded="true" '
                            . 'src="' . $this->assets . '/js/seznammap.js"></script>';
        $component .= '<script type="text/javascript">initMap("seznamMap-' . $this->id . '")</script>';
        self::$render = false;
        return $component;
    }

    public function getValue(): array {
        return (array) json_decode($this->cookies[$this->key]);
    }

    public function setCenter(array $center): IAddMapFactory {
        $this->center = json_encode($center);
        return $this;
    }

    public function setLayer(string $layer): IAddMapFactory {
        $this->layer = $layer;
        return $this;
    }

    public function setLink(string $link): IAddMapFactory {
        $this->link = $link;
        return $this;
    }

    public function setStyle(array $style): IAddMapFactory {
        $this->style = json_encode($style);
        return $this;
    }

}

interface IAddMapFactory {

    public function create(): AddMap;
}
