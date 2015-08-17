<?php
/**
 * Part of the Caffeinated PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Radic\BladeExtensions\Helpers;

/**
 * This is the Minifier.
 *
 * @package        Radic\BladeExtensions
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class Minifier
{
    /**
     * @var
     */
    protected static $type;

    /**
     * open
     *
     * @param $type
     */
    public static function open($type)
    {
        static::$type = trim(strtolower($type));
        ob_start();
    }

    /**
     * close
     */
    public static function close()
    {
        $code = ob_get_clean();
        echo static::minify(static::$type, $code);
        static::$type = null;
    }

    /**
     * minify
     *
     * @param $type
     * @param $code
     * @return string
     */
    protected static function minify($type, $code)
    {
        $types = ['html', 'css', 'js'];

        if (!in_array($type, $types, true)) {
            $typeStr = implode(', ', $types);
            throw new \InvalidArgumentException("BladeExtensions Minifier could not minify your code, you haven't specified a valid type. Given: [{$type}]. Allowed: [{$typeStr}]");
        }

        if ($type === 'html') {
            return static::compileMinify($code);
        } elseif ($type === 'css') {
            return with(new \MatthiasMullie\Minify\CSS($code))->execute();
        } elseif ($type === 'js') {
            return with(new \MatthiasMullie\Minify\JS($code))->execute();
        }
    }


    /**
     *
     * @author https://github.com/yocmen/html-minify
     * @param string $value the contents of the view file
     *
     * @return bool
     */
    protected static function shouldMinify($value)
    {
        if (preg_match('/skipmin/', $value)
            || preg_match('/<(pre|textarea)/', $value)
            || preg_match('/<script[^\??>]*>[^<\/script>]/', $value)
            || preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value)
        ) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Compress the HTML output before saving it
     *
     * @author https://github.com/yocmen/html-minify
     * @param string $value the contents of the view file
     *
     * @return string
     */
    protected static function compileMinify($value)
    {
        if (static::shouldMinify($value)) {
            $replace = [
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                '/<\?php/'                  => '<?php ',
                '/\n([\S])/'                => ' $1',
                '/\r/'                      => '',
                '/\n/'                      => '',
                '/\t/'                      => ' ',
                '/ +/'                      => ' ',
                '/>\s</'                    => '><'
            ];
            return preg_replace(
                array_keys($replace),
                array_values($replace),
                $value
            );
        } else {
            return $value;
        }
    }
}
