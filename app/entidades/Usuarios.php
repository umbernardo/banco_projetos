<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Usuarios
 *
 * @Table(name="tbl_usuarios")
 * @Entity
 */
class Usuarios extends BaseEntity {

    /**
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Projetos[]
     * @OneToMany(targetEntity="Projetos", mappedBy="usuario")
     * */
    private $projetos;

    /**
     * @var string
     *
     * @Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @Column(name="email", type="string", unique=true, length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="senha", type="string", length=255, nullable=false)
     */
    private $senha;

    /**
     * @var string
     *
     * @Column(name="cpf", type="string", length=255, nullable=false)
     */
    private $cpf;

    /**
     * @var string
     *
     * @Column(name="cidade", type="string", length=255, nullable=false)
     */
    private $cidade;

    /**
     * @var string
     *
     * @Column(name="uf", type="string", length=255, nullable=false)
     */
    private $uf;

    /**
     * @var string
     *
     * @Column(name="endereco", type="string", length=255, nullable=false)
     */
    private $endereco;

    /**
     * @var string
     *
     * @Column(name="numero", type="string", length=255, nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @Column(name="complemento", type="string", length=255, nullable=false)
     */
    private $complemento;

    function __construct(array $data = array()) {
        $this->projetos = new ArrayCollection();
        return parent::__construct($data);
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getUf() {
        return $this->uf;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getNumero() {
        return $this->numero;
    }

    function getComplemento() {
        return $this->complemento;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    /**
     * 
     * @return ArrayCollection
     */
    function getProjetos() {
        return $this->projetos;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setSenha($senha) {
        $this->senha = UserHelper::password_hash($senha);
        return $this;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
        return $this;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
        return $this;
    }

    function setUf($uf) {
        $this->uf = $uf;
        return $this;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
        return $this;
    }

    function setNumero($numero) {
        $this->numero = $numero;
        return $this;
    }

    function setComplemento($complemento) {
        $this->complemento = $complemento;
        return $this;
    }

}
