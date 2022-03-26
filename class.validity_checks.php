<?php

class Validity_Checks extends DataBoundObject {

        protected $code;
        protected $type;
        protected $isValid;

        protected function DefineTableName() {
                return("validity_checks");
        }

        protected function DefineRelationMap() {
                return(array(
                        "code" => "code",
                        "type" => "type",
                        "isvalid" => "isvalid"));
        }

        public function setCode($code) {
                $this->code = $code;
                $this->arModifiedRelations["code"] = $this->code;
        }

        public function setType($type) {
                $this->type = $type;
                $this->arModifiedRelations["type"] = $this->type;
        }

        public function setIsValid($isValid) {
                $this->isValid = $isValid;
                $this->arModifiedRelations["isvalid"] = $this->isValid;
        }

        public function getCode() {
                return $this->code;
        }

        public function getType() {
                return $this->type;
        }

        public function getIsValid() {
                return $this->isValid;
        }
}
?>