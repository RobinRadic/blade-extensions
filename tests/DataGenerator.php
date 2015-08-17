<?php namespace Radic\Tests\BladeExtensions;

use Caffeinated\Beverage\Filesystem;
use Caffeinated\Beverage\Path;

/**
 * Data generator
 * data values:
 * raw:     http://beta.json-generator.com/api/json/get/KKx9VQ_
 * editor:  http://beta.json-generator.com/KKx9VQ_
 *
 * data records:
 * raw:     http://beta.json-generator.com/api/json/get/JKgQnt8
 * editor:  http://beta.json-generator.com/JKgQnt8
 *
 * @author     Robin Radic
 * @package    Laradic\Dev
 */
class DataGenerator
{

    protected static $records;

    protected static $values;

    public function __construct()
    {
        static::generateIfRequired();
    }

    protected static function generateIfRequired()
    {
        $fs = new Filesystem();
        if (!isset(static::$values) || !isset(static::$records)) {
            static::$values  = json_decode($fs->get(Path::join(__DIR__, 'data/values.json')), true)[0];
            static::$records = json_decode($fs->get(Path::join(__DIR__, 'data/records.json')), true);
        }
    }

    public static function getRecords()
    {
        static::generateIfRequired();

        return static::$records;
    }


    public static function getValues()
    {
        static::generateIfRequired();

        return static::$values;
    }

    /**
     * Get random integer
     *
     * @return integer
     */
    public function getInteger()
    {
        return rand(1, 10000);
    }

    /**
     * Get random big integer
     *
     * @return integer
     */
    public function getBigint()
    {
        return rand(1000, 10000);
    }

    /**
     * Get random small integer
     *
     * @return integer
     */
    public function getSmallint()
    {
        return rand(1, 100);
    }

    /**
     * Get random decimal
     *
     * @return float
     */
    public function getDecimal()
    {
        return $this->getInteger() + .50;
    }

    /**
     * Get random float
     *
     * @return float
     */
    public function getFloat()
    {
        return $this->getDecimal();
    }

    /**
     * Get boolean
     *
     * @return boolean
     */
    public function getBoolean()
    {
        return 0;
    }

    /**
     * Get random name
     *
     * @return string
     */
    public function getName()
    {
        return $this->random(static::$values['names']);
    }

    /**
     * Get random title
     *
     * @return string
     */
    public function getTitle()
    {
        $adjectives = array(
            'Great',
            'Amazing',
            'Silly',
            'Inspiring',
            'First'
        );

        return 'My ' . $this->random($adjectives) . ' Title';
    }

    /**
     * Get random email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->random(static::$values['emails']);
    }

    public function getDomain()
    {
        return $this->random(static::$values['domains']);
    }

    public function getCompany()
    {
        return $this->random(static::$values['companies']);
    }

    /**
     * Get telephone number
     *
     * @return string
     */
    public function getPhone()
    {
        return '555-55-5555';
    }

    /**
     * Get random age
     *
     * @return string
     */
    public function getAge()
    {
        return $this->getInteger();
    }

    /**
     * Get some random Lorem text
     *
     * @return string
     */
    public function getText()
    {
        return $this->random(static::$values['texts']);
    }

    /**
     * Get some random Street name
     *
     * @return string
     */
    public function getStreet()
    {
        $streets = array('Baker', 'First', 'Main', 'Second', 'Broad');

        return $this->random($streets);
    }

    /**
     * Get some random street extension
     *
     * @return string
     */
    public function getStreetExtension()
    {
        $extensions = array('Ave', 'St', 'Circle', 'Road');

        return $this->random($extensions);
    }

    /**
     * Get some city name
     *
     * @return string
     */
    public function getCity()
    {
        $cities = array('Nashville', 'Chattanooga', 'London', 'San Francisco', 'Bucksnort');

        return $this->random($cities);
    }

    /**
     * Get some random state
     *
     * @return string
     */
    public function getState()
    {
        $states = array('TN', 'WA', 'MA', 'CA');

        return $this->random($states);
    }

    /**
     * Get some random zip code
     *
     * @return string
     */
    public function getZip()
    {
        $zips = array(37121, 42198, 34189, 37115);

        return $this->random($zips);
    }

    /**
     * Get dummy website address
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->random(static::$values['websites'])['site'];
    }

    /**
     * Get random address
     *
     * @return string
     */
    public function getAddress()
    {
        $address = $this->getInteger() . ' ' . $this->getStreet() . ' ' . $this->getStreetExtension() . PHP_EOL;
        $address .= $this->getCity() . ', ' . $this->getState() . ' ' . $this->getZip();

        return $address;
    }

    /**
     * Get current MySQL-formatted date
     *
     * @return string
     */
    public function getDatetime()
    {
        return $this->random(static::$values['dates']) . date('H:i:s');
    }

    /**
     * Get current time
     */
    public function getTime()
    {
        return time();
    }

    /**
     * Get current MySQL-formatted date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->random(static::$values['dates']);
    }

    /**
     * Return random item from provided array
     *
     * @param  array $arr
     * @return string
     */
    protected function random(array $arr)
    {
        return $arr[array_rand($arr, 1)];
    }
}
