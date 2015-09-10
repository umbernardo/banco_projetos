<?php

class ProjetosController extends BaseController
{

    /**
     * Instancia do SiteController
     * @var BaseController
     */
    private $app;

    function __construct(BaseController $app)
    {
        $this->app = $app;
    }

    public function control_home()
    {
        $projetos = $this->getUsuario()->getProjetos();

        return $this->app->renderizar('projetos/listagem', array(
            'projetos' => $projetos,
        ));
    }

    public function control_cadastro()
    {
        $this->app->titulo = 'Cadastre-se';
        if ($this->app->isPostRequest) {
            $_POST['dataInicio'] = $this->getDateTimeFromPost('dataInicio');
            $_POST['arquivo'] = $this->salvarArquivo();
            $d = new Projetos($_POST);
            try {
                $d->setUsuario($this->getUsuario());
                $this->app->em->persist($d);
                $this->app->em->flush();
            } catch (Exception $ex) {
                $this->app->adicionarMensagemErro($ex->getMessage());
                $this->app->adicionarMensagemErro('Ocorreu ao cadastrar o projeto, por favor verifique todos os campos');

                return $this->app->renderizar('projetos/cadastro', array(
                    'usuario' => $d,
                ));
            }
            $this->app->adicionarMensagemSucesso('Seu projeto foi cadastrado com sucesso.');

            return $this->app->redirect('projetos');
        }

        return $this->app->renderizar('projetos/cadastro', array(
            'projeto' => new Projetos(),
        ));
    }

    public function control_meus_dados()
    {
        $user = $this->getUsuario();
        if ($this->app->isPostRequest) {
            try {
                $user->setValues($_POST);
                $this->app->em->persist($user);
                $this->app->em->flush();
                $this->app->adicionarMensagemSucesso('Dados atualizados com sucesso');
            } catch (Exception $e) {
                $this->app->adicionarMensagemErro('Ocorreu um erro e seus dados não foram salvos');
            }
        }

        return $this->app->renderizar('projetos/meus-dados', array(
            'usuario' => $user,
        ));
    }

    public function control_alterar_senha()
    {
        $user = $this->getUsuario();
        if ($this->app->isPostRequest) {

            try {
                if (false == UserHelper::password_verify($_POST['senha'], $user->getSenha())) {
                    $this->app->adicionarMensagemErro('A senha informada é inválida');

                    return $this->app->redirect('projetos/alterar-senha');
                }

                if ($_POST['senha_nova'] != $_POST['senha_confirmacao']) {
                    $this->app->adicionarMensagemErro('A senha e a confirmação da senha são diferentes');

                    return $this->app->redirect('projetos/alterar-senha');
                }

                $user->setSenha($_POST['senha_nova']);
                $this->app->em->persist($user);
                $this->app->em->flush();
                $this->app->adicionarMensagemSucesso('Sua senha foi atualizada com sucesso');
            } catch (Exception $e) {
                $this->app->adicionarMensagemErro('Ocorreu um erro e sua senha não foi alterada');
            }

        }

        return $this->app->renderizar('projetos/alterar-senha');
    }


    /**
     * Usuario Logado
     * @return Usuarios
     */
    public function getUsuario()
    {
        return $this->app->userHelper->getUsuarioLogado();
    }

    public function salvarArquivo()
    {
        if (isset($_FILES)) {
            foreach ($_FILES as $key => $value) {
                if ((!empty($value['name'])) && ($value['error'] == 0)) {
                    $nmExplode = explode('.', $value['name']);
                    $code = substr(md5(rand() . time()), 0, 15);
                    $ext = strtolower(end($nmExplode));
                    $caminho = 'uploads/projetos/';
                    move_uploaded_file($value['tmp_name'], $caminho . $code . "." . $ext);

                    return $code . "." . $ext;
                }
            }
        }
    }

    public function getDateTimeFromPost($campo)
    {
        $f = filter_input(INPUT_POST, $campo);
        $d = date_create_from_format('d/m/Y', $f);

        return $d;
    }

    /**
     * @param $email
     * @return Usuarios
     */
    public function getUserByEmailOrCreateUser($email)
    {
        $user = $this->getUserByEmail($email);
        if (false == $user instanceof Usuarios) {
            $user = new Usuarios(array('nome' => $email));
            $this->app->em->persist($user);
        }

        return $user;
    }

    /**
     * @param $email
     * @return Usuarios|null
     */
    public function getUserByEmail($email)
    {
        return $this->app->em->getRepository('Usuarios')->findOneBy(array('email' => $email));
    }

}
