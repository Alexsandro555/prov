<?php

namespace Modules\Initializer\Providers;

use Modules\Initializer\Events\ListValueSaved;
use Modules\Initializer\Listeners\FieldUniqueTrueBoolean;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;
  protected $listen = [
    ListValueSaved::class => [
      FieldUniqueTrueBoolean::class,
    ]
  ];

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [];
  }
}