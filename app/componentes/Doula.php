<?php

class Doula extends BaseController {

    private $id;
    private $id_plano;
    private $nome;
    private $email;
    private $telefone;
    private $celular;
    private $site;
    private $formacao_geral;
    private $formacao_doula;
    private $atuacao;

    public function __construct(array $dados) {
        $this->hydrate($dados);
        parent::__construct(Site::$static_config);
    }

    /**
     * Busca uma doula existente no banco de dados
     * @param int $id
     * @return Doula
     */
    public static function buscarPorId($id) {
        $doula = new Self;
        $obj = $doula->ver(tbl_doulas, $id);
        if ($id !== $obj->id) {
            return false;
        }
        $this->hydrate((array) $doula);
        return $doula;
    }

    public function validar() {
        $plano = $this->ver('tbl_planos', $this->id_plano);
        if ($plano->id != $this->id_plano) {
            $this->adicionarMensagemErro('Plano selecionado é inválido');
            return false;
        }

        $qryEmail = $this->db->prepare('SELECT count(email) as existe FROM `tbl_doulas` WHERE LOWER(email) = LOWER(:email)');
        if ($qryEmail->execute(array('email' => $this->getEmail()))) {
            if ('0' != $qryEmail->fetch(PDO::FETCH_OBJ)->existe) {
                $this->adicionarMensagemErro('Seu e-mail já está cadastrado em nosso banco de dados. Caso você tenha esquecido a senha por favor vá em "Esqueci minha senha" na página de login.');
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    public function salvar() {
        if ($this->validar()) {
            if ($this->id == null) {
                return $this->inserir();
            }
            return $this->atualizar();
        }
        return false;
    }

    public function inserir() {
        $dados = array(
            'id_plano' => $this->id_plano,
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'celular' => $this->celular,
            'site' => $this->site,
            'formacao_geral' => $this->formacao_geral,
            'formacao_doula' => $this->formacao_doula,
            'atuacao' => $this->atuacao,
        );
        $query = $this->db->prepare("INSERT INTO tbl_doulas (id, id_plano, nome, email, telefone, celular, site, formacao_geral, formacao_doula, atuacao, ordem, ativo) VALUES (NULL,:id_plano, :nome, :email, :telefone, :celular, :site, :formacao_geral, :formacao_doula, :atuacao, 0, 'Sim');");
        $execution = $query->execute($dados);
        if (true == $execution) {
            $this->id = $this->db->lastInsertId();
        }
        return $execution;
    }

    public function atualizar() {
        
    }

    public function hydrate(array $dados) {
        foreach ($dados as $campo => $valor) {
            if (property_exists($this, $campo)) {
                $this->$campo = $valor;
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getPlano() {
        return $this->ver('tbl_planos', $this->id_plano);
    }

    public function getIdPlano() {
        return $this->id_plano;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getCelular() {
        return $this->celular;
    }

    function getSite() {
        return $this->site;
    }

    function getFormacao_geral() {
        return $this->formacao_geral;
    }

    function getFormacao_doula() {
        return $this->formacao_doula;
    }

    function getAtuacao() {
        return $this->atuacao;
    }

}
