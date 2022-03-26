<?php

class Validity_checks_parameters extends DataBoundObject {

        protected $key;
        protected $value;

        protected function DefineTableName() {
                return("validity_checks_parameters");
        }

        protected function DefineRelationMap() {
                return(array(
                        "key" => "key",
                        "value" => "value"));
        }

        public function setKey($key) {
                $this->key = $key;
                $this->arModifiedRelations["key"] = $this->key;
        }

        public function setValue($value) {
                $this->value = $value;
                $this->arModifiedRelations["value"] = $this->value;
        }

        public function getKey() {
                return $this->key;
        }

        public function getValue() {
                return $this->value;
        }
}
?>