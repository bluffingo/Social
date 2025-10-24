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
     * @var Social The core Social class
     */
    private Social $social;

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
    public function __construct(Social $social)
    {
        chdir(BLUFF_PRIVATE_PATH);

        $this->social = $social;
        /*
        $this->authentication = $this->social->getAuthenticationClass();

        $options = $social->getLocalOptions();
        */

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

        /*
        $doCache = !$sb->isTemplateCachingEnabled() ? false : 'skins/cache/';

        $this->loader->addPath('skins/common/');
        */

        $this->twig = new Environment($this->loader, ['debug' => false, 'cache' => false]);

        //$this->twig->addExtension(new SquareBracketTwigExtension($sb, $this->twig));

        if ($social->isDebug()) {
            $this->twig->addExtension(new DebugExtension());
        } else {
            $this->twig->addFunction(new TwigFunction('dump', function () {
                trigger_error("Twig dump function called outside of debug mode!", E_USER_WARNING);
                return "This function is not available outside of debug mode.";
            }));
        }

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
