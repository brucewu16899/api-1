<?php

/**
 * Part of the Antares package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Api
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Modules\Api\Providers;

use Antares\Modules\Api\Providers\Presenter\Basic as BasicPresenter;
use Antares\Modules\Api\Contracts\AuthProviderPresenterContract;
use Illuminate\Contracts\Container\Container;
use Dingo\Api\Auth as DingoAuth;

class Basic extends AuthProvider
{

    /**
     * Construct.
     * 
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container, 'basic', 'Basic Auth');
    }

    /**
     * @return bool
     */
    public function isGlobalConfigurable()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isConfigurablePerUser()
    {
        return true;
    }

    /**
     * @return AuthProviderPresenterContract | null
     */
    public function getPresenter()
    {
        return $this->container->make(BasicPresenter::class);
    }

    /**
     * Extends the Auth by the provider.
     */
    public function registerAuth()
    {
        $this->container->make(DingoAuth\Auth::class)->extend('basic', function($app) {
            $app['auth.loaded'] = true;
            return new DingoAuth\Provider\Basic(new \Antares\Modules\Api\Providers\Auth\Basic($app));
        });
    }

    /**
     * Provider description getter
     * 
     * @return String
     */
    public function getDescription()
    {
        return 'Basic auth uses standard username and passoword which are the same in login page.&nbsp;<span class="label-basic label-basic--danger">NOT RECOMMENDED</span>';
    }

}
