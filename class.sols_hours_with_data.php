<?php

class Sols_hours_with_data extends DataBoundObject {

        protected $code;
        protected $type;
        protected $value;

        protected function DefineTableName() {
                return("sols_hours_with_data");
        }

        protected function DefineRelationMap() {
                return(array(
                        "code" => "code",
                        "type" => "type",
                        "value" => "value"));
        }

        public function setCode($code) {
                $this->code = $code;
                $this->arModifiedRelations["code"] = $this->code;
        }

        public function setType($type) {
                $this->type = $type;
                $this->arModifiedRelations["type"] = $this->type;
        }

        public function setValue($value) {
                $this->value = $value;
                $this->arModifiedRelations["value"] = $this->value;
        }

        public function getCode() {
                return $this->code;
        }

        public function getType($type) {
                return $this->type;
        }

        public function getValue($value) {
                return $this->value;
        }
}
?>