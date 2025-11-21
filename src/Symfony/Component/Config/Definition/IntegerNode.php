<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Config\Definition;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

/**
 * This node represents an integer value in the config tree.
 *
 * @author Jeanmonod David <david.jeanmonod@gmail.com>
 */
class IntegerNode extends NumericNode
{
    public function __construct(?string $name, ?NodeInterface $parent = null, int|float|null $min = null, int|float|null $max = null, string $pathSeparator = BaseNode::DEFAULT_PATH_SEPARATOR)
    {
        parent::__construct($name, $parent, $min, $max, $pathSeparator);

        $this->allowEmptyValue = false;
    }

    /**
     * @return void
     */
    protected function validateType(mixed $value)
    {
        if (null === $value && $this->allowEmptyValue) {
            return;
        }

        if (!\is_int($value)) {
            $ex = new InvalidTypeException(\sprintf('Invalid type for path "%s". Expected "int", but got "%s".', $this->getPath(), get_debug_type($value)));
            if ($hint = $this->getInfo()) {
                $ex->addHint($hint);
            }
            $ex->setPath($this->getPath());

            throw $ex;
        }
    }

    protected function getValidPlaceholderTypes(): array
    {
        return ['int'];
    }
}
