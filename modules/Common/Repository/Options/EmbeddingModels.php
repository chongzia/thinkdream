<?php
namespace Modules\Common\Repository\Options;

use Modules\Common\Repository\Options\OptionInterface;

class EmbeddingModels implements OptionInterface
{
    public function get(): array
    {
        $models = ['test'];

        $_models = [];
        foreach ($models as $model) {
            $_models[] = [
                'value' => $model,
                'label' => $model,
            ];
        }

        return $_models;
    }
}
