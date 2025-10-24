<?php

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
}
