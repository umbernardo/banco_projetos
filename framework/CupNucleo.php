<?php

class CupNucleo {

    const sulfixo_controle = 'control_';

    public $baseUrl = BASE_URL;
    public $siteUrl = URL_SITE;
    private $site;
    private $pastaTemplates = 'app/content/templates/';
    private $pastaViews = 'app/content/views/';
    public $titulo;
    public $tituloSite;
    public $template;
    public $paginaAtual;
    public $request;
    public $publicAssetsUrl;
    public $paginaSolicitada;

    /**
     * A Requisição foi via post ?
     * @var bool
     */
    public $isPostRequest;

    /**
     * Database Connection
     * @var PDO 
     */
    public $db;
    public $config;
    static $static_config;

    public function __construct(array $config) {
        self::$static_config = $config;
        $this->startSession();
        $this->config = $this->array_to_object($config);
        $this->tituloSite = $this->config->site->titulo;
        try {
            $this->db = new PDO("mysql:host=" . $this->config->database->host . ";dbname=" . $this->config->database->dbname, $this->config->database->user, $this->config->database->password);
        } catch (Exception $ex) {
            die('Erro ao conectar no banco de dados.');
        }
    }

    public function inicializar() {
        $this->startUrlAmigavel();
        ob_start();
        try {
            $this->isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';
            $this->processRequest();
            $this->dispatch();
        } catch (Exception $ex) {
            ob_clean();
            $this->erro_geral($ex);
        }
        ob_end_flush();
    }

    public function startSession() {
        if (function_exists('session_status')) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        } else {
            if (session_id() === '') {
                session_start();
            }
        }
    }

    public function processRequest() {
        if (empty($_GET['a'])) {
            $_GET['a'] = 'home';
        }
        $this->request = $this->array_to_object($_GET);
        $this->paginaSolicitada = str_replace('-', '_', $_GET['a']);
        $this->publicAssetsUrl = $this->url(array('public_assets'));
        if (empty($this->paginaSolicitada)) {
            $this->paginaSolicitada = 'home';
        }
        $this->paginaAtual = $_GET['a'];
    }

    public function dispatch() {
        $acao = self::sulfixo_controle . $this->paginaSolicitada;
        if (method_exists($this, $acao)) {
            $reflection = new ReflectionMethod($this, $acao);
            $qtdArgumentos = $reflection->getNumberOfParameters();
            $parametros = array();
            $i = 0;
            foreach ($_GET as $key => $value) {
                if (!empty($value) && $key != 'a' && $i <= $qtdArgumentos)
                    $parametros[$i] = $value;
                $i++;
            }

            if (count($parametros) < $qtdArgumentos) {
                $i = $qtdArgumentos - count($parametros);
                for ($index = 0; $index < $i; $index++) {
                    $parametros[$index + count($parametros) + 1] = '';
                }
            }
            call_user_func_array(array($this, $acao), $parametros);
        } else {
            $this->erro_404();
        }
    }

    public function site() {
        if (empty($this->site)) {
            $this->site = $this->array_to_object($this->siteDados());
        }
        return $this->site;
    }

    public function setUrlRetorno($url = array()) {
        $_SESSION['urlRetorno'] = $this->url($url, $this->siteUrl);
    }

    public function urlRetorno() {
        return $_SESSION['urlRetorno'];
    }

    public function resetUrlRetorno() {
        $this->setUrlRetorno();
    }

    public function retornoRegistroPadrao($tabela, $url = '', $pagina = 1, $qtd_registros = 0, $where_custom = 'where ativo = "Sim"', $campo_ordem = 'ordem', $campo_group = '') {
        //Adaptação do Where_Custom para array
        if (is_array($where_custom)) {
            foreach ($where_custom as $key => $value) {
                if (!empty($whereTemp))
                    $whereTemp .= ' and ';
                else
                    $whereTemp = ' where ';
                $whereTemp .= $key . ' = "' . $value . '" ';
            }
            $where_custom = $whereTemp;
        }

        $expldTbl = explode('tbl_', $tabela);
        $pasta_imagem = end($expldTbl);
        $sql = 'SELECT tbl.* FROM `' . $tabela . '` tbl ' . $where_custom;
        $sql_limit = '';
        if (!empty($campo_group)) {
            $sql .= ' group by ' . $campo_group;
        }

        if (trim(strtolower($campo_ordem)) == 'rand()') {
            $sql .=' order by ' . $campo_ordem . ' ';
        } else {
            $sql .=' order by tbl.' . $campo_ordem . ' ';
        }


        if (empty($pagina)) {
            $pagina = 1;
        }
        $primeiro_registro = ($pagina * $qtd_registros) - $qtd_registros;
        if ($primeiro_registro < 0) {
            $primeiro_registro = 0;
        }
        if ($qtd_registros != 0) {
            $sql_limit = ' LIMIT ' . $primeiro_registro . ',' . $qtd_registros;
        }
        $qry = $this->db->query($sql . $sql_limit . ';'); // or die('SQL EXECUTADO : ' . $sql . $sql_limit . ' ---------- ERROR : ' . $this->db->erroInfo());
        $erro_sql = $this->db->errorInfo();
        if (false === $qry && true === $this->config->debug) {
            $this->erro_geral(new Exception($erro_sql[2], $erro_sql[1]));
        }

        $retorno = array();
        if (false !== $qry) {
            if ($qry->rowCount() > 0) {
                while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($row as $key => $value) {
                        switch ($key) {
                            case 'nome' :
                                $row[$key] = utf8_encode($row[$key]);
                                $row[$key . '_url'] = $this->geraUrl($row[$key]);
                                break;
                            case 'nome_pt':
                            case 'nome_en':
                            case 'nome_es':
                                $row[$key] = utf8_encode($row[$key]);
                                $nm = explode('_', $key);
                                $row['nome_url_' . end($nm)] = $this->geraUrl($row[$key]);
                                break;
                            case 'descricao':
                                $row['resumo'] = utf8_encode($this->resumirStr($row['descricao']) . '...');
                                $row['descricao'] = utf8_encode($row['descricao']);
                                break;
                            case 'galeria' :
                                $row['galeria'] = $this->gerarGaleria($row['galeria'], $pasta_imagem);
                                if (!empty($row['galeria'])) {
                                    $row['galeria_capa'] = reset($row['galeria']);
                                } else {
                                    $row['galeria_capa'] = new stdClass();
                                }
                                break;
                            case 'video_url' :
                                $row['video'] = $this->gerarVideo($row['video_url']);
                                break;
                            case 'imagem' :
                            case 'imagem_destaque' :
                                $row[$key . '_original'] = $row[$key];
                                $row[$key] = $this->gerarGaleria($row[$key], $pasta_imagem);
                                if (!empty($row[$key])) {
                                    $row[$key] = end($row[$key]); //Fix para não ter que ficar rodando como so fosse galeria
                                }
                                break;
                            case 'data_envio':
                                $row['data_envio'] = $this->formatarData($row['data_envio']);
                                break;
                            default :
                                $row[$key] = utf8_encode($value);
                                break;
                        }
                    }
                    $row['tabela'] = $tabela;
                    array_push($retorno, $row);
                }
            }
        }


        /* paginacao------------------------------------------------------------------------------------------ */
        $paginacao = '';

        if ($qtd_registros != 0) {
            $sql_qtd = 'SELECT * FROM `' . $tabela . '` tbl ' . $where_custom;
            if (!empty($campo_group)) {
                $sql_qtd .= ' group by tbl.' . $campo_group;
            }

            if (trim(strtolower($campo_ordem)) == 'rand()') {
                $sql_qtd .=' order by ' . $campo_ordem . ' ';
            } else {
                $sql_qtd .=' order by tbl.' . $campo_ordem . ' ';
            }

            $qry_qtd = $this->db->query($sql_qtd);
            $total = $qry_qtd->rowCount();

            if ($total > $qtd_registros) {
                if ($qtd_registros != 0) {
                    $total_paginas = $total / $qtd_registros;
                } else {
                    $total_paginas = 2;
                }
                $prev = $pagina - 1;
                $next = $pagina + 1;
                $categoria = '';
                $total_paginas = ceil($total_paginas);
                $painel = "";
                $f = $pagina + 2;
                $f = ($f > $total_paginas) ? $total_paginas : $f;
                $n = $pagina - 2;
                $n = ($n < 1) ? 1 : $n;
                if ($n == 1 && $total_paginas > 5) {
                    $f = 5;
                } else {
                    $f = $pagina + 2;
                    $f = ($f <= $total_paginas) ? $f : $total_paginas;
                }
                for ($x = 1; $x <= $total_paginas; $x++) {
                    if ($x == $pagina) {
                        $painel .= '<li><a class="active" href="' . $url . $x . '">' . $x . '</a></li>';
                    } else {
                        $painel .= '<li><a class="paginacao-links" href="' . $url . $x . '">' . $x . '</a></li>';
                    }
                }
                /* Montagem da paginação em si conforme classes do bootstrap */
                if (!empty($painel)) {
                    $paginacao .= '<ul class="pagination">';

                    if ($prev != $pagina && $prev >= 1) {
                        $paginacao .= '<li class="first"> <a class="typcn typcn-arrow-left" href="' . $url . $prev . '">«</a></li>';
                    } else {
                        //$paginacao .= '<li class="disabled"> <a href="' . $url . $prev . '">&laquo;</a></li>';
                    }

                    $paginacao .= $painel;

                    if ($next != $pagina && $next <= $total_paginas) {
                        $paginacao .= '<li class="last"> <a class="typcn typcn-arrow-right" href="' . $url . $next . '">»</a></li>';
                    } else {
                        //$paginacao .= '<li class="disabled"> <a href="' . $url . $next . '">&raquo;</a></li>';
                    }

                    $paginacao .= '</ul>';
                }
            }
        }
        return array(
            'registros' => $retorno,
            'paginacao' => $paginacao,
            'pagina' => $pagina,
            'pasta_imagem' => $pasta_imagem,
            'tabela' => $tabela,
            'sql' => $sql,
            'erro_sql' => $erro_sql
        );
    }

    public function verRegistroPadrao($tabela, $id = 0) {
        $pastasArray = explode('tbl_', $tabela);
        $pasta_imagem = end($pastasArray);
        if (empty($id) || $id == 0) {
            $qryId = $this->db->query('select id from `' . $tabela . '` where ativo = "Sim" order by ordem')->fetch(PDO::FETCH_OBJ);
            if (false !== $qryId) {
                $id = $qryId->id;
            } else {
                return false;
            }
        } else {
            $id = intval($id);
        }
        $sqlQry = 'SELECT * FROM `' . $tabela . '` where ativo = "Sim" and id = ' . $id . '  order by ordem';
        $qry = $this->db->query($sqlQry);
        $erro_sql = $this->db->errorInfo();
        if (false === $qry) {
            $this->erro_geral(new Exception($erro_sql[2], $erro_sql[1]), array('sql_executado' => $sqlQry));
        }
        $row = $qry->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {
            foreach ($row as $key => $value) {
                switch ($key) {
                    case 'nome' :
                        $row[$key] = utf8_encode($row[$key]);
                        $row[$key . '_url'] = $this->geraUrl($row[$key]);
                        break;
                    case 'nome_pt':
                    case 'nome_en':
                    case 'nome_es':
                        $row[$key] = utf8_encode($row[$key]);
                        $nm = explode('_', $key);
                        $row['nome_url_' . end($nm)] = $this->geraUrl($row[$key]);
                        break;
                    case 'descricao':
                        $row['resumo'] = utf8_encode($this->resumirStr($row['descricao']) . '...');
                        $row['descricao'] = utf8_encode($row['descricao']);
                        break;
                    case 'galeria' :
                        $row['galeria'] = $this->gerarGaleria($row['galeria'], $pasta_imagem);
                        if (!empty($row['galeria'])) {
                            $row['galeria_capa'] = reset($row['galeria']);
                        } else {
                            $row['galeria_capa'] = new stdClass();
                        }
                        break;
                    case 'video_url' :
                        $row['video'] = $this->gerarVideo($row['video_url']);
                        break;
                    case 'imagem' :
                    case 'imagem_destaque' :
                        $row[$key . '_original'] = $row[$key];
                        $row[$key] = $this->gerarGaleria($row[$key], $pasta_imagem);
                        if (!empty($row[$key])) {
                            $row[$key] = end($row[$key]); //Fix para não ter que ficar rodando como so fosse galeria
                        }
                        break;
                    case 'data_envio':
                        $row['data_envio'] = $this->formatarData($row['data_envio']);
                        break;
                    default :
                        $row[$key] = utf8_encode($value);
                        break;
                }
            }
            $row['tabela'] = $tabela;
        } else {
            return; //Cai aqui quando estiver vazio
        }

        return $row;
    }

    /**
     * FUNÇÃO QUE RETORNA O verRegistroPadrao em forma de objeto
     */
    public function ver($tabela, $id = 0, $checar = false) {
        $d = $this->array_to_object($this->verRegistroPadrao($tabela, $id));
        if ($checar && $id != $d->id) {
            $this->erro_404();
            return;
        } else {
            return $d;
        }
    }

    /**
     * FUNÇÃO QUE RETORNA O retornoRegistroPadrao em forma de objeto
     */
    public function listar($tabela, $url = '', $pagina = 1, $qtd_registros = 0, $where_custom = 'where ativo = "Sim"', $campo_ordem = 'ordem', $campo_group = '') {
        return $this->array_to_object($this->retornoRegistroPadrao($tabela, $url, $pagina, $qtd_registros, $where_custom, $campo_ordem, $campo_group));
    }

    /*
     * 
     * Função padrão de inserção de registros
     * 
     */

    public function inserirRegistroPadrao($tabela, $dados = array(), $converter_utf8 = true) {
        if ($converter_utf8) {
            $dados = $this->arrayFromUtf8($dados);
        }
        if (!is_array($dados) || empty($dados)) {
            return false;
        }
        unset($dados['id']);
        $sql_campos = '`id`';
        $sql_valores = 'NULL';

        foreach ($dados as $key => $value) {
            $sql_campos .= ', `' . $key . '`';
            $sql_valores .= ", '" . $value . "'";
        }

        $sqlInsert = 'INSERT INTO `' . $tabela . '` (' . $sql_campos . ') VALUES (' . $sql_valores . ')';

        if (mysql_query($sqlInsert)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Função que retorna se um id existe em uma tabela
     */

    public function registroExiste($tabela, $id) {
        $tmp = $this->verRegistroPadrao($tabela, $id);
        return !empty($tmp);
    }

    /* Função padrão para API do Flickr------------------------------------------------------------------------------------------ */

    public function retornaGaleriaflickr() {
        $site = site_dados();
        require_once("flickr/phpFlickr.php");
        $f = new phpFlickr("KEY", "SECRET");
        $person = $f->people_findByUsername($flickr_channel);
        // Get the friendly URL of the user's photos
        $photos_url = $f->urls_getUserPhotos($person['id']);
        // Get the user's first 36 public photos
        $photos = $f->people_getPublicPhotos($person['id'], NULL, NULL, 9);
        $i = 0;
        foreach ((array) $photos['photos']['photo'] as $photo) {
            $retorno[$i]['photo'] = $photo;
            $retorno[$i]['photos_url'] = $photos_url;
            $retorno[$i]['url']['square'] = $f->buildPhotoURL($photo, "square");
            $retorno[$i]['url']['thumbnail'] = $f->buildPhotoURL($photo, "thumbnail");
            $retorno[$i]['url']['small'] = $f->buildPhotoURL($photo, "small");
            $retorno[$i]['url']['medium'] = $f->buildPhotoURL($photo, "medium");
            $retorno[$i]['url']['large'] = $f->buildPhotoURL($photo, "large");
            $retorno[$i]['url']['original'] = $f->buildPhotoURL($photo, "original");
            $i++;
        }
        return $retorno;
    }

    /* Funçoes referentes a redirecionamento------------------------------------------------------------------------------------------ */

    public function redirect($url, $interno = true) {
        //Caso parametro URL esteja em branco será redirecionado para a raíz (Home)
        if ($interno) {
            header('Location: ' . $this->baseUrl . $url);
        } else {
            header('Location: ' . $url);
        }
        exit;
    }

    /* Funções relacionadas a Busca padrão de registros passando apenas as tabelas para busca------------------------------------------------------------------------------------------ */

    public function busca($string = '', $tabelas = array('Nome da tabela:' => 'nometabela')) {
        $retorno = array();
        $string = $this->trataStringBusca($string);
        foreach ($tabelas as $key => $value) {
            $result = $this->buscaPadrao($string, $value);
            if (!empty($result))
                $retorno[$key] = $result;
        }
//        return $retorno;
        return $this->array_to_object($retorno);
    }

    /* Funções referentes ao tratamento de strings para busca */

    public function trataStringBusca($string) {
        $string = urldecode($string);
        if ((strpos($string, "'") === TRUE) or ( strpos($string, '"') === TRUE)) {
            $string = addslashes($string);
        }
        return $string;
    }

    /* Função referente a busca */

    public function buscaPadrao($string, $tabela) {
        $result = array();
        $pagina = $tabela;
        $sql = 'select * from tbl_' . $tabela . ' where ativo="Sim" ' . $this->geraBuscaWhere('tbl_' . $tabela, $string) . ' order by ordem DESC';
        $qry = $this->db->query($sql);
        $i = 1;
        if (!empty($area)) {
            $tabela = $area . '_produto';
        }
        while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
            $result[$i] = $this->verRegistroPadrao('tbl_' . $tabela, $row['id']);
            $result[$i]['pagina'] = $pagina;
            $i++;
        }
        return $result;
    }

    /*
     * Função que exibe os campos de uma tabela em formato de array
     */

    public function infoTabela($tabela) {
        $retorno = array();
        if (!empty($tabela)) {
            $sql = 'SHOW COLUMNS FROM  `' . $tabela . '`';
            try {
                $qry = $this->db->query($sql);
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
            while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
                array_push($retorno, $row);
            }
        }
        return $retorno;
    }

    /*
     * Função que trata os campos para a busca
     */

    public function geraBuscaWhere($tabela, $valor) {
        $retorno = '';
        $campos = $this->infoTabela($tabela);
        foreach ($campos as $key => $value) {
            switch ($value['Type']) {
                case 'varchar(255)':
                case 'longtext':
                case 'mediumtext':
                case 'text':
                    $retorno .= (empty($retorno)) ? ' and ' : ' or ';
                    $retorno .= $value['Field'] . ' like "%' . $valor . '%" ';
                    break;
            }
        }
        return $retorno;
    }

    public function dbg($var, $tipo = 2) {
        Utils::debug($var, $tipo);
    }

    public function replaceEmbeed($string, $largura, $altura) {
        $string = preg_replace("/height=\"[0-9]*\"/", "height='" . $altura . "'", $string);
        $string = preg_replace("/width=\"[0-9]*\"/", "width='" . $largura . "'", $string);
        return $string;
    }

    public function siteDados($campo = '') {
        $qry = $this->db->query('select * from tbl_sys_config limit 1;');
        $dados = $qry->fetch(PDO::FETCH_ASSOC);
        $info = $this->ArrayToUtf8($dados);
        if (empty($campo)) {
            return $info;
        } else {
            return $info[$campo];
        }
    }

    public function arrayToUtf8($dados) {
        if (!empty($dados)) {
            foreach ((array) $dados as $key => $value) {
                if (is_array($value)) {
                    $dados[$key] = arrayToUtf8($value); //Recursividade é legal pq recursividade é legal
                } else {
                    $dados[$key] = utf8_encode($value);
                }
            }
        }
        return $dados;
    }

    public function arrayFromUtf8($dados) {
        if (!empty($dados)) {
            foreach ((array) $dados as $key => $value) {
                if (is_array($value)) {
                    $dados[$key] = arrayFromUtf8($value); //Recursividade é legal pq recursividade é legal
                } else {
                    $dados[$key] = utf8_decode($value);
                }
            }
        }
        return $dados;
    }

    public function metatags() {
        $pagina = str_replace($this->baseUrl, '/', $_SERVER['REQUEST_URI']);

        $qry = $this->db->query('select * from tbl_sys_seo where nome like "' . $pagina . '" or nome like "' . $pagina . '/" limit 1');
        $row = $qry->fetch(PDO::FETCH_ASSOC);

        $info = $this->arrayToUtf8($row);
        if (!empty($info)) {
            return $this->montaMetatags($info);
        } else {
            return $this->metatagsPadrao();
        }
    }

    public function metatagsPadrao() {
        $qry = $this->db->query('select * from tbl_sys_seo where id = 1 limit 1');
        $d = $this->arrayToUtf8($qry->fetch(PDO::FETCH_ASSOC));
        $d['seo_title'] .= ' - ' . $this->titulo;
        return $this->montaMetatags($d);
    }

    public function montaMetatags($d) {
        $retorno = '<title>' . $this->tituloSite;
        if (!empty($this->titulo)) {
            $retorno .= ' - ' . $this->titulo;
        }
        $retorno .= '</title>';
        $retorno .= '<meta name="Keywords" content="' . $d['seo_keywords'] . '"/>';
        $retorno .= '<meta name="Description" content="' . $d['seo_description'] . '"/>';
        $retorno .= '<meta name="Robots" content="ALL"/>';
        $retorno .= '<meta name="Robots" content="INDEX,FOLLOW"/>';
        $retorno .= '<meta name="Revisit-After" content="1 Days"/>';
        $retorno .= '<meta name="Rating" content="General"/>';

        return $retorno;
    }

    public function analytics() {
        return $this->renderizarParcial('cod_analytics');
    }

    public function renderizar($nomeView, $variaveis = array(), $retornar = false) {
        if (!is_array($variaveis)) {
            throw new Exception("Variável ''$variaveis'' não é um array.");
        }

        $view = $this->pastaViews . $nomeView . '.php';
        if (!file_exists($view)) {
            $view = 'app/content/sys_views/' . $nomeView . '.php';
            if (!file_exists($view)) {
                if ($this->config->debug) {
                    die('A view ' . $nomeView . ' não foi encontrada');
                } else {
                    die('Erro interno no componente renderizador !');
                }
            }
        }
        $template = $this->pastaTemplates . $this->template . '.php';
        $conteudo = $this->render($view, $variaveis, true);
        $variaveis['conteudo'] = $conteudo;

        return $this->render($template, $variaveis, $retornar);
    }

    public function renderizarParcial($nomeView, $variaveis = array(), $retornar = false) {
        if (!is_array($variaveis)) {
            throw new Exception('Variável "$variaveis" não é um array.');
        }
        $view = $this->pastaViews . $nomeView . '.php';
        if (!file_exists($view)) {
            $view = 'app/content/sys_views/' . $nomeView . '.php';
            if (!file_exists($view)) {
                if ($this->config->debug) {
                    die('A view ' . $nomeView . ' não foi encontrada');
                } else {
                    die('Erro interno no componente renderizador !');
                }
            }
        }
        return $this->render($view, $variaveis, $retornar);
    }

    public function render($arquivoParaRenderizar, $variaveis = array(), $retornar = false) {
        ob_start();
        if (!empty($variaveis) && is_array($variaveis)) {
            extract($variaveis);
        }
        include($arquivoParaRenderizar);
        $retorno = ob_get_contents();
        ob_end_clean();
        if ($retornar) {
            return $retorno;
        } else {
            print $retorno;
        }
    }

    public function formatarData($data, $formato = 'd/m/Y - H:i') {
        return date_format(date_create($data), $formato);
    }

    public function formatarDataHora($datahora, $formato = 'd/m/Y H:i:s') {
        return date_format(date_create_from_format('Y-m-d H:i:s', $datahora), $formato);
    }

    /* Função que trata qualquer embeed ou link de vídeo e transforma em um embeed------------------------------------------------------------------------------------------ */
    /* e retorna o tipo, o thumb e o id único do vídeo------------------------------------------------------------------------------------------ */

    public function gerarVideo($video_string, $tamanho = array(540, 320)) {
        if (empty($video_string)) {
            return;
        } else {
            if ((strpos($video_string, 'youtube') == false) and ( strpos($video_string, 'youtu.be') == false)) {
                // Caso seja VIMEO
                if (preg_match('#(http://vimeo.com)/([0-9]+)#i', $video_string, $match)) {
                    $retorno['video_id'] = $match[2];
                    if (empty($retorno['video_id'])) {
                        $retorno['video_id'] = $match[1];
                    }
                    $imgid = $retorno['video_id'];
                    $hash = unserialize(@file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                    $retorno['thumb'] = $hash[0]['thumbnail_large'];
                    //Com autoplay
                    //$retorno['src'] = 'http://player.vimeo.com/video/' . $imgid . '?byline=0&amp;portrait=0&amp;color=ff9933&amp;autoplay=1';
                    $retorno['src'] = 'http://player.vimeo.com/video/' . $imgid . '?byline=0&amp;portrait=0&amp';
                    $retorno['src_autoplay'] = 'http://player.vimeo.com/video/' . $imgid . '?byline=0&amp;portrait=0&amp&autoplay=1';
                }
                $retorno['tipo'] = 'vimeo';
            } else {
                // Caso realmente seja youtube
                if (preg_match('#(?:<\>]+href=\")?(?:http://)?((?:[a-zA-Z]{1,4}\.)?youtube.com/(?:watch)?\?v=(.{11}?))[^"]*(?:\"[^\<\>]*>)?([^\<\>]*)(?:)?#', $video_string, $match)) {
                    $retorno['video_id'] = $match[2];
                    if (empty($retorno['video_id'])) {
                        $retorno['video_id'] = $match[1];
                    }
                    $retorno['tipo'] = 'youtube';
                    $retorno['thumb'] = 'http://img.youtube.com/vi/' . $retorno['video_id'] . '/0.jpg';
                    $retorno['src'] = 'http://www.youtube.com/embed/' . $retorno['video_id'];
                    $retorno['src_autoplay'] = 'http://www.youtube.com/embed/' . $retorno['video_id'] . '?amp&autoplay=1';
                } else if (preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_string, $match)) {
                    $retorno['video_id'] = $match[1];
                    if (empty($retorno['video_id'])) {
                        $retorno['video_id'] = $match[2];
                    }
                    $retorno['tipo'] = 'youtube';
                    $retorno['thumb'] = 'http://img.youtube.com/vi/' . $retorno['video_id'] . '/0.jpg';
                    $retorno['src'] = 'http://www.youtube.com/embed/' . $retorno['video_id'];
                    $retorno['src_autoplay'] = 'http://www.youtube.com/embed/' . $retorno['video_id'] . '?amp&autoplay=1';
                }
            }
            $retorno['matchs'] = $match;
            $retorno['embeed'] = '<iframe width="' . $tamanho[0] . '" height="' . $tamanho[1] . '" src="' . addslashes($retorno['src']) . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
            $retorno['entrada'] = $video_string;
            return $retorno;
        }
    }

    /* Função que gera a galeria de imagens de um determinado campo------------------------------------------------------------------------------------------ */

    public function gerarGaleria($data, $caminho = '', $retorno_unico = false) {
        $img_cat = array();
        if (isset($data)) {
            $imagens = explode(';', trim($data));
            foreach ($imagens as $key => $value) {
                if (!empty($value)) {
                    $img_cat[$key]['nome_arquivo'] = $value;
                    $img_cat_expld = explode('.', $value);
                    $img_cat[$key]['nome'] = reset($img_cat_expld);
                    $img_cat[$key]['ext'] = end($img_cat_expld);
                    if (!empty($caminho)) {
                        $img_cat[$key]['url_arquivo'] = $this->baseUrl . 'uploads/' . $caminho . '/' . $value;
                        $img_cat[$key]['embeed'] = '<img src="' . $this->baseUrl . 'uploads/' . $caminho . '/' . $value . '"';
                        $img_cat[$key]['embeed1'] = '<img src="' . $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_1.' . $img_cat[$key]['ext'] . '">';
                        $img_cat[$key]['embeed2'] = '<img src="' . $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_2.' . $img_cat[$key]['ext'] . '">';
                        $img_cat[$key]['embeed3'] = '<img src="' . $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_3.' . $img_cat[$key]['ext'] . '">';
                        $img_cat[$key]['embeed4'] = '<img src="' . $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_4.' . $img_cat[$key]['ext'] . '">';
                        $img_cat[$key]['embeed5'] = '<img src="' . $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_5.' . $img_cat[$key]['ext'] . '">';
                        $img_cat[$key]['caminho'] = $this->baseUrl . 'uploads/' . $caminho . '/' . $value;
                        $img_cat[$key]['caminho1'] = $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_1.' . $img_cat[$key]['ext'];
                        $img_cat[$key]['caminho2'] = $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_2.' . $img_cat[$key]['ext'];
                        $img_cat[$key]['caminho3'] = $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_3.' . $img_cat[$key]['ext'];
                        $img_cat[$key]['caminho4'] = $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_4.' . $img_cat[$key]['ext'];
                        $img_cat[$key]['caminho5'] = $this->baseUrl . 'uploads/' . $caminho . '/' . $img_cat[$key]['nome'] . '_5.' . $img_cat[$key]['ext'];
                    }
                }
            }
        }
        if ($retorno_unico == true) {
            return $this->array_to_object($img_cat[0]);
        } else {
            return $this->array_to_object($img_cat);
        }
    }

    /* Função para transformar uma string em url------------------------------------ */

    public function geraUrl($input_str) {
        $input_str = $this->removeAcentos($input_str);
        $input_str = strtolower($input_str);
        $input_str = preg_replace("/[^a-z0-9_\s-]/", "", $input_str);
        $input_str = preg_replace("/[\s-]+/", " ", $input_str);
        $input_str = preg_replace("/[\s_]/", "-", $input_str);
        return $input_str;
    }

    public function stringUrlAmigavel($phrase, $maxLength = 50) {
        $result = strtolower($phrase);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);
        return $result;
    }

    /* Função que retorna o e-mail para o envia_email------------------------------- */

    public function retornaEmail($tipo = 'contato') {
        $qry = $this->db->query('select email_' . $tipo . ' from tbl_sys_config limit 1');
        return $qry->fetchColumn(0);
    }

    /* =================== FUNÇÕES REFERENTES A VALIDAÇÃO DE USUÁRIO============================= */
    /* Funções */

    public function normaliza($string) {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        $string = strtolower($string);
        return utf8_encode($string);
    }

    /* ========================================================================================== */
    /* Função para resumir descrição */

    public function resumirStr($texto, $n = 20) {
        $texto = strip_tags($texto);
        $texto = trim(preg_replace("/\s+/", " ", $texto));
        $word_array = explode(" ", $texto);
        if (count($word_array) <= $n)
            return implode(" ", $word_array);
        else {
            $texto = '';
            foreach ($word_array as $length => $word) {
                $texto.=$word;
                if ($length == $n)
                    break;
                else
                    $texto.=" ";
            }
        }
        return $texto;
    }

    public function jout($msg) {
        $retorno = '<script type="text/javascript">
                    alert("';
        $retorno .= addslashes($msg);
        $retorno .='")
                </script>';
        return $retorno;
    }

    public function isPost($pagina) {
        if ($_POST) {
            $url_referer = parse_url($_SERVER[HTTP_REFERER]);
            $url_referer = explode('/', $url_referer[path]);
            $url_referer = end($url_referer);
            return ($pagina == $url_referer);
        } else {
            return false;
        }
    }

    public function array_to_object($array) {
        if (!empty($array)) {
            $obj = new stdClass;
            foreach ((array) $array as $k => $v) {
                if (is_array($v)) {
                    $obj->{$k} = $this->array_to_object($v); //RECURSION
                } else {
                    $obj->{$k} = $v;
                }
            }
            return $obj;
        } else {
            return $array;
        }
    }

    /*
     * Função para remover acentos de uma string
     */

    public function removeAcentos($var) {
        return $this->normaliza($var);
    }

    public function removeAcentosMetodoSimples($string, $slug = false) {
        $string = strtolower($string);
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);
        foreach ($ascii as $key => $item) {
            $acentos = '';
            foreach ($item AS $codigo)
                $acentos .= chr($codigo);
            $troca[$key] = '/[' . $acentos . ']/i';
        }
        $string = preg_replace(array_values($troca), array_keys($troca), $string);
        if ($slug) {
            $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
            $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
            $string = trim($string, $slug);
        }
        return $string;
    }

    public function listarErros($erros = '', $classes = array('div' => 'erroContainer clearfix', 'ul' => 'flashes', 'li' => 'flash-erro')) {
        if (!empty($erros)) {
            $retorno .= '<div class="' . $classes['div'] . '">';
            $retorno .= '<ul class="' . $classes['ul'] . '">';
            foreach ($erros as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $campo => $msg) {
                        $retorno .= '<li class="' . $classes['li'] . '">' . $campo . ' - ' . $msg . '</li>';
                    }
                } else {
                    $retorno .= '<li class="' . $classes['li'] . '">' . $key . ' - ' . $value . '</li>';
                }
            }
            $retorno .= '</ul>';
            $retorno .= '</div>';
            return $retorno;
        }
    }

    public function isValidMd5($md5) {
        return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
    }

    public function salvarNewsletter($email, $nome = '') {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dados = $this->retornoRegistroPadrao('tbl_sys_newsletter', '', 1, 0, ' where email like "' . $email . '"', 'id');
            if (empty($dados['registros'])) {
                if (mysql_query("INSERT INTO  `tbl_sys_newsletter` (`id` ,`nome` ,`email`) VALUES (NULL ,  '" . utf8_decode($nome) . "',  '" . $email . "');")) {
                    $this->adicionarMensagemSucesso('Email cadastrado com sucesso !');
                    return true;
                } else {
                    $this->adicionarMensagemErro('Ocorreu um erro e seu email não foi cadastrado em nosso banco de dados');
                    return false;
                }
            } else {
                $this->adicionarMensagem('Email já cadastrado em nosso banco de dados', 2);
                return false;
            }
        } else {
            $this->adicionarMensagemErro('Email inválido');
            return false;
        }
    }

    public function adicionarMensagemErro($mensagem) {
        $this->adicionarMensagem($mensagem, 2);
    }

    public function adicionarMensagemSucesso($mensagem) {
        $this->adicionarMensagem($mensagem, 1);
    }

    public function adicionarMensagem($mensagem, $tipo = 0) {
        /*
         * Tipos
         * 0 = Neutro
         * 1 = Sucesso
         * 2 = Erro
         */
        switch ($tipo) {
            case 0:
            default:
                $classeErro = 'info';
                break;
            case 1:
                $classeErro = 'success';
                break;
            case 2:
                $classeErro = 'danger';
                break;
        }
        if (empty($_SESSION[$this->siteUrl])) {
            $_SESSION[$this->siteUrl] = array();
        }

        array_push($_SESSION[$this->siteUrl], array('mensagem' => $mensagem, 'classe' => $classeErro));
    }

    public function listarMensagens() {
        $mensagens = $_SESSION[$this->siteUrl];
        $this->removerMensagens();
        return $mensagens;
    }

    public function existeMensagens() {
        return !empty($_SESSION[$this->siteUrl]);
    }

    public function exibirMensagens() {
        $mensagens = $this->listarMensagens();

        foreach ((array) $mensagens as $mensagem) {
            echo '<div class="alert alert-' . $mensagem['classe'] . '">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    ' . $mensagem['mensagem'] . '
                  </div>';
        }
    }

    public function removerMensagens() {
        unset($_SESSION[$this->siteUrl]);
    }

    /**
     * Gera uma URL para o site.
     * @param array $caminho Caminho cada item corresponde a um diretório. Ex: array('caminho','parametro') = http://seuprojeto.com/caminho/parametro/
     * @param mixed $urlBase A BaseUrl para gerar a url. Por padrão é utilizado a constante $this->baseUrl.
     * @return string A Url Gerada
     */
    public function url($caminho = '', $urlBase = '') { //Caminho em branco para retornar por padrão a "home"
        $url = empty($urlBase) ? $this->baseUrl : $urlBase;
        if (is_array($caminho)) {
            foreach ($caminho as $value) {
                if (strpos($value, '.') === false) {
                    $url .= $value . '/';
                } else {
                    $url .= $value;
                }
            }
        } else {
            $url .= $caminho;
        }
        return $url;
    }

    public function html_sysImg($idImagem, $resource, $idTamanho = '1', $opcoesHtml = array()) {
        $_opcoes = '';
        if (!empty($opcoesHtml) && is_array($opcoesHtml)) {
            foreach ($opcoesHtml as $key => $value) {
                $_opcoes .= $key . '="' . $value . '"';
            }
        }
        return '<img src="' . $resource[$idImagem]['caminho' . $idTamanho] . '" ' . $_opcoes . ' >';
    }

    public function html_img($srcImg, $alt = '', $opcoesHtml = array()) {
        $_opcoes = '';
        if (!empty($opcoesHtml) && is_array($opcoesHtml)) {
            foreach ($opcoesHtml as $key => $value) {
                $_opcoes .= $key . '="' . $value . '"';
            }
        }
        return '<img src="' . $srcImg . '" alt="' . $alt . '" ' . $_opcoes . ' />';
    }

    public function html_link($conteudo, $href, $opcoesHtml = array()) {
        $_opcoes = '';
        if (!empty($opcoesHtml) && is_array($opcoesHtml)) {
            foreach ($opcoesHtml as $key => $value) {
                $_opcoes .= $key . '="' . $value . '"';
            }
        }
        if (!is_array($href) && (strpos($href, '.') === false)) {
            $href = explode('/', $href);
        }
        $href = $this->url($href);

        return '<a href="' . $href . '" ' . $_opcoes . ' >' . $conteudo . '</a>';
    }

    public function html_script($arquivo, $arquivoExterno = false) {
        $url = ($arquivoExterno == true) ? $arquivo : $this->url($arquivo);
        return '<script src="' . $url . '"></script>';
    }

    public function html_css($arquivo, $arquivoExterno = false) {
        $url = ($arquivoExterno == true) ? $arquivo : $this->url($arquivo);
        return '<link rel="stylesheet" src="' . $url . '">';
    }

    /*
     * 
     * SEÇÃO MESTRE - > MÉTODOS ESTÁTICOS AUXILIARES DO PAGSEGURO
     * 
     */

    public static function pagSeguro($campo) {
        $qry = mysql_query('select ' . $campo . '_pagseguro from tbl_sys_config limit 1;');
        $dados = mysql_fetch_assoc($qry);
        return $dados[$campo . '_pagseguro'];
    }

    /*
     * Erros
     */

    public function erro_404() {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        header("Status: 404 Not Found");
        $_SERVER['REDIRECT_STATUS'] = 404;
        $this->setErroTemplate();
        $this->renderizar('erro_404');
        die();
    }

    public function erro_geral(Exception $e, array $others = array()) {
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        header("Status: 500 Internal Server Error");
        $_SERVER['REDIRECT_STATUS'] = 500;
        $this->setErroTemplate();
        $this->renderizar('erro_geral', array('e' => $e, 'others' => $others));
        die();
    }

    public function setErroTemplate() {
        $this->template = 'erro_template';
    }

    public function encodeSEOString($string) {
        $string = preg_replace("`\[.*\]`U", "", $string);
        $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string);
        $string = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $string);
        return strtolower(trim($string, '-'));
    }

    public function decodeSEOString($string) {
        return str_replace('-', ' ', $string);
    }

    public function startUrlAmigavel() {
        /* Inicialização URL amigável */
        $inputs = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        if (!empty($_GET['a'])) {
            $get = explode("/", $_GET['a']);
            foreach ($get as $key => $value) {
                if (!empty($value))
                    $_GET[$inputs[$key]] = $value;
            }
        }
        /* Inicialização - Evitar sql inject */
        foreach ($_POST as $key => $input_arr) {
            if (!is_array($_POST[$key])) {
                $_POST[$key] = addslashes($input_arr);
            }
        }
        foreach ($_GET as $key => $input_arr) {
            $_GET[$key] = addslashes($input_arr);
        }
    }

}
