<?php

declare(strict_types=1);

namespace SnappyRenderer;

use SnappyRenderer\Exception\RenderException;

final class Renderer implements Strategy
{
    private Strategy $strategy;
    private int $maxLevel = 0;
    private int $level = 0;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
        $this->setMaxLevel(1000);
    }

    /**
     * @param mixed $view
     * @return string
     * @throws RenderException
     */
    public function render($view): string
    {
        $clone = clone $this;
        return $clone->execute($view, $clone);
    }

    /**
     * @param $view
     * @param Renderer $renderer
     * @return string
     * @throws RenderException
     */
    public function execute($view, Renderer $renderer): string
    {
        $this->assertLevel($view);
        return $this->strategy->execute($view, $renderer);
    }

    public function getMaxLevel(): int
    {
        return $this->maxLevel;
    }

    public function setMaxLevel(int $maxLevel): void
    {
        $this->maxLevel = $maxLevel;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param mixed $view
     * @return void
     * @throws RenderException
     */
    private function assertLevel($view): void
    {
        $this->level++;
        if ($this->getLevel() > $this->getMaxLevel()) {
            throw RenderException::forMaxNestingLevel($view, $this->getMaxLevel());
        }
    }
}