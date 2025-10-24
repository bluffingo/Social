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

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

use BluffingoCore\Database;
use BluffingoCore\Profiler;

/**
 * class SocialTwigExtension
 */
class SocialTwigExtension extends AbstractExtension
{
    /**
     * @var Social The core Social class.
     */
    private Social $social;

    /**
     * @var Database The Database class.
     */
    private Database $database;

    /**
     * @var Profiler The Profiler class.
     */
    private Profiler $profiler;

    /**
     * @var Environment The Twig environment.
     */
    private Environment $twig;

    /**
     * function __construct
     *
     * @param Social $social
     * @param mixed $twig
     *
     * @return void
     */
    public function __construct(Social $social, $twig)
    {
        $this->social = $social;
        $this->database = $this->social->getDatabaseClass();
        $this->profiler = $this->social->getProfilerClass();
        //$this->storage = $this->sb->getStorageClass();
        //$this->authentication = $this->sb->getAuthenticationClass();
        $this->twig = $twig;
    }

    /**
     * function getFunctions
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('localize', [$this, 'localize']),
            new TwigFunction('profile_picture', function ($username) {
                return "/assets/profiledef.svg";
            }),
            new TwigFunction('user_link', function ($username) {
                return "Userlink";
            }),
        ];
    }

    /**
     * function getFilters
     *
     * @return mixed
     */
    public function getFilters()
    {
        return [
            new TwigFilter('relative_time', function ($time) {
                $localization = $this->social->getLocalizationClass();
                return $localization->formatRelativeTime($time);
            }, ['is_safe' => ['html']]),

            new TwigFilter('format_date', function ($date, $dateFormat = 'medium', $timeFormat = 'medium', $pattern = null) {
                $localization = $this->social->getLocalizationClass();
                return $localization->formatDate($date, $dateFormat, $timeFormat, $pattern);
            }, ['is_safe' => ['html']]),

            new TwigFilter('format_number', function ($number) {
                $localization = $this->social->getLocalizationClass();
                return $localization->formatNumber($number);
            }, ['is_safe' => ['html']]),

            // placeholder
            new TwigFilter('markdown_user_written', function ($text, $enableHeaders = false) {
                return $text;
            }, ['is_safe' => ['html']]),
        ];
    }

    /**
     * function localize
     *
     * @param mixed $key
     * @param mixed $args
     *
     * @return mixed
     */
    public function localize($key, ...$args)
    {
        return $this->social->getLocalizationClass()->translate($key, ...$args);
    }
}
