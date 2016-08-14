<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 2:46 AM
 */

namespace Radic\BladeExtensions\Seven\Directives;


class AssignmentDirectives
{

    public static $set = [
        'pattern'     => '/(?<!\w)(\s*)@set\s*\(\s*\${0,1}[\'"\s]*(.*?)[\'"\s]*,\s*([\W\w^]*?)\)\s*$/m',
        'replacement' => '$1<?php \$$2 = $3; $__data[\'$2\'] = $3; ?>',
    ];

    public static $unset = [
        'pattern'     => '/(?<!\\w)(\\s*)@unset(?:\\s*)\\((?:\\s*)(?:\\$|(?:\'|\\"|))(.*?)(?:\'|\\"|)(?:\\s*)\\)/',
        'replacement' => '$1<?php unset(\$$2); ?>',
    ];

    public function handleSet($value)
    {
        return preg_replace(static::$set[ 'pattern' ], static::$set[ 'replacement' ], $value);
    }

    public function handleUnset($value)
    {
        return preg_replace(static::$unset[ 'pattern' ], static::$unset[ 'replacement' ], $value);
    }
}
