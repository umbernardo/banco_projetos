$(document).ready(function(){

        // Full banner
      $(document).omSlider({
        slider: $('.slider'),
        dots: $('.dots'),
        next:$('.btn-right'),
        pre:$('.btn-left'),
        timer: 5000,
        showtime: 1000
      });


        // Miniaturas fancybox
        $(".fancybox-thumb").fancybox({
            width: 945,
            helpers : {
                title   : null,
                thumbs  : {
                    width   : 140,
                    height  : 120
                }
            }
        });

        // Slider Atletas Home
        $('.slider-resultados').bxSlider({
          mode: 'horizontal',
          captions: false,
          pager: false,
          auto: true
        });

        // Slider Atletas Home
        $('.slider-banner').bxSlider({
          mode: 'horizontal',
          captions: false,
          controls: false,
          pager: true,
          auto: true
        });

        // Colocar SPAN em todos os H1
        $('h1').each(function(){
           $(this).append("<span></span>"); 
        });


      // Validar Contato
        $(".form-contato").validate({
            rules            : {
                nome             : { required : true, minlength: 5 },
                email            : { required : true, email: true },
                telefone         : { required : true },
                mensagem         : { required : true },
                senha         : { required : true },
                resumo         : { required : true }
            },
            errorClass      : 'erro',
        });      

        $(".form-news").validate({
            rules            : {
                txtNomeNews             : { required : true, minlength: 5 },
                txtEmailNews            : { required : true, email: true }
            },
            errorClass      : 'erro',
        }); 

        $(".form-busca").validate({
            rules            : {
                txtBusca      : { required : true, minlength: 3 }
            },
            errorClass      : 'erro',
        });      


        // Perguntas
       $(".perguntas .item .titulo").click(function() {

        if (!$(this).parent().hasClass("ativo"))
        {
            $('.perguntas .item .titulo').removeClass("ativo");
            $(this).parent().addClass("ativo");        
        }
        else
        {
            $('.perguntas .ativo').removeClass("ativo");
        }
      });


        // Formualrios de Contato validar
        $(".form-contato").validate({
            rules            : {
                txtNome             : { required : true, minlength: 5 },
                txtEmail            : { required : true, email: true },
                txtTelefone         : { required : true },
                txtCidade           : { required : true },
                txtUF               : { required : true },
                txtMensagem         : { required : true }
            },
            errorClass      : 'erro',
        });   

	// Formularios mascaras e scripts
	if ($('body').find('.formulario').length > 0) {

    }

    // Mapa do Brasil
    $(".estado").on("click", function(){
        $(".estado").removeClass('selecionado');
        $(this).addClass('selecionado');
        // Ajax
        $(".nome-estado").html($(this).data('nome'));
           var idSelect = $(this).attr('id') + "sel";
           console.debug(idSelect);
           var nomeMaquina  = this.value;
            $.ajax({
                url: "inc_representantes.php",
                 beforeSend: function (  ) {
                    $.fancybox.showLoading();
                 }              
                }).done(function ( data ) {
                    $('.recebe-data').hide();
                    $('.recebe-data').html(data);
                    $('.recebe-data').fadeIn(500);
                    $.fancybox.hideLoading();
            });
    });
     $(".estado").on("mouseover", function(){
        $("#fakeTitle").html($(this).data('nome'));
    });
    $(".estado").on("mouseover", function(){
        $("#fakeTitle").css('display', "inline-block");
    });
    $(".estado").on("mouseout", function(){
        $("#fakeTitle").css('display',"none");
    });
    var mouseX, mouseY;
    $(document).mousemove(function(e) {
        mouseX = e.pageX;
        mouseY = e.pageY;
        $("#fakeTitle").css("top", mouseY).css("left", mouseX);
    });

    $('#saoPaulo').trigger("click");

});

