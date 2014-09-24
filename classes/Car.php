<?php

/**
 * Car Class
 */
class Car extends Model
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
     * Id de la marca
     * @var int
     */
    public $marcaId;

    /**
     * Marca
     * @var string
     */
    public $marca;

    /**
     * Id del modelo
     * @var int
     */
    public $modeloId;

    /**
     * Modelo
     * @var string
     */
    public $modelo;

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
     * Mileage
     * @var int
     */
    public $mileage;

    /**
     * Fuel Type
     * @var int
     */
    public $fuel;

    /**
     * Bodywork
     * @var int
     */
    public $bodywork;

    /**
     * Description
     * @var string
     */
    public $desciption;

    /**
     * productDate
     * @var string
     */
    public $productDate;

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

    public $fuels = array(
        1 => "Gasolina",
        2 => "Diésel",
        3 => "Eléctrico/Híbrido",
        4 => "Otros",
    );

    public static $reservedVarsChild = array("fuels");

    /**
     * Class initialization
     *
     * @return void
     */
    public function init()
    {
        parent::$dbTable = "cars";
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
        $query = "SELECT * FROM `cars` WHERE 1=1 ";
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
                    $results[] = new Car($row);
                }

                return $results;
            }
        }
    }
}
