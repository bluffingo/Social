<?php

/*
  Social

  Copyright (C) 2025 Chaziz

  Social is free software: you can redistribute it and/or modify it under the 
  terms of the GNU Affero General Public License as published by the Free 
  Software Foundation, either version 3 of the License, or (at your option) any
  later version. 

  Social is distributed in the hope that it will be useful, but WITHOUT ANY 
  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
  FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more 
  details.

  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

namespace Social;

use BluffingoCore\Site;

/**
 * class Social
 *
 * The core Social class.
 */
class Social extends Site
{
    /**
     * @var array
     */
    private array $branding_settings;

    /**
     * function __construct
     *
     * Initialize the core Social classes.
     *
     * @param mixed $config
     *
     * @return void
     */
    public function __construct($config)
    {
        parent::__construct($config);

        /*
        $allowedSites = ['squarebracket', 'squarebracket_chaziz', 'sitetest'];
        if (!in_array($config["site"], $allowedSites)) {
            trigger_error("The site mode in the configuration file should be 
            set either to squarebracket, squarebracket_chaziz or sitetest.", E_USER_WARNING);
        }
        $this->is_chaziz_squarebracket_instance = ($config["site"] === "squarebracket_chaziz");
        $this->is_sitetest_instance = ($config["site"] === "sitetest");
        */
        //$this->authentication = new Authentication($this);

        $this->branding_settings = [
            "name" => $config["branding"]["name"] ?? '',
            "assets_location" => $config["branding"]["assets"] ?? '',
            "is_vector" => $config["branding"]["is_vector"] ?? false,
            "use_wordmark" => $config["branding"]["use_wordmark"] ?? false,
        ];
    }

    /**
     * function getBrandingSettings
     *
     * Returns array for the instance's branding.
     *
     * @return array
     */
    public function getBrandingSettings(): array
    {
        return $this->branding_settings;
    }
}
