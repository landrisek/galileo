<?php

namespace Galileo;

use Exception,
    Nette\DI\CompilerExtension,
    Nette\PhpGenerator\ClassType;

final class GalileoExtension extends CompilerExtension {

    private $defaults = ['assets' => '/assets/galileo/'];

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
        $parameters = $this->getConfiguration($builder->parameters);
        $builder->addDefinition($this->prefix('seznamMap'))->setFactory('Galileo\SeznamMap', [$parameters['galileo']['assets']]);
        $builder->addDefinition($this->prefix('svgMap'))->setFactory('Galileo\SvgMap', [$parameters['galileo']['assets']]);
        $builder->addDefinition($this->prefix('galileoExtension'))->setFactory('Galileo\GalileoExtension', []);
    }

    public function beforeCompile() {
        if(!class_exists('Nette\Application\Application')) {
            throw new MissingDependencyException('Please install and enable https://github.com/nette/nette.');
        }
        parent::beforeCompile();
    }

    public function afterCompile(ClassType $class) {
    }

}

class MissingDependencyException extends Exception { }
