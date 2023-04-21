<?php

declare(strict_types=1);

namespace SnappyRenderer\Strategy;

use Closure;
use SnappyRenderer\Exception\RenderException;
use SnappyRenderer\Renderer;
use SnappyRenderer\Strategy;

class ClosureStrategy implements Strategy
{
    private Strategy $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param mixed $view
     * @param Renderer $renderer
     * @param mixed|null $data
     * @return string
     * @throws RenderException
     */
    public function execute($view, Renderer $renderer, $data = null): string
    {
        if ($view instanceof Closure) {
            return $renderer->render($view($renderer, $data), $data);
        }
        return $this->strategy->execute($view, $renderer, $data);
    }
}