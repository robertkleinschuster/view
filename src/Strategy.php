<?php

declare(strict_types=1);

namespace SnappyRenderer;

interface Strategy
{
    public function render(mixed $element, object $model, Renderer $renderer, NextStrategy $next): string;
}