<?php

class Sols_checked extends DataBoundObject {

        protected $code;

        protected function DefineTableName() {
                return("sols_checked");
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