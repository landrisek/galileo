<?php

namespace Galileo;

use Exception,
    Nette\DI\CompilerExtension,
    Nette\PhpGenerator\ClassType;

final class GalileoExtension extends CompilerExtension {

    /** @var array */
    private $defaults = ['assets' => '/assets/galileo/'];

    /** @var array */
    private $parameters;

    public function afterCompile(ClassType $class) {
        $initialize = $class->methods['initialize'];
        $initialize->addBody('Nette\Forms\Container::extensionMethod("\Nette\Forms\Container::addSeznamMap", '
                           . 'function (\Nette\Forms\Container $_this, string $name, string $label) { '
                           . 'return $_this[$name] = new Galileo\AddMap("' . $this->parameters['galileo']['assets'] . '", $name, $label, $this->getByType(?)); });', 
                            ['Nette\Http\IRequest']);
    }

    public function beforeCompile() {
        if(!class_exists('Nette\Application\Application')) {
            throw new MissingDependencyException('Please install and enable https://github.com/nette/nette.');
        }
        parent::beforeCompile();
    }

    public function getConfiguration(array $parameters) {
        foreach($this->defaults as $key => $parameter) {
            if(!isset($parameters['galileo'][$key])) {
                $parameters['galileo'][$key] = $parameter;
            }
        }
        return $parameters;
    }

    public function loadConfiguration() {
        $builder = $this->getContainerBuilder();
        $this->parameters = $this->getConfiguration($builder->parameters);
        $builder->addDefinition($this->prefix('seznamMap'))->setFactory('Galileo\SeznamMap', [$this->parameters['galileo']['assets']]);
        $builder->addDefinition($this->prefix('svgMap'))->setFactory('Galileo\SvgMap', [$this->parameters['galileo']['assets']]);
        $builder->addDefinition($this->prefix('galileoExtension'))->setFactory('Galileo\GalileoExtension', []);
    }

}

class MissingDependencyException extends Exception { }
