<?php

use Doctrine\ORM\EntityManager;

class UserHelper {

    const sessionUserAlias = 'usuario_logado';

    /**
     *
     * @var EntityManager 
     */
    private $em;

    /**
     *
     * @var Usuarios 
     */
    private $usuarioLogado;

    function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function usuarioEstaLogado() {
        return !empty($_SESSION[self::sessionUserAlias]['id']);
    }

    /**
     * Retorna a instancia da Doula/Usuário Logado
     * @return Usuarios
     */
    public function getUsuarioLogado() {
        if (!$this->usuarioLogado instanceof Usuarios) {
            $this->reloadUsuarioLogado();
        }
        return $this->usuarioLogado;
    }

    public function reloadUsuarioLogado() {
        $this->usuarioLogado = $this->em->getRepository('Usuarios')->find($_SESSION[self::sessionUserAlias]['id']);
    }

    public function logar($email, $senha) {
        $usuario = $this->em->getRepository('Usuarios')->findOneBy(array('email' => $email));
        if (!$usuario instanceof Usuarios) {
            return false;
        }
        if (self::password_verify($senha, $usuario->getSenha())) {
            $this->salvarUsuarioNaSessao($usuario);
            return true;
        }
        return false;
    }

    public function deslogar() {
        if ($this->usuarioEstaLogado()) {
            session_destroy();
        }
    }

    public function salvarUsuarioNaSessao(Usuarios $doula) {
        $_SESSION[self::sessionUserAlias]['id'] = $doula->getId();
    }

    public static function generateRandomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public static function password_hash($password) {
        return md5($password . self::getHash());
    }

    public static function password_verify($password, $hash) {
        return md5($password . self::getHash()) == $hash;
    }

    public static function getHash() {
        return 'kgwij203jg0230';
    }

}
