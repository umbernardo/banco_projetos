<?php
$foto = $_GET['foto'];
$video = $_GET['video'];
$page = $_GET['page'];

if(!empty($foto)){
if(file_exists($foto)){
unlink($foto);
} 	
} else if(!empty($video)){
if(file_exists($video)){
unlink($video);
}
}

if(!empty($page)){
echo "<script>document.location.href = '".$page."'</script>";
}