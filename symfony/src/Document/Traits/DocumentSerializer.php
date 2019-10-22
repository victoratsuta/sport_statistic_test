<?php


namespace App\Document\Traits;



use App\Document\BaseDocument;

trait DocumentSerializer {
    private $_ignoreFields = array();
    /**
     * Convert Doctrine\ODM Document to Array
     *
     * @return array
     */
    function toArray() {
        $document = $this->toStdClass();
        return get_object_vars($document);
    }
    /**
     * Convert Doctrine\ODM Document to Array
     *
     * @return string
     */
    function toJSON() {
        $document = $this->toStdClass();
        return json_encode($document);
    }
    /**
     * Set properties to ignore when serializing
     *
     * @example  $this->setIgnoredFields(array('createdDate', 'secretFlag'));
     *
     * @param array $fields
     */
    function setIgnoredFields(array $fields) {
        $this->_ignoreFields = $fields;
    }
    /**
     * Convert Doctrine\ODM Document to plain simple stdClass
     *
     * @return \stdClass
     */
    function toStdClass()
    {
        $document = new \stdClass();
        foreach($this->findGetters() as $getter) {

            if($getter === "getProxyInitializer"){
                continue;
            }

            $prop = lcfirst(substr($getter, 3));
            if(! in_array($prop, $this->_ignoreFields)) {
                $value = $this->$getter();
                $document->$prop = $this->formatValue($value);
            }
        }
        return $document;
    }
    private function findGetters()
    {
        $funcs = get_class_methods(get_class($this));
        $getters = array();
        foreach($funcs as $func) {
            if(strpos($func, 'get') === 0) {
                $getters[] = $func;
            }
        }
        return $getters ;
    }
    private function formatValue($value) {

        if(!$value){
            return  $value;
        }

        if($value instanceof BaseDocument){
            return  $value->toArray();
        }

        if(is_scalar($value) || is_array($value)) {
            return $value;
            // If the object uses this trait
        } elseif (in_array(__TRAIT__, class_uses(get_class($value)))) {
            return $value->toStdClass();
            // If it's a collection, format each value
        } elseif (is_a($value, 'Doctrine\ODM\MongoDB\PersistentCollection')) {
            $prop = array();
            foreach($value as $k => $v) {
                $prop[] = $this->formatValue($v);
            }
            return $prop;
            // If it's a Date, convert to unix timestamp
        } else if(is_a($value, 'DateTime')) {
            return $value;
            // Otherwise leave a note that this type is not formatted
            // So that I can add formatting for this missed class
        } else {
            return 'Not formatted in DocumentSerializer: '. get_class($value);
        }
    }

}