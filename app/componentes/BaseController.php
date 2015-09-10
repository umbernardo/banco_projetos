<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class BaseController extends CupNucleo {

    public $template = 'main_template';

    /**
     * 
     * @var CupMailer 
     */
    public $mailer;

    /**
     *
     * @var EntityManager 
     */
    public $em;

    /**
     *
     * @var UserHelper 
     */
    public $userHelper;

    public function __construct(array $config) {
        parent::__construct($config);
        $this->mailer = new CupMailer($config);
        $this->em = $this->getEntityManager($config);
        $this->userHelper = new UserHelper($this->em);
    }

    public function getTextoGeral($cod) {
        $obj = $this->listar('tbl_sys_textos_gerais', '', 1, 1, ' where cod="' . $cod . '"');
        $texto = $obj->registros;
        if (empty($texto)) {
            $sql = "INSERT INTO `tbl_sys_textos_gerais` (`id`, `cod`, `nome`, `descricao`, `ordem`, `ativo`) VALUES (NULL, '$cod', '$cod', 'TEXTO GERENCIAVEL PELO PAINEL (COD:$cod)', '0', 'Sim');";
            $this->db->query($sql);
            return $this->getTextoGeral($cod);
        } else {
            return reset($texto)->descricao;
        }
    }

    public function getEntityManager($config) {
        if ($this->em instanceof EntityManager) {
            return $this->em;
        }
        $entitiesPaths = array(dirname(__FILE__) . '/../entidades/');
        $isDevMode = $config['debug'];
        $connectionParams = array(
            'dbname' => $config['database']['dbname'],
            'user' => $config['database']['user'],
            'password' => $config['database']['password'],
            'host' => $config['database']['host'],
            'driver' => 'pdo_mysql',
            'charset' => 'utf8',
            'driverOptions' => array(
                1002 => 'SET NAMES utf8'
            )
        );
        $proxyDir = dirname(__FILE__) . '/../proxy/';
        $setupConfig = Setup::createAnnotationMetadataConfiguration($entitiesPaths, $isDevMode, $proxyDir);
        $setupConfig->addCustomStringFunction('rand', 'Mapado\MysqlDoctrineFunctions\DQL\MysqlRand');
        $entityManager = EntityManager::create($connectionParams, $setupConfig);
        return $entityManager;
    }

    public function control_g() {
        if ($_SERVER['HTTP_HOST'] == 'localhost' && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $s = scandir('app/content/views/');
            foreach ($s as $f) {
                if ($f != '.' && $f != '..') {
                    $view = str_replace('.php', '', $f);
                    $controller = str_replace('-', '_', $view);
                    $this->renderizarParcial('g', array('view' => $view, 'controller' => $controller));
                }
            }
        } else {
            $this->redirect('home');
        }
    }

}
