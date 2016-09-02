<?php
/**
 * Directives: foreach, endforeach, break, continue
 */
namespace Radic\BladeExtensions\Seven\Directives;

/**
 * Directives: foreach, endforeach, break, continue
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Directives
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class LoopDirectives
{

    public static $foreach = [
        'pattern'     => '/(?<!\\w)(\\s*)@foreach(?:\\s*)\\((.*)(?:\\sas)(.*)\\)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->newLoop($2);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as $3):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
EOT,
    ];

    public static $endforeach = [
        'pattern'     => '/(?<!\\w)(\\s*)@endforeach(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>$2
EOT,
    ];

    public static $break = [
        'pattern'     => '/(?<!\\w)(\\s*)@break(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
    break;
?>$2
EOT,
    ];

    public static $continue = [
        'pattern'     => '/(?<!\\w)(\\s*)@continue(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->looped();
continue;
?>$2
EOT,
    ];

    public function handleForeach($value)
    {
        return preg_replace(static::$foreach[ 'pattern' ], static::$foreach[ 'replacement' ], $value);
    }


    public function handleEndforeach($value)
    {
        return preg_replace(static::$endforeach[ 'pattern' ], static::$endforeach[ 'replacement' ], $value);
    }

    public function handleBreak($value)
    {
        return preg_replace(static::$break[ 'pattern' ], static::$break[ 'replacement' ], $value);
    }

    public function handleContinue($value)
    {
        return preg_replace(static::$continue[ 'pattern' ], static::$continue[ 'replacement' ], $value);
    }


}
