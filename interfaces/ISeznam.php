<?php

namespace Galileo;

/** @author Lubomir Andrisek */
interface ISeznam {

    public function center(): array;

    public function close(): array;

    public function height(): int;

    public function icon(): string;

    public function markers(): array;

    public function open(): array;

    public function setComponent(string $component): ISeznam;

}
