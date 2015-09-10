<?php

/**
 * CupFileHandler
 * Classe para manipulação e redimensionamento de uploads 
 */
class CupFileHandler {

    protected $pasta;
    protected $tamanhos;

    function __construct($pasta, $tamanhos) {
        $this->pasta = $pasta;
        $this->tamanhos = $tamanhos;
    }

    public function salvarImagens() {
        $uploads = array();
        if (isset($_FILES)) {
            foreach ($_FILES as $key => $value) {
                if (is_array($value) && array_key_exists('name', $value) && is_array($value['name'])) {
                    $value = Utils::reArrayFiles($value);
                    foreach ($value as $kk => $vv) {
                        $uploads[$key][$kk] = $this->saveFile($vv);
                    }
                } else {
                    $uploads[$key] = $this->saveFile($value);
                }
            }
        }
        return $uploads;
    }

    public function saveFile($value) {
        if ((!empty($value['name'])) && ($value['error'] == 0)) {
            $size = $value['size'];
            $code = substr(md5(rand() . time()), 0, 15);
            $expldName = explode('.', $value['name']);
            $ext = strtolower(end($expldName));
            $caminho = dirname(__FILE__) . '/../../uploads/' . $this->pasta . '/';
            if (!file_exists(dirname(__FILE__) . '/../../uploads/')) {
                mkdir(dirname(__FILE__) . '/../../uploads/');
            }
            if (!file_exists($caminho)) {
                mkdir($caminho);
            }
            $imagens = array('jpg', 'jpeg', 'bmp', 'png', 'gif');
            if (in_array(strtolower($ext), $imagens)) {
                $this->redimensionar($value, 80, 60, $caminho, $code . "_admin." . $ext);
                $thumb_count = 1;
                foreach ($this->tamanhos as $key2 => $value2) {
                    $this->redimensionar($value, $value2[0], $value2[1], $caminho, $code . "_" . $thumb_count . "." . $ext);
                    ++$thumb_count;
                }
            }
            move_uploaded_file($value['tmp_name'], $caminho . $code . "." . $ext);
            $arquivo = $code . "." . $ext;
            return $arquivo;
        }
        return null;
    }

    public function redimensionar($arquivo, $larguraMax, $alturaMax, $destino, $nome_destino) {
        $source_path = $arquivo['tmp_name'];


        list( $source_width, $source_height, $source_type ) = getimagesize($source_path);

        switch ($source_type) {
            case IMAGETYPE_GIF:
                $tgdim = imagecreatefromgif($source_path);
                $source_gdim = $this->imagetranstowhite($tgdim);
                break;

            case IMAGETYPE_JPEG:
                $tgdim = imagecreatefromjpeg($source_path);
                $source_gdim = $this->imagetranstowhite($tgdim);
                break;

            case IMAGETYPE_PNG:
                $source_gdim = imagecreatefrompng($source_path);
                break;
        }

        $source_aspect_ratio = $source_width / $source_height;
        $desired_aspect_ratio = $larguraMax / $alturaMax;

        if ($source_aspect_ratio > $desired_aspect_ratio) {
            $temp_height = $alturaMax;
            $temp_width = (int) ( $alturaMax * $source_aspect_ratio );
        } else {
            $temp_width = $larguraMax;
            $temp_height = (int) ( $larguraMax / $source_aspect_ratio );
        }

        $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
        if ($source_type === IMAGETYPE_PNG) {
            imagealphablending($temp_gdim, false);
            imagesavealpha($temp_gdim, true);
        }
        imagecopyresampled($temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height);

        $x0 = ( $temp_width - $larguraMax ) / 2;
        $y0 = ( $temp_height - $alturaMax ) / 2;

        $desired_gdim = imagecreatetruecolor($larguraMax, $alturaMax);
        if ($source_type === IMAGETYPE_PNG) {
            imagealphablending($desired_gdim, false);
            imagesavealpha($desired_gdim, true);
        }
        imagecopy(
                $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $larguraMax, $alturaMax
        );

        switch ($source_type) {
            case IMAGETYPE_GIF:
                imagegif($desired_gdim, $destino . $nome_destino, 100);
                break;

            case IMAGETYPE_JPEG:
                imagejpeg($desired_gdim, $destino . $nome_destino, 100);
                break;

            case IMAGETYPE_PNG:
                imagepng($desired_gdim, $destino . $nome_destino);
                break;
        }
    }

    function imagetranstowhite($trans) {
        $w = imagesx($trans);
        $h = imagesy($trans);
        $white = imagecreatetruecolor($w, $h);

        $bg = imagecolorallocate($white, 255, 255, 255);
        imagefill($white, 0, 0, $bg);

        imagecopy($white, $trans, 0, 0, 0, 0, $w, $h);
        return $white;
    }

}
