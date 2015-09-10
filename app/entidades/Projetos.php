<?php

/**
 * Projetos
 *
 * @Table(name="tbl_projetos")
 * @Entity
 */
class Projetos extends BaseEntity {

    /**
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Usuarios", inversedBy="projetos")
     * @JoinColumn(name="id_usuario", referencedColumnName="id")
     * */
    private $usuario;

    /**
     * @var string
     *
     * @Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var DateTime
     *
     * @Column(name="data_inicio", type="date", nullable=false)
     */
    private $dataInicio;

    /**
     * @var string
     *
     * @Column(name="status", type="string", length=255,nullable=false)
     */
    private $status;

    /**
     * @ManyToOne(targetEntity="Usuarios")
     * @JoinColumn(name="id_coordenador", referencedColumnName="id")
     * */
    private $coordenador;

    /**
     * @ManyToOne(targetEntity="Usuarios")
     * @JoinColumn(name="id_desenvolvedor", referencedColumnName="id")
     * */
    private $desenvolvedor;

    /**
     * @var string
     *
     * @Column(name="nome_demandante", type="string", length=255,nullable=false)
     */
    private $nomeDemandante;

    /**
     * @var string
     *
     * @Column(name="instituicao_demandante", type="string", length=255,nullable=false)
     */
    private $instituicaoDemandante;

    /**
     * @var string
     *
     * @Column(name="email_demandante", type="string", length=255,nullable=false)
     */
    private $emailDemandante;

    /**
     * @var string
     *
     * @Column(name="resumo", type="text", nullable=false)
     */
    private $resumo;

    /**
     * @var string
     *
     * @Column(name="arquivo", type="text", nullable=false)
     */
    private $arquivo;

    const status_nao_atribuido = 'nao_atribuido';
    const status_em_desenvolvimento = 'desenvolvimento';
    const status_concluido = 'concluido';
    const status_implantado = 'implantado';
    const texto_status_nao_atribuido = 'Não atribuido';
    const texto_status_em_desenvolvimento = 'Em desenvolvimento';
    const texto_status_concluido = 'Concluído';
    const texto_status_implantado = 'Implantado';

    function getId() {
        return $this->id;
    }

    /**
     * 
     * @return Usuarios
     */
    function getUsuario() {
        return $this->usuario;
    }

    function getNome() {
        return $this->nome;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getStatusDb() {
        return $this->status;
    }

    function getTextoStatus() {
        switch ($this->status) {
            case self::status_nao_atribuido:
                return self::texto_status_nao_atribuido;
            case self::status_em_desenvolvimento:
                return self::texto_status_em_desenvolvimento;
            case self::status_concluido:
                return self::texto_status_concluido;
            case self::status_implantado:
                return self::texto_status_implantado;
        }
    }

    public static function getListaStatus() {
        return array(
            self::status_nao_atribuido => self::texto_status_nao_atribuido,
            self::status_em_desenvolvimento => self::texto_status_em_desenvolvimento,
            self::status_concluido => self::texto_status_concluido,
            self::status_implantado => self::texto_status_implantado,
        );
    }

    function getCoordenador() {
        return $this->coordenador;
    }

    function getDesenvolvedor() {
        return $this->desenvolvedor;
    }
    
    function getNomeDemandante() {
        return $this->nomeDemandante;
    }

    function getInstituicaoDemandante() {
        return $this->instituicaoDemandante;
    }

    function getEmailDemandante() {
        return $this->emailDemandante;
    }

    function getResumo() {
        return $this->resumo;
    }

    function setUsuario(Usuarios $usuario) {
        $this->usuario = $usuario;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    /* ---- */

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDataInicio(DateTime $dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCoordenador(Usuarios $coordenador) {
        $this->coordenador = $coordenador;
    }

    function setDesenvolvedor(Usuarios $desenvolvedor) {
        $this->desenvolvedor = $desenvolvedor;
    }

    function setNomeDemandante($nomeDemandante) {
        $this->nomeDemandante = $nomeDemandante;
    }

    function setInstituicaoDemandante($instituicaoDemandante) {
        $this->instituicaoDemandante = $instituicaoDemandante;
    }

    function setEmailDemandante($emailDemandante) {
        $this->emailDemandante = $emailDemandante;
    }

    function setResumo($resumo) {
        $this->resumo = $resumo;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    function temArquivo() {
        return !empty($this->arquivo);
    }
    
    function temDesenvolvedor(){
        return $this->desenvolvedor instanceof Usuarios;
    }

}
