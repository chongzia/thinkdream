<?php

namespace Modules\Common\Repository\Options;

use Composer\Autoload\ClassLoader;

class AiProviders extends Option implements OptionInterface
{
    public function get(): array
    {
        $registerLoaders = ClassLoader::getRegisteredLoaders();

        // 获取所有 PSR-4 映射
        $classMaps = $registerLoaders[base_path('vendor')]->getClassMap();

        $providers = [];

        foreach ($classMaps as $key => $value) {
            if (str_contains($key, 'Catch\Ai\Providers')) {
                if (! empty(class_parents($key))) {
                    $provider = app()->make($key);
                    if (method_exists($provider, 'title')) {
                        $title = $provider->title();
                    } else {
                        $title = strtolower(class_basename($key));
                    }

                    $providers[] = [
                        'label' => $title,
                        'value' => $key,
                    ];
                }
            }
        }

        return $providers;
    }
}
