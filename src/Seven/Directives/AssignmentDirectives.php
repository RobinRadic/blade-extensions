<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 2:46 AM
 */

namespace Radic\BladeExtensions\Seven\Directives;


use Illuminate\Contracts\Foundation\Application;

class AssignmentDirectives
{
    protected $app;

    public static $set = [
        'pattern'     => '/(?<!\w)(\s*)@set\s*\(\s*\${0,1}[\'"\s]*(.*?)[\'"\s]*,\s*([\W\w^]*?)\)\s*$/m',
        'replacement' => '$1<?php \$$2 = $3; $__data[\'$2\'] = $3; ?>',
    ];

    public static $unset = [
        'pattern'     => '/(?<!\\w)(\\s*)@unset(?:\\s*)\\((?:\\s*)(?:\\$|(?:\'|\\"|))(.*?)(?:\'|\\"|)(?:\\s*)\\)/',
        'replacement' => '$1<?php unset(\$$2); ?>',
    ];

    /**
     * AssignmentDirectives constructor.
     *
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handleSet($value)
    {
        return $value;
    }

    public function handleUnset($value)
    {
        return $value;
    }
}
