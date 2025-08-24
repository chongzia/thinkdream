<?php

namespace Modules\Cms\Providers;

use Catch\Providers\CatchModuleServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Factory;

class CmsServiceProvider extends CatchModuleServiceProvider
{
    /**
     * boot
     *
     * @return void
     */
    public function boot(): void
    {
        // 注册 cms 资源方法
        Vite::macro('cms_asset', fn (string $asset) => $this->asset("resources/themes/{$asset}"));

        $this->registerComponents();

        $this->registerViewNamespace();
    }

    /**
     * route path
     */
    public function moduleName(): string
    {
        // TODO: Implement path() method.
        return 'Cms';
    }

    /**
     * @return Factory
     */
    protected function registerViewNamespace(): Factory
    {
        return View::addNamespace('cms', resource_path('themes'));
    }

    /**
     * 注册组件
     *
     * @return void
     */
    protected function registerComponents(): void
    {
        Blade::componentNamespace('Modules\\Cms\\Components', 'cms');

        Blade::componentNamespace('Modules\\Cms\\Components\\Layouts', 'cms-layout');
    }
}
