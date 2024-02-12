<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twig\Node\Expression;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * @internal
 */
final class InlinePrint extends AbstractExpression
{
    public function __construct(Node $node, int $lineno)
    {
        parent::__construct(['node' => $node], [], $lineno);
    }

    public function compile(Compiler $compiler): void
    {
        if ($compiler->getEnvironment()->useYield()) {
            $compiler
                ->raw('yield ')
                ->subcompile($this->getNode('node'))
            ;
        } else {
            $compiler
                ->checkForOutput(false)
                ->raw('print(')
                ->checkForOutput(true)
                ->subcompile($this->getNode('node'))
                ->raw(')')
            ;
        }
    }
}