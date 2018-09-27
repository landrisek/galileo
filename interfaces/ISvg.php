<?php

namespace Galileo;

/** @author Lubomir Andrisek */
interface ISvg {

    public function colors(): array;

    public function data(): array;

    public function height(): int;

    public function image(): string;

    public function marker(): array;

    public function setComponent(string $component): ISvg;

    public function width(): int;

}
