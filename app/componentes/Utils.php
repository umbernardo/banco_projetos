<?php

class Utils {

    public static function gerarGaleria($data, $caminho = '', $retorno_unico = false) {
        $retorno = array();
        if (!empty($data)) {
            $imagens = explode(';', trim($data));
            foreach ($imagens as $key => $value) {
                if (!empty($value)) {
                    $retorno[$key] = self::getImagePaths($caminho, $value);
                }
            }
            if (true == $retorno_unico) {
                return self::arrayToObject(reset($retorno));
            }
        }
        return self::arrayToObject($retorno);
    }

    public static function nomeUrl($input_str) {
        $input_str = self::normaliza($input_str);
        $input_str = strtolower($input_str);
        $input_str = preg_replace("/[^a-z0-9_\s-]/", "", $input_str);
        $input_str = preg_replace("/[\s-]+/", " ", $input_str);
        $input_str = preg_replace("/[\s_]/", "-", $input_str);
        return $input_str;
    }

    public static function normaliza($string) {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        $string = strtolower($string);
        return utf8_encode($string);
    }

    public static function getImagePaths($caminho, $value) {
        $imagem = array();
        $imagem['nome_arquivo'] = $value;
        $img_cat_expld = explode('.', $value);
        $imagem['nome'] = reset($img_cat_expld);
        $imagem['ext'] = end($img_cat_expld);
        if (!empty($caminho)) {
            $imagem['url_arquivo'] = BASE_URL . 'uploads/' . $caminho . '/' . $value;
            $imagem['embeed'] = '<img src="' . BASE_URL . 'uploads/' . $caminho . '/' . $value . '"';
            $imagem['embeed1'] = '<img src="' . BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_1.' . $imagem['ext'] . '">';
            $imagem['embeed2'] = '<img src="' . BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_2.' . $imagem['ext'] . '">';
            $imagem['embeed3'] = '<img src="' . BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_3.' . $imagem['ext'] . '">';
            $imagem['embeed4'] = '<img src="' . BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_4.' . $imagem['ext'] . '">';
            $imagem['embeed5'] = '<img src="' . BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_5.' . $imagem['ext'] . '">';
            $imagem['caminho'] = BASE_URL . 'uploads/' . $caminho . '/' . $value;
            $imagem['caminho1'] = BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_1.' . $imagem['ext'];
            $imagem['caminho2'] = BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_2.' . $imagem['ext'];
            $imagem['caminho3'] = BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_3.' . $imagem['ext'];
            $imagem['caminho4'] = BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_4.' . $imagem['ext'];
            $imagem['caminho5'] = BASE_URL . 'uploads/' . $caminho . '/' . $imagem['nome'] . '_5.' . $imagem['ext'];
        }
        return $imagem;
    }

    public static function arrayToObject($array) {
        if (!empty($array)) {
            $obj = new stdClass;
            foreach ((array) $array as $k => $v) {
                if (is_array($v)) {
                    $obj->{$k} = self::arrayToObject($v); //RECURSION
                } else {
                    $obj->{$k} = $v;
                }
            }
            return $obj;
        } else {
            return $array;
        }
    }

    public static function debug($var, $tipo = 2) {
        if ($tipo == 0) {
            echo '<div id="debug_pdebug' . date('cu') . '" style="position:fixed;left:25%;z-index:9999;cursor:pointer;top:0;background:#FFF;color:#000;">
                <div id="link_debug129839">Exibir</div>
                <div id="debug_div19823982" style="display:none;width:700px;height:800px;overflow:auto;">
                <pre>';
            print_r($var);
            echo '</pre></div></div>';
            echo '<script type="text/javascript">
            $("#link_debug129839").click(function(){
                if($("#debug_div19823982").is(":visible")){
                    $("#debug_div19823982").hide();
                } else {
                    $("#debug_div19823982").show();
                }
            })  
        </script>';
        } else if ($tipo == 1) {
            echo '<pre style="background-color: black;color: white;font-size: 15px;font-family: monospace;text-align:left;">';
            print_r($var);
            echo '</pre>';
        } else if ($tipo == 2) {
            echo '<pre style="background-color: black;color: white;font-size: 15px;font-family: monospace;text-align:left;">';
            var_dump($var);
            echo '</pre>';
        }
    }

    public static function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                @$file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }

    public static function validarNomeCompleto($name) {
        return true == (preg_match("/^[^\s]+\s[^\s]+$/", $name));
    }
    
    public static function validaUrl($url) {
        if (empty($url)) {
            return '#';
        }
        $http = 'http://';
        $https = 'https://';
        if (strpos($url, $http) === false && strpos($url, $https) === false) {
            $url = str_replace('http://', '', $url);
            return 'http://' . $url;
        } else {
            return $url;
        }
    }

}
