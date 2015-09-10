<?php

class SiteController extends BaseController {

    public function control_login() {
        $this->titulo = 'Login';
        if ($this->userHelper->usuarioEstaLogado()) {
            return $this->redirect('projetos/home');
        }
        if ($this->isPostRequest) {
            $usuario = filter_input(INPUT_POST, 'email');
            $senha = filter_input(INPUT_POST, 'senha');
            $tentativaLogin = $this->userHelper->logar($usuario, $senha);
            if (false !== $tentativaLogin) {
                return $this->redirect('projetos/home');
            }
            $this->adicionarMensagemErro('Usuário ou senha inválido');
        }
        return $this->renderizar('login');
    }

    public function control_logout() {
        $this->titulo = 'Logout';
        $this->userHelper->deslogar();
        return $this->redirect('home');
    }

    public function control_cadastro_projetos() {
        return $this->renderizar('cadastro-projetos', array());
    }

    public function control_cadastro() {
        $this->titulo = 'Cadastre-se';
        if ($this->isPostRequest) {
            $d = new Usuarios($_POST);
            try {
                $this->em->persist($d);
                $this->em->flush();
            } catch (Exception $ex) {
                $this->adicionarMensagemErro('Ocorreu um erro com seu cadastro, por favor verifique todos os campos');
                return $this->renderizar('cadastro', array(
                            'usuario' => $d,
                ));
            }
            return $this->redirect('cadastro-sucesso/');
        }
        return $this->renderizar('cadastro', array('usuario' => new Usuarios()));
    }

    public function control_recuperar_senha() {
        $this->titulo = 'Recuperar Senha';
        if ($this->isPostRequest) {
            $email = filter_input(INPUT_POST, 'email');
            $usuario = $this->getUsuarioByEmail($email);
            if (!$usuario instanceof Usuarios) {
                $this->adicionarMensagemErro('Nenhum usuário encontrado com o e-mail : ' . $email);
                return $this->redirect('recuperar-senha');
            }
            $url = $this->url(array('verifica', base64_encode($usuario->getEmail()), $this->codificaUsuario($usuario)), $this->siteUrl);
            if ($this->mailer->enviaEmail(array('url' => $url, 'usuario' => $usuario), $usuario->getEmail(), 'Recuperação de senha', 'email_recuperar_senha')) {
                $this->adicionarMensagemSucesso('Um link de confirmação foi enviado ao seu e-mail. Caso não encontre procure-o na caixa de spam.');
            }
        }
        $this->renderizar('recuperar-senha');
    }

    public function control_verifica($cryptMail, $cod) {
        $email = base64_decode($cryptMail);
        $usuario = $this->getUsuarioByEmail($email);
        if (!$usuario instanceof Usuarios) {
            return $this->erro_404();
        }
        if ($this->codificaUsuario($usuario) !== $cod) {
            return $this->erro_404();
        }
        $novaSenha = $this->userHelper->generateRandomPassword();
        $usuario->setSenha($novaSenha);
        $this->em->flush();
//        $this->adicionarMensagemSucesso('Atenção : Sua nova senha é "' . $novaSenha . '"  (sem aspas)');
        $this->userHelper->salvarUsuarioNaSessao($usuario);
        return $this->renderizar('senha-alterada', array('senha' => $novaSenha));
    }

    public function control_projetos($paginaSolicitada) {
        if (!$this->userHelper->usuarioEstaLogado()) {
            return $this->redirect('login');
        }
        if (empty($paginaSolicitada)) {
            $paginaSolicitada = 'home';
        }

        $acao = self::sulfixo_controle . str_replace('-', '_', $paginaSolicitada);

        $controller = new ProjetosController($this);
        if (method_exists($controller, $acao)) {
            $reflection = new ReflectionMethod($controller, $acao);
            $qtdArgumentos = $reflection->getNumberOfParameters();
            $parametros = array();
            $i = 0;
            foreach ($_GET as $key => $value) {
                if (!empty($value) && $key != 'a' && $key != 'b' && $i <= $qtdArgumentos) {
                    $parametros[$i] = $value;
                }
                $i++;
            }
            if (count($parametros) < $qtdArgumentos) {
                $i = $qtdArgumentos - count($parametros);
                for ($index = 0; $index < $i; $index++) {
                    $parametros[$index + count($parametros) + 1] = '';
                }
            }
            return call_user_func_array(array($controller, $acao), $parametros);
        }
        $this->erro_404();
    }

    public function control_ser_desenvolvedor($id = 0) {
        if (!$this->userHelper->usuarioEstaLogado()) {
            return $this->redirect('login');
        }
        /* @var $projeto Projetos */
        $projeto = $this->em->find('Projetos', $id);
        if (!$projeto instanceof Projetos) {
            $this->erro_404();
        }
        if ($projeto->temDesenvolvedor) {
            $this->adicionarMensagemErro('Este projeto já contém um desenvolvedor');
            return $this->redirect('home');
        }
        $projeto->setDesenvolvedor($this->userHelper->getUsuarioLogado());
        $this->em->persist($projeto);
        $this->em->flush();
        $this->adicionarMensagemSucesso('Você se tornou o desenvolvedor do projeto ' . $projeto->getId());
        return $this->redirect('projeto-interna/' . $projeto->getId());
    }

    public function control_efetuar_cadastro() {
        $this->titulo = 'Cadastre-se';
        if ($this->isPostRequest) {
            $senhaTemporaria = UserHelper::generateRandomPassword();
            try {
                $d = new Usuarios($_POST);
                $this->em->persist($d);
                $this->em->flush();
            } catch (Exception $ex) {
                $this->adicionarMensagemErro('Ocorreu um erro com seu cadastro, por favor verifique todos os campos');
                $this->adicionarMensagemErro($ex->getMessage());
                return $this->renderizar('cadastro', array(
                            'usuario' => $d,
                ));
            }
            $this->mailer->enviaEmail(array('Usuário' => $d->getEmail(), 'Senha' => $_POST['senha'], 'nome' => $d->getNome()), $d->getEmail(), 'Seja bem vindo(a) ' . $d->getNome(), 'email_pos_cadastro');
            return $this->redirect('cadastro-sucesso/');
        }
        return $this->redirect('home');
    }

    public function control_cadastro_sucesso() {
        return $this->renderizar('cadastro-sucesso');
    }

    public function control_home() {
        return $this->renderizar('home', array());
    }

    public function control_projeto_interna($id) {
        $projeto = $this->em->find('Projetos', $id);
        if (!$projeto instanceof Projetos) {
            return $this->erro_404();
        }
        return $this->renderizar('projeto-interna', array(
                    'projeto' => $projeto
        ));
    }

    public function control_projetos_lista() {
        $diaSelecionado = 0;
        $statusSelecionado = 'n';
        if ($this->isPostRequest) {
            $qb = $this->em->createQueryBuilder();
            $qb->select('p')->from('Projetos', 'p');
            if ($_POST['dias']) {
                $data = new DateTime('-' . (int) $_POST['dias'] . ' days');
                $qb->andWhere($qb->expr()->gte('p.dataInicio', ':dataInicio'));
                $qb->setParameter('dataInicio', $data);
            }
            if ($_POST['status'] != 'n') {
                $qb->andWhere($qb->expr()->eq('p.status', ':status'));
                $qb->setParameter('status', $_POST['status']);
            }
            $projetos = $qb->getQuery()->getResult();
        } else {
            $projetos = $this->em->getRepository('Projetos')->findAll();
        }
        return $this->renderizar('projetos-lista', array(
                    'projetos' => $projetos,
                    'diaSelecionado' => $diaSelecionado,
                    'statusSelecionado' => $statusSelecionado,
        ));
    }

    public function control_sobre() {
        return $this->renderizar('sobre', array());
    }

    public function getUsuarioByEmail($email) {
        return $this->em->getRepository('Usuarios')->findOneBy(array('email' => $email));
    }

    public function codificaUsuario(Usuarios $usuario) {
        return md5($usuario->getNome() . $usuario->getSenha());
    }

}
