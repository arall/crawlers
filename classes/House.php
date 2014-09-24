<?php

/**
 * House Class
 */
class House extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;

    /**
     * Id del anuncio
     * @var int
     */
    public $websiteId;

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * URL
     * @var string
     */
    public $url;

    /**
     * Nº of rooms
     * @var int
     */
    public $rooms;

    /**
     * Nº of bathrooms
     * @var int
     */
    public $bathrooms;

    /**
     * Year
     * @var int
     */
    public $year;

    /**
     * Price
     * @var int
     */
    public $price;

    /**
     * Type
     * @var string
     */
    public $type;

    /**
     * Zone
     * @var string
     */
    public $zone;

    /**
     * Postal Code
     * @var string
     */
    public $cp;

    /**
     * Address
     * @var string
     */
    public $address;

    /**
     * Coords lat
     * @var string
     */
    public $lat;

    /**
     * Coords long
     * @var string
     */
    public $lon;

    /**
     * Meters
     * @var int
     */
    public $m2;

    /**
     * Parking
     * @var bool
     */
    public $parking;

    /**
     * Features (json)
     * @var string
     */
    public $features;

    /**
     * Furnished
     * @var bool
     */
    public $furnished;

    /**
     * Description
     * @var string
     */
    public $description;

    /**
     * Publish date
     * @var string
     */
    public $date;

    /**
     * Insert date
     * @var string
     */
    public $dateInsert;

    /**
     * Update date
     * @var string
     */
    public $dateUpdate;

    public static $reservedVarsChild = array();

    /**
     * Class initialization
     *
     * @return void
     */
    public function init()
    {
        parent::$dbTable = "houses";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Pre-Insert actions
     *
     * Creation date
     *
     * @return void
     */
    public function preInsert()
    {
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    /**
     * Pre-Update actions
     *
     * Update date
     *
     * @return void
     */
    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    /**
     * Object selection
     *
     * @param array   $data       Conditionals and Order values
     * @param integer $limit      Limit
     * @param integer $limitStart Limit start
     * @param int     $total      Total rows found
     *
     * @return array Objects found
     */
    public static function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $params = array();
        $query = "SELECT * FROM `houses` WHERE 1=1 ";
        //Total
        $total = count($db->Query($query, $params));
        if ($total) {
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                if (@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY `".$data['order']."` ".$data['orderDir'];
                }
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query, $params);
            if (count($rows)) {
                $results = array();
                foreach ($rows as $row) {
                    $results[] = new House($row);
                }

                return $results;
            }
        }
    }
}
