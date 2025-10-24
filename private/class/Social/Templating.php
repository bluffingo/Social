<?php

namespace Social;

use BluffingoCore\CoreUtilities;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Extra\String\StringExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

/**
 * class Templating
 *
 * The Twig wrapper
 */
class Templating
{
    /**
     * @var string The current user's skin
     */
    private string $skin;

    /**
     * @var string The current user's theme
     */
    private string $theme;

    /**
     * @var SquareBracket The core SquareBracket class
     */
    //private SquareBracket $sb;

    /**
     * @var Authentication The authentication class
     */
    //private Authentication $authentication;

    /**
     * @var FilesystemLoader Twig's Filesystem Loader
     */
    private FilesystemLoader $loader;

    /**
     * @var Environment The Twig environment
     */
    private Environment $twig;

    /**
     * @var VersionNumber The version number class
     */
    private VersionNumber $version_number;

    /**
     * function __construct
     *
     * @param SquareBracket $sb
     *
     * @return mixed|string
     */
    public function __construct(/*SquareBracket $sb*/)
    {
        chdir(BLUFF_PRIVATE_PATH);

        $default_skin = "trinium";
        $default_theme = "default";

        $options = []; // TODO

        $this->skin = $options["skin"] ?? $default_skin;
        $this->theme = $options["theme"] ?? $default_theme;

        if ($this->skin === null || trim($this->skin) === '') {
            trigger_error("Current skin is invalid", E_USER_WARNING);
            $this->skin = "trinium";
        }

        $skinPath = 'skins/' . $this->skin;
        $templatePath = $skinPath . '/templates';

        // if this skin isnt an actual skin, don't load.
        try {
            $this->loader = new FilesystemLoader($templatePath);
        } catch (LoaderError) {
            trigger_error("Current skin is invalid", E_USER_WARNING);

            $this->skin = "trinium";
            $this->theme = "default";
            $templatePath = "skins/trinium/templates";
            $this->loader = new FilesystemLoader($templatePath);
        }

        $this->twig = new Environment($this->loader, ['debug' => false, 'cache' => false]);

        $this->version_number = new VersionNumber();

        $this->twig->addGlobal('social_version', $this->version_number->getVersionArray());
    }

    /**
     * function render
     *
     * @param mixed $template
     * @param array $data
     *
     * @return string
     */
    public function render($template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }
}
