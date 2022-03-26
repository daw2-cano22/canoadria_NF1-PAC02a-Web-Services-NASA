<?php

class Sols_keys extends DataBoundObject {

        protected $code;

        protected function DefineTableName() {
                return("sols_keys");
        }

        protected function DefineRelationMap() {
                return(array(
                        "code" => "code"));
        }

        public function setCode($code) {
                $this->code = $code;
                $this->arModifiedRelations["code"] = $this->code;
        }

        public function getCode() {
                return $this->code;
        }
}
?>