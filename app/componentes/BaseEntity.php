<?php

class BaseEntity {

    function __construct(array $data = array()) {
        $this->setValues($data);
    }

    public function setValues(array $dados) {
        foreach ($dados as $campo => $valor) {
            if (method_exists($this, 'set' . ucfirst($campo))) {
                $method = 'set' . ucfirst($campo);
                $this->$method($valor);
            }
        }
    }

}
