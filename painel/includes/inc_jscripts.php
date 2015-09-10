<!--Jquery e outos basicos-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= PAINEL_BASE_URL ?>js/jquery-1.8.0.min.js"><\/script>')</script>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= PAINEL_BASE_URL ?>js/jquery.ui.datepicker-pt-BR.js"></script>
<!--Fim Jquery-->


<!--Chosen-->
<link type="text/css" href="<?= PAINEL_BASE_URL ?>js/chosen/chosen.css" rel="stylesheet" media="all" />
<link type="text/css" href="<?= PAINEL_BASE_URL ?>js/chosen/ImageSelect.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="<?= PAINEL_BASE_URL ?>js/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?= PAINEL_BASE_URL ?>js/chosen/ImageSelect.jquery.js"></script>
<!--Fim Chosen-->

<!--DateTime Picker Jquery UI-->
<script type="text/javascript" src="<?= PAINEL_BASE_URL ?>js/jquery-ui-timepicker-addon.js"></script>
<!--Fim DateTime Picker-->

<!--Color Picker-->
<script type="text/javascript" src="<?= PAINEL_BASE_URL ?>js/colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>js/js_css/colorpicker.css">
<!--Fim Color Picker-->

<!--Tag-->
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/overcast/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>js/js_css/jquery.tagit.css">
<link rel="stylesheet" type="text/css" href="<?= PAINEL_BASE_URL ?>js/js_css/tagit.ui-zendesk.css">
<script type="text/javascript" src="<?= PAINEL_BASE_URL ?>js/tag-it.js"></script>
<!--Tag-->

<!--Redactor-->
<link rel="stylesheet" href="<?= PAINEL_BASE_URL ?>/js/redactor/redactor.css" />
<script src="<?= PAINEL_BASE_URL ?>/js/redactor/redactor.min.js"></script>
<script src="<?= PAINEL_BASE_URL ?>/js/redactor/lang/pt_br.js"></script>
<script src="<?= PAINEL_BASE_URL ?>/js/redactor/plugins/fullscreen/fullscreen.js"></script>
<script src="<?= PAINEL_BASE_URL ?>/js/redactor/plugins/fontfamily/fontfamily.js"></script>
<script src="<?= PAINEL_BASE_URL ?>/js/redactor/plugins/fontsize/fontsize.js"></script>
<!--Fim Redactor-->

<!--Money format-->
<script type="text/javascript" src="<?= PAINEL_BASE_URL ?>js/jquery.price_format.1.7.min.js"></script>
<!--Money format-->

<script type="text/javascript">

    $(document).ready(function () {

        /*Formatar os inputs que recebem valores monetários*/
        $('input[rel="money"]').priceFormat({
            prefix: '',
            centsSeparator: '.',
            thousandsSeparator: ''
        });
        /*---Transformar o select no form contato bonitinho *.*/
        $('.select_estilizado').chosen();
        /*---Transformar Time Picker---*/
        $('input[rel="data_hora"]').datetimepicker({
            timeFormat: 'hh:mm:ss',
            timeText: 'Horário',
            hourText: 'Hora',
            minuteText: 'Minuto',
            secondText: 'Segundos',
            currentText: 'Agora',
            closeText: 'Pronto'
        });
        $('input[rel="data_publicacao"]').datepicker();

        $('.redactor').redactor({
            lang: 'pt_br',
            linebreaks: true,
            plugins: ['fullscreen', 'fontfamily', 'fontsize'],
            autoresize: true,
            minHeight: 300,
            imageUpload: '<?= PAINEL_BASE_URL ?>redactor_upload.php',
        });

    });
    var Site = {
        start: function () {
            if ($('accordion'))
                Site.accordion();
        },
        accordion: function () {
            var list = $$('#accordion li ul.subnav');
            var headings = $$('#accordion li h3');
            var collapsibles = new Array();
            var spans = new Array();
            var as = new Array();
            headings.each(function (heading, i) {

                var collapsible = new Fx.Slide(list[i], {
                    duration: 500,
                    transition: Fx.Transitions.quadIn
                });
                collapsibles[i] = collapsible;
                spans[i] = $E('span', heading);
                as[i] = $E('a', heading);
                //if(i == 2){
                //alert(as[i].href + '|<?= "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>');
                if (as[i].href == '<?= "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ?>') {
                    try {
                        collapsibles[i].slideIn();
                    } catch (err) {
                    }
                }
                //alert(as[i].href + " | <?= $_SERVER['HTTP_HOST']//$_SERVER['PHP_SELF']                                       ?>" );

                heading.onclick = function () {
                    var span = $E('span', heading);
                    if (span) {
                        //var newHTML = span.innerHTML == '+' ? '-' : '+';
                        //span.setHTML(newHTML);
                    }

                    for (var j = 0; j < collapsibles.length; j++) {
                        if (j != i) {
                            collapsibles[j].slideOut();
                            //if(spans[j]) spans[j].setHTML('+');
                        }
                    }

                    collapsible.toggle();
                    return false;
                }
                collapsible.hide();
            });
        }
    };
    /*
     window.addEvent('domready', function(){
     Site.start();
     $$('#overlayx').addEvent('click', function(e) {
     //$$('#overlayx').style.display = 'none';
     //$$('#iframex').style.display = 'none';
     document.getElementById("overlayx").style.display = 'none';
     document.getElementById("iframex").style.display = 'none';
     document.getElementById("iframex").src = 'images/trans.gif';
     });
     });	
     */

    function upload_foto(width, height) {
        if (width == null) {
            width = 100;
        }
        if (height == null) {
            height = 75;
        }
        var overlayx = document.getElementById("overlayx").style;
        var iframex = document.getElementById("iframex");
        overlayx.display = '';
        iframex.style.display = '';
        iframex.style.position = 'fixed';
        iframex.style.top = '50%';
        iframex.style.left = '50%';
        iframex.style.marginTop = '-300px';
        iframex.style.marginLeft = '-458px';
        iframex.style.width = '910px';
        iframex.style.height = '600px';
        iframex.style.backgroundColor = '#fff';
        iframex.style.zIndex = '150';
        //alert(width+'x'+height);
        //iframex.src = 'upload_index.html';
        //if(document.getElementById("thumb_foto").src != ""){
        //	iframex.src = "inc_limpa_arquivo.php?page=upload_index.php&foto=" + document.getElementById("thumb_foto").alt;
        //}else {
        iframex.src = 'upload_index.php?width=' + width + '&height=' + height;
        //}
    }

    function upload_video() {
        var overlayx = document.getElementById("overlayx").style;
        var iframex = document.getElementById("iframex");
        overlayx.display = '';
        iframex.style.display = '';
        iframex.style.position = 'fixed';
        iframex.style.top = '50%';
        iframex.style.left = '50%';
        iframex.style.marginTop = '-300px';
        iframex.style.marginLeft = '-458px';
        iframex.style.width = '910px';
        iframex.style.height = '600px';
        iframex.style.backgroundColor = '#fff';
        iframex.style.zIndex = '150';
        if (document.getElementById("form_video").value != "") {
            iframex.src = "inc_limpa_arquivo.php?page=upload_video.php&video=" + document.getElementById("form_video").alt;
        } else {
            iframex.src = 'upload_video.php';
        }
    }

    function upload_arquivo() {
        var overlayx = document.getElementById("overlayx").style;
        var iframex = document.getElementById("iframex");
        overlayx.display = '';
        iframex.style.display = '';
        iframex.style.position = 'fixed';
        iframex.style.top = '50%';
        iframex.style.left = '50%';
        iframex.style.marginTop = '-300px';
        iframex.style.marginLeft = '-458px';
        iframex.style.width = '910px';
        iframex.style.height = '600px';
        iframex.style.backgroundColor = '#fff';
        iframex.style.zIndex = '150';
        if (document.getElementById("form_arquivo").value != "") {
            //iframex.src = "inc_limpa_arquivo.php?page=upload_video.php&video=" + document.getElementById("form_video").alt;
        } else {
            iframex.src = 'upload_arquivo.php';
        }
    }

    function view_video(valor) {
        var overlayx = document.getElementById("overlayx").style;
        var iframex = document.getElementById("iframex");
        overlayx.display = '';
        iframex.style.display = '';
        iframex.style.position = 'fixed';
        iframex.style.top = '50%';
        iframex.style.left = '50%';
        iframex.style.marginTop = '-160px';
        iframex.style.marginLeft = '-210px';
        iframex.style.width = '420px';
        iframex.style.height = '350px';
        iframex.style.backgroundColor = '#fff';
        iframex.style.zIndex = '150';
        iframex.overflow = 'hidden';
        iframex.src = 'view_video.php?video=' + valor;
    }



    function apagar(valor) {
        var answer = confirm("Deseja apagar?")
        if (answer) {
            window.location = valor;
        }
    }


</script>