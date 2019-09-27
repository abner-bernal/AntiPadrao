/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("#sair").click(function() { 
    location.href='logoff.php';
});

$(".select-cad").change(function() {
    var val = $(this).find(":selected").val();
    if(val === 'adm'){
        $('.input-select').show();
    }else{
        $('.input-select').hide();
    }
});

$('.tag-remov').click(function(){
    removeTag($(this));
});

function removeTag(tag){
    if(tag.children().hasClass('tip')){
        $("[name=tipo]").prop( "checked" , false);    
    }else if (tag.children().hasClass('lag')){
        $("[name=lang]").prop( "checked" , false);
    }
    tag.children().removeClass('-active');
    var lang = $('[name=lang]:checked').val();
    var tipo = $('[name=tipo]:checked').val();
    CallCateg(lang,tipo);
}

window.onpopstate = function (){
    var href = window.location.href;
    location.href=href;
};

var content = $('#content');








function contsize() {
    var scre = $("body").width();
    if ( scre >= 1605 ) {
        $(".cont").removeClass('colum3');
        $(".cont").addClass('colum4');
    }else if ( scre >= 1260 && scre < 1605 ) {
        $(".cont").removeClass('colum4');
        $(".cont").removeClass('colum2');
        $(".cont").addClass('colum3');
    }else if ( scre > 930 && scre < 1260 ) {
        $(".cont").removeClass('colum3');
        $(".cont").addClass('colum2');
    }
}

function quantitens(quant){
    
    var width = parseInt($('#itens'+quant).css('width'));
    var widthCont = parseInt($('.cont').css('width'));
    var itens = width / 320;
    var itens_vis = widthCont / 320;
    if(itens > itens_vis){
        $('#itens'+quant).parent().next().children().removeClass('list-deslN');
    }else{        
        $('#itens'+quant).parent().next().children().addClass('list-deslN');
    }
    $('#itens'+quant).parent().prev().children().addClass('list-deslN');
    $('#itens'+quant).css('transform', 'translateX(0px)');
}

$('.right-desl').click(function(){
    var prox = $(this).parent().find('.itens');
    var matriz = prox.css('transform');
    var vet = matriz.split(',');
    var valor = vet[4];
    valor = parseInt(valor);
    
    var width = parseInt(prox.css('width'));
    var widthCont = parseInt($('.cont').css('width'));
    var itens = width / 320;
    var itens_vis = widthCont / 320;
    var passou = -valor / 320;
    var itens_prox = itens-itens_vis-passou;
    
    if(itens_prox >= itens_vis){
        prox.css('transform', 'translateX('+(valor-(itens_vis * 320))+'px)');
        if(itens_prox === itens_vis){
            $(this).children().addClass('list-deslN');//botao direito some
        }
    }else if(itens_prox < itens_vis){
        prox.css('transform', 'translateX('+(valor-(itens_prox * 320))+'px)');
        $(this).children().addClass('list-deslN');//botao direito some
    }
    $(this).siblings('.left-desl').children().removeClass('list-deslN'); //botao esquerdo visivel
});

$('.left-desl').click(function(){
    var prox = $(this).parent().find('.itens');
    var matriz = prox.css('transform');
    var vet = matriz.split(',');
    var valor = vet[4];
    valor = parseInt(valor);
    
    var widthCont = parseInt($('.cont').css('width'));
    var itens_vis = widthCont / 320;
    var passou = -valor / 320;
    
    if(passou >= itens_vis){
        prox.css('transform', 'translateX('+(valor+(itens_vis * 320))+'px)');
        if(passou === itens_vis){
            $(this).children().addClass('list-deslN');//botao esquerdo some
        }
    }else if(passou < itens_vis){
        prox.css('transform', 'translateX('+(valor+(passou * 320))+'px)');
        $(this).children().addClass('list-deslN');//botao esquerdo some
    }
    $(this).siblings('.right-desl').children().removeClass('list-deslN');
});
//--------------------------------------- Filtros | Menu lateral --------------------------------------

$("[name=tipo_filter]").change(function() {//nao é defitivo
    var lang = $('[name=lang_filter]:checked').val();
    var tipo = $('[name=tipo_filter]:checked').val();
    CallCateg(lang,tipo);
});

$("[name=lang_filter]").change(function() {//nao é defitivo
    var lang = $('[name=lang_filter]:checked').val();
    var tipo = $('[name=tipo_filter]:checked').val();
    CallCateg(lang,tipo);
    
});

function CallCateg(id_lang, id_tipo){
    $('#inicio').removeClass('opc-selec');
    
    if(($('[name=tipo_filter]').is(':checked'))&&($('[name=lang_filter]').is(':checked'))){
        var href = 'categ.php?lang='+id_lang+'&tipo='+id_tipo;
        
        var name_lang = $('[name=lang_filter]:checked').data('name');
        var tipo_name = $('[name=tipo_filter]:checked').data('name');
        
        $('.lag').children('.tag-text').html('Linguagem '+name_lang);
        $('.tip').children('.tag-text').html('Tipo '+tipo_name);
        $('.eva-3-tag').addClass('-active');
                        
    }else if($('[name=tipo_filter]').is(':checked')){
        var href = 'categ.php?tipo='+id_tipo;
        var name_tipo = $('[name=tipo_filter]:checked').data('name');
        
        $('.tip').children('.tag-text').html('Tipo '+name_tipo);
        $('.tip').addClass('-active');
        
    }else if($('[name=lang_filter]').is(':checked')){
        var href = 'categ.php?lang='+id_lang;
        var name_lang = $('[name=lang_filter]:checked').data('name');
        
        $('.lag').children('.tag-text').html('Linguagem '+name_lang);
        $('.lag').addClass('-active');
    }else{
        location.href='index.php';
    }
    $.ajax({
        url: href,                          
        success: function(response){
            //forçando o parser
            var data = $( '<div>'+response+'</div>' ).find('#content').html();
            //apenas atrasando a troca, para mostrarmos o loading
            //window.setTimeout( function(){
            content.fadeOut(80, function(){                
                content.html( data ).fadeIn();
                window.history.pushState( href, 'page 2', href );
            });
                //}, 100 );
        }
    });
}


//-------------------------------- Equivoco | Gerenciar --------------------------------

$("[name=nome_solucao_prof_form]").change(function() { //carrega solucao professor escolhida
    var id = $(this).find(":selected").val();
    if(id !== 0){
        var data = 'id=' + id;
    
        $.ajax({
            type: 'POST',
            url: 'search/load-solucao.php', 
            data: data,
            success: function(retorno){
                $('#passos-prof>div').each(function(index){ //elimina passos vazios
                    if(index !== 0){
                        this.remove();
                    }
                });
                
                $("[name=passo1_prof]").val('');
                $("[name=solucao_prof_form]").val('');
                
                obj = JSON.parse(retorno);
                var descricao = obj['descricao'];
                var list_passos = obj['list_passos'];

                $("[name=solucao_prof_form]").val(descricao);

                for(var k in list_passos) { //passos
                    var nk = parseInt(k) + 1; //numero do passo

                    var descricao_passo = obj['list_passos'][k]['descricao_passo'];

                    if(nk > 1){
                        $('#passos-prof').append('<div data-ord="'+nk+'" class="padd-soluc"><strong>'+nk+'.</strong><input class="campo-regis inativo" type="text" name="passo'+nk+'_prof" value="'+descricao_passo+'" autocomplete="off"></div>');
                    }
                    $("[name=passo"+nk+"_prof]").val(descricao_passo);                
                }
            }
        });
    }else{
        $('#passos-prof>div').each(function(index){ //elimina passos vazios
            if(index !== 0){
                this.remove();
            }
        });
        $("[name=passo1_prof]").val('');
        $("[name=solucao_prof_form]").val('');
    }
});

$("[name=nome_solucao_aluno_form]").change(function() {//carrega solucao aluno escolhida
    var id = $(this).find(":selected").val();
    if(id !== 0){
        var data = 'id=' + id;
    
        $.ajax({
            type: 'POST',
            url: 'search/load-solucao.php', 
            data: data,
            success: function(retorno){
                $('#passos-aluno>div').each(function(index){ //elimina passos vazios
                    if(index !== 0){
                        this.remove();
                    }
                });
                
                $("[name=passo1_aluno]").val('');
                $("[name=solucao_aluno_form]").val('');
                
                obj = JSON.parse(retorno);
                var descricao = obj['descricao'];
                var list_passos = obj['list_passos'];

                $("[name=solucao_aluno_form]").val(descricao);

                for(var k in list_passos) { //passos
                    var nk = parseInt(k) + 1; //numero do passo

                    var descricao_passo = obj['list_passos'][k]['descricao_passo'];

                    if(nk > 1){
                        $('#passos-aluno').append('<div data-ord="'+nk+'" class="padd-soluc"><strong>'+nk+'.</strong><input class="campo-regis inativo" type="text" name="passo'+nk+'_aluno" value="'+descricao_passo+'" autocomplete="off"></div>');
                    }
                    $("[name=passo"+nk+"_aluno]").val(descricao_passo);                
                }
            }
        });
    }else{
        $('#passos-aluno>div').each(function(index){ //elimina passos vazios
            if(index !== 0){
                this.remove();
            }
        });
        $("[name=passo1_aluno]").val('');
        $("[name=solucao_aluno_form]").val('');
    }
});

$(window).scroll(function() {
    if($(this).scrollTop() > 47) {
        $('.bloc-buttons2').css('box-shadow', '0 6px 5px #008080 inset');
    }else{
        $('.bloc-buttons2').css('box-shadow', 'none');
    }
});

$(document).on('click', '.titulo-opc', function(){
    var id = $(this).attr("id");
    
    $('#bloc-pesq-equivoco').slideUp();    
    var data = 'id=' + id;
    
    $.ajax({
        type: 'POST',
        url: 'search/load-equivoco.php', 
        data: data,
        success: function(retorno){
            $('#save_equivoco').each(function(){ //limpa formulario
                this.reset();
            });
            
            $('#passos-prof>div').each(function(index){ //elimina passos vazios
                if(index !== 0){
                    this.remove();
                }
            });
            
            $('#passos-aluno>div').each(function(index){ //elimina passos vazios
                if(index !== 0){
                    this.remove();
                }
            });
            
            $('#tentativas>div').each(function(){ //elimina tentativas
                var tentativa = parseInt($(this).data('ord'));
                if(tentativa > 1){
                    this.remove();
                }
            });
            
            obj = JSON.parse(retorno);
            var titulo = obj['titulo'];
            var tipo = obj['tipo'];
            var lang = obj['lang'];
            var conteudo = obj['conteudo'];
            var corpo = obj['corpo'];
            var list_ocorre = obj['list_ocorre'];
            var id_solucao_prof = obj['id_solucao_prof'];
            var id_solucao_aluno = obj['id_solucao_aluno'];
            
            $("#title-top").html(titulo);
            $("#id-top").html(id);
            $("[name=id_form]").val(id);
            $("[name=titulo_form]").val(titulo);
            $("[name=tipo_form]").val(tipo);
            $("[name=linguagem_form]").val(lang);
            $("[name=conteudo_form]").val(conteudo);
            $("[name=corpo_form]").val(corpo);
            
            for(var k in list_ocorre) { //ocorrencias
                var nk = parseInt(k) + 1; //numero de ocorrencias
                var id_aluno = obj['list_ocorre'][k]['id_aluno'];
                var lang_ocorre = obj['list_ocorre'][k]['lang_ocorre'];
                var sub_total = obj['list_ocorre'][k]['sub_total'];
                var list_trat = obj['list_ocorre'][k]['list_trat'];
                
                $("[name=aluno_ocorre"+nk+"_form]").val(id_aluno);
                $("[name=lang_ocorre"+nk+"_form]").val(lang_ocorre);
                $("[name=sub_ocorre"+nk+"_form]").val(sub_total);
                
                
                var contexto_erro = obj['list_ocorre'][k]['list_erro']['contexto_erro'];
                var observacao_erro = obj['list_ocorre'][k]['list_erro']['observacao_erro'];
                var submissao_erro = obj['list_ocorre'][k]['list_erro']['submissao_erro'];
                $("[name=contexto_ocorre"+nk+"_form]").val(contexto_erro);
                $("[name=sub_erro_ocorre"+nk+"]").val(submissao_erro);
                $("[name=erro_ocorre"+nk+"]").val(observacao_erro);
                
                
                if(list_trat !== null){
                    for(var j in list_trat) { //tratamentos e erro
                        var nj = parseInt(j) +1;
                        var observacao_trat = obj['list_ocorre'][k]['list_trat'][j]['observacao_trat'];
                        var submissao_trat = obj['list_ocorre'][k]['list_trat'][j]['submissao_trat'];
                        
                        if(nj > 1){
                            var adc_tent = $('#evento'+nk).find('.adc-tent');
                            adc_tent.before('<div data-ord="'+nj+'" class="card6-1">'+
                                    '<div class="tent"><strong>'+nj+'ª tentativa</strong></div>'+
                                    '<div><input type="file" class="space-input" accept="image/*" name="tent_img'+nj+'_ocorre'+nk+'"></div>'+  
                                    '<div><strong class="card-title2">Submissão:</strong>'+
                                    '<input class="campo-regis" type="number" min="1" name="sub_tent'+nj+'_ocorre'+nk+'" value="" autocomplete="off"></div>'+
                                    '<div class="tent"><strong>Observação:</strong></div>'+
                                    '<div><textarea name="tent'+nj+'_ocorre'+nk+'"></textarea></div>'+                                            
                                '</div>');
                            
                        }
                        $("[name=sub_tent"+nj+"_ocorre"+nk+"]").val(submissao_trat);
                        
                        if(observacao_trat !== null){
                            $("[name=tent"+nj+"_ocorre"+nk+"]").val(observacao_trat);
                        }else{
                            $("[name=tent"+nj+"_ocorre"+nk+"]").val('');
                        }

                    }
                }else{
                    $("[name=tent1_ocorre"+nk+"]").val('');
                }
                
                if(nk > 2){ //verifica se ja se tornou um anti-padrao
                    $('#muda-equivoco').html('Antipadrão:');
                }
            }          
            
            
            if(id_solucao_prof !== null){
                var descricao_solucao_prof = obj['descricao_solucao_prof'];
                var list_passos_prof = obj['list_passos_prof'];                
                $("[name=nome_solucao_prof_form]").val(id_solucao_prof);
                $("[name=solucao_prof_form]").val(descricao_solucao_prof);
                
                for(var k in list_passos_prof) { // passos solucao professor
                    var nk = parseInt(k) + 1; //numero do passo
                    var descricao_passo = obj['list_passos_prof'][k]['descricao_passo'];
                    
                    if(nj > 1){
                        $('#passos-prof').append('<div data-ord="'+nk+'" class="padd-soluc"><strong>'+nk+'.</strong><input class="campo-regis inativo" type="text" name="passo'+nk+'_prof" value="'+descricao_passo+'" autocomplete="off"></div>');
                    }
                    $("[name=passo"+nk+"_prof]").val(descricao_passo);
                    
                }
            }
            
            $("#button_delete_equivoco").removeAttr('disabled');
            
            if(id_solucao_aluno !== null){
                var descricao_solucao_aluno = obj['descricao_solucao_aluno'];
                var list_passos_aluno = obj['list_passos_aluno'];                
                $("[name=nome_solucao_aluno_form]").val(id_solucao_aluno);
                $("[name=solucao_aluno_form]").val(descricao_solucao_aluno);
                
                for(var k in list_passos_aluno) { // passos solucao aluno
                    var nk = parseInt(k) + 1; //numero do passo
                    var descricao_passo = obj['list_passos_prof'][k]['descricao_passo'];
                    
                    if(nk > 1){
                        $('#passos-aluno').append('<div data-ord="'+nk+'" class="padd-soluc"><strong>'+nk+'.</strong><input class="campo-regis inativo" type="text" name="passo'+nk+'_aluno" value="'+descricao_passo+'" autocomplete="off"></div>');
                    }
                    $("[name=passo"+nk+"_aluno]").val(descricao_passo); 
                }
            }
            
        }, error: function(error){ 
            alert(error); 
        }
    });
});

function pesqEquivoco(){
    var text = $('#pesq-equivoco').val().trim();
    var id_form = $('#pesq-id').val().trim();
    $('#bloc-pesq-equivoco').slideDown();
    
    if((text.length !== 0)||(id_form.length !== 0)){
        
        var data = 'titulo=' + text + '&id='+id_form;
        $.ajax({
            type: 'POST',
            url: 'search/search-equivoco.php', 
            data: data,
            success: function(retorno){
                $('#opc-equivoco').html('');
                obj = JSON.parse(retorno);
                var vazio = obj[0];
               
                if(!vazio){
                    for(var k in obj) {
                        if(k !== '0'){
                            var titulo = obj[k]['titulo'];
                            var id = obj[k]['id'];
                            $('#opc-equivoco').append('<div id="'+id+'" class="regis titulo-opc"><div>'+titulo+'</div><div class="id-opc campo-id">'+id+'</div></div>');
                        }
                     }
                }
            }, error: function(error){ 
                alert(error); 
            }
        });
    }else{
        $('#opc-equivoco').html('');
    }
}

$('#pesq-equivoco').keyup(function(){
    pesqEquivoco();
});

$('#pesq-id').keyup(function(){
    pesqEquivoco();
});

function resultsSolucao(item, indice){ // mostrar resultados da pesquisa
    if(indice !== 0){
        $('#opc-solucao').append('<div>- '+item+'</div>');
    }
}

$('#pesq-solucao-equivoco').keyup(function(){ //pesquisar pelo tipo
    var text = $(this).val().trim();
    if(text.length !== 0){
        $("#alert16").html('');
        $(this).css("border", "1px solid #b2d8d8");
        
        var data = 'string=' + text;
        $.ajax({
            type: 'POST',
            url: 'search/search-nome-solucao.php', 
            data: data,
            success: function(retorno){
                $('#opc-solucao').html('');
                obj = JSON.parse(retorno);
                var vazio = obj[0];
                if(!vazio){
                    obj.forEach(resultsSolucao);
                }
            }, error: function(error){ 
                alert(error); 
            }
        });
    }else{
        $('#opc-solucao').html('');
    }
});

$('.adc-tentativa').click(function(){ //adicionar tentativa
    var ocorre = $(this).data('ocorre');
    var target = $(this).parent().prev();
    var tentativa = parseInt(target.data('ord'));
    
    if(tentativa<=9){
        $(this).parent().before('<div data-ord="'+(tentativa+1)+'" class="card6-1">'+
                                    '<div class="tent"><strong>'+(tentativa+1)+'ª tentativa</strong></div>'+
                                    '<div><input type="file" class="space-input" accept="image/*" name="tent_img'+(tentativa+1)+'_ocorre'+ocorre+'"></div>'+  
                                    '<div><strong class="card-title2">Submissão:</strong>'+
                                    '<input class="campo-regis" type="number" min="1" name="sub_tent'+(tentativa+1)+'_ocorre'+ocorre+'" value="" autocomplete="off"></div>'+
                                    '<div class="tent"><strong>Observação:</strong></div>'+
                                    '<div><textarea name="tent'+(tentativa+1)+'_ocorre'+ocorre+'"></textarea></div>'+                                            
                                '</div>');
        if(tentativa === 9){
            $(this).parent().hide();
        }
    }
});

$('#adc-passo-prof').click(function(){ //adicionar passo professor
    var target = $('#passos-prof-form').children().last();
    var passo = parseInt(target.data('ord'));
    var valor = target.children('input').val().trim();
    
    if(valor.length === 0){
        $(this).next().html('Passo anterior vazio');
        target.children('input').css('border', '1px solid #f00');
    }else{
        $(this).next().html(''); //retira o alerta
        target.children('input').css('border', "1px solid #b2d8d8");
        if(passo<=19){
            $('#passos-prof-form').append('<div data-ord="'+(passo+1)+'" class="padd-soluc"><strong>'+(passo+1)+'.</strong><input class="campo-regis" type="text" name="passo_form_solucao_prof[]" value="" autocomplete="off"></div>');
            if(passo === 19){
                $(this).parent().hide();
            }else{
                $(this).prev().html((passo+2)+'.');
            }
        }
    }    
});

$('#adc-passo-aluno').click(function(){ //adicionar passo aluno
    var target = $('#passos-aluno-form').children().last();
    var passo = parseInt(target.data('ord'));
    var valor = target.children('input').val().trim();
    if(valor.length === 0){
        $(this).next().html('Passo anterior vazio');
        target.children('input').css('border', '1px solid #f00');
    }else{
         $(this).next().html(''); //retira o alerta
        target.children('input').css('border', "1px solid #b2d8d8");
        if(passo<=19){
            $('#passos-aluno-form').append('<div data-ord="'+(passo+1)+'" class="padd-soluc"><strong>'+(passo+1)+'.</strong><input class="campo-regis" type="text" name="passo_form_solucao_aluno[]" value="" autocomplete="off"></div>');
            if(passo === 19){
                $(this).parent().hide();
            }else{
                $(this).prev().html((passo+2)+'.');
            }
        }
    }    
});

$('#button-pesq').click(function(){//expandir caixa pesquisa equivoco
    if($('#bloc-pesq-equivoco').is(':visible')){
        $('#bloc-pesq-equivoco').slideUp();
    }else{
        $('#bloc-novo-solucao-aluno').slideUp();
        $('#bloc-novo-solucao-prof').slideUp();
        $('#bloc-novo-tipo').slideUp();
        $('#bloc-novo-conteudo').slideUp();
        $('#bloc-novo-linguagem').slideUp();
        $('#bloc-novo-ocorrencia').slideUp();
        $('#bloc-pesq-equivoco').slideDown();
    }    
});

$('#novo-tipo').click(function(){//expandir caixa de novo tipo
    if($('#bloc-novo-tipo').is(':visible')){
        $('#bloc-novo-tipo').slideUp();
    }else{
        $('#bloc-novo-solucao-aluno').slideUp();
        $('#bloc-pesq-equivoco').slideUp();
        $('#bloc-novo-solucao-prof').slideUp();
        $('#bloc-novo-conteudo').slideUp();
        $('#bloc-novo-linguagem').slideUp();
        $('#bloc-novo-ocorrencia').slideUp();
        $('#bloc-novo-tipo').slideDown();
    }
    
});

$('#novo-linguagem').click(function(){ //expandir caixa de nova linguagem
    if($('#bloc-novo-linguagem').is(':visible')){
        $('#bloc-novo-linguagem').slideUp();
    }else{
        $('#bloc-novo-solucao-aluno').slideUp();
        $('#bloc-novo-solucao-prof').slideUp();
        $('#bloc-pesq-equivoco').slideUp();
        $('#bloc-novo-tipo').slideUp();
        $('#bloc-novo-conteudo').slideUp();
        $('#bloc-novo-ocorrencia').slideUp();
        $('#bloc-novo-linguagem').slideDown();
    }
    
});

$('#novo-conteudo').click(function(){ //expandir caixa de novo conteudo
    if($('#bloc-novo-conteudo').is(':visible')){
        $('#bloc-novo-conteudo').slideUp();
    }else{
        $('#bloc-novo-solucao-aluno').slideUp();
        $('#bloc-novo-solucao-prof').slideUp();
        $('#bloc-pesq-equivoco').slideUp();
        $('#bloc-novo-tipo').slideUp();
        $('#bloc-novo-linguagem').slideUp();
        $('#bloc-novo-ocorrencia').slideUp();
        $('#bloc-novo-conteudo').slideDown();
    }
});

$('#novo-ocorrencia').click(function(){ //expandir caixa de novo ocorrencia
    if($('#bloc-novo-ocorrencia').is(':visible')){
        $('#bloc-novo-ocorrencia').slideUp();
    }else{
        $('#bloc-novo-solucao-aluno').slideUp();
        $('#bloc-novo-solucao-prof').slideUp();
        $('#bloc-pesq-equivoco').slideUp();
        $('#bloc-novo-tipo').slideUp();
        $('#bloc-novo-linguagem').slideUp();
        $('#bloc-novo-conteudo').slideUp();
        $('#bloc-novo-ocorrencia').slideDown();
    }
});

$('#novo-solucao-prof').click(function(){ //expandir caixa de nova solucao aluno
    if($('#bloc-novo-solucao-prof').is(':visible')){
        $('#bloc-novo-solucao-prof').slideUp();
    }else{
        $('#bloc-novo-ocorrencia').slideUp();
        $('#bloc-pesq-equivoco').slideUp();
        $('#bloc-novo-tipo').slideUp();
        $('#bloc-novo-linguagem').slideUp();
        $('#bloc-novo-conteudo').slideUp();
        $('#bloc-novo-solucao-aluno').slideUp();
        $('#bloc-novo-solucao-prof').slideDown();
    }
});

$('#novo-solucao-aluno').click(function(){ //expandir caixa de nova solucao aluno
    if($('#bloc-novo-solucao-aluno').is(':visible')){
        $('#bloc-novo-solucao-aluno').slideUp();
    }else{
        $('#bloc-novo-ocorrencia').slideUp();
        $('#bloc-novo-solucao-prof').slideUp();
        $('#bloc-pesq-equivoco').slideUp();
        $('#bloc-novo-tipo').slideUp();
        $('#bloc-novo-linguagem').slideUp();
        $('#bloc-novo-conteudo').slideUp();
        $('#bloc-novo-solucao-aluno').slideDown();
    }
});

$('#button_novo_tipo').click(function(){ //salvar tipo no banco pelo cadastro de equivoco
    var text = $("#pesq-tipo").val().trim();
    
    if(text.length !== 0){        
        var data = 'tipo_cad=' + text;
        
        $.ajax({
            url: "save/save-tipo.php",
            type: 'POST',
            data: data,
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                if(salvo){
                    $("#pesq-tipo").val(''); //limpa o campo
                    $("[name=tipo_form]").append('<option value="'+text+'">'+text+'</option>'); //adiciona na lista dos tipos
                    $("[name=tipo_form]").val(text);
                    $('#bloc-novo-tipo').slideUp();
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Tipo cadastrado com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Tipo já cadastrado');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $(".bloc-novo #pesq-tipo").css('border', '1px solid #f00');
        $(".bloc-novo #alert2").html('campo vazio');
    }
});

$('#button_novo_linguagem').click(function(){ //salvar linguagem no banco pelo cadastro de equivoco
    var text = $("#pesq-lang").val().trim();
    
    if(text.length !== 0){
        var data = 'linguagem_cad=' + text;
        
        $.ajax({
            url: "save/save-linguagem.php",
            type: 'POST',
            data: data,
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                if(salvo){
                    $("#pesq-lang").val(''); //limpa o campo
                    $("[name=linguagem_form]").append('<option value="'+text+'">'+text+'</option>'); //adiciona na lista das linguagens
                    $("[name=linguagem_form]").val(text); //seleciona a linguagem que cadastrou
                    
                    $("[name=lang_ocorre1_form]").append('<option value="'+text+'">'+text+'</option>');
                    $("[name=lang_ocorre2_form]").append('<option value="'+text+'">'+text+'</option>');
                    
                    $('#bloc-novo-linguagem').slideUp(); //fecha caixa de nova linguagem
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Linguagem cadastrada com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Linguagem já cadastrada');
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $(".bloc-novo #pesq-lang").css('border', '1px solid #f00');
        $(".bloc-novo #alert3").html('campo vazio');
    }
});

$('#button_novo_conteudo').click(function(){ //salvar conteudo no banco pelo cadastro de equivoco
    var text = $("#pesq-conteudo").val().trim();
    
    if(text.length !== 0){
        var data = 'conteudo_cad=' + text;
        
        $.ajax({
            url: "save/save-conteudo.php",
            type: 'POST',
            data: data,
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                if(salvo){
                    $("#pesq-conteudo").val(''); //limpa o campo
                    $("[name=conteudo_form]").append('<option value="'+text+'">'+text+'</option>'); //adiciona na lista dos conteudos
                    $("[name=conteudo_form]").val(text); //seleciona a linguagem que cadastrou
                    $('#bloc-novo-conteudo').slideUp(); //fecha caixa de novo conteudo
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Conteúdo cadastrado com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Conteúdo já cadastrado');
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $(".bloc-novo #pesq-conteudo").css('border', '1px solid #f00');
        $(".bloc-novo #alert4").html('campo vazio');
    }
});

$('#button_novo_solucao').click(function(){ //salvar solucao professor no banco pelo cadastro de equivoco
    var nome = $("#pesq-solucao-equivoco").val().trim();
    var alvo = $('[name=alvo_form_solucao_prof]:checked').val();
    var descricao = $("[name=descricao_form_solucao_prof]").val().trim();
   
    
    if(nome.length !== 0){
        var list_passos = new Array();
        
        $("input[name='passo_form_solucao_prof[]']").each(function(){
           list_passos.push($(this).val());
        });

        var jsonString = JSON.stringify(list_passos);
        
        $.ajax({
            url: "save/save-solucao-equivoco.php",
            type: 'POST',
            data: {list_passos : jsonString, nome: nome, alvo: alvo, descricao: descricao},
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                var mensag = obj['mensag'];
                
                
                if(salvo){
                    var id_solucao = obj['id_solucao'];
                    
                    $("#pesq-solucao-equivoco").val(''); //limpa o campo
                    $("[name=alvo_form_solucao_prof]").prop( "checked" , false);  
                    $("[name=descricao_form_solucao_prof]").val('');
                    $('#passos-prof-form>div').each(function(index){ //elimina passos vazios do form
                        if(index !== 0){
                            this.remove();
                        }
                    });
                    $('#adc-passo-prof').prev().html('2.');
                    $("#passos-prof-form input").val('');
                    $('#adc-passo-prof').next().html('');
                    
                    $("[name=nome_solucao_prof_form]").append('<option value="'+id_solucao+'">'+nome+'</option>'); //adiciona na lista das solucoes 
                    $("[name=nome_solucao_prof_form]").val(id_solucao); //seleciona a solucao que cadastrou                    
                    
                    $('#passos-prof>div').each(function(index){ //elimina passos vazios
                        if(index !== 0){
                            this.remove();
                        }
                    });
                    $("[name=passo1_prof]").val('');
                    $("[name=solucao_prof_form]").val('');
                    
                    $("[name=solucao_prof_form]").val(descricao);

                    for(var k in list_passos) { //passos
                        var nk = parseInt(k) + 1; //numero do passo

                        var descricao_passo = list_passos[k];

                        if(nk > 1){
                            $('#passos-prof').append('<div data-ord="'+nk+'" class="padd-soluc"><strong>'+nk+'.</strong><input class="campo-regis inativo" type="text" name="passo'+nk+'_prof" value="'+descricao_passo+'" autocomplete="off"></div>');
                        }
                        $("[name=passo"+nk+"_prof]").val(descricao_passo);                
                    }
                    
                    $('#bloc-novo-solucao-prof').slideUp(); //fecha caixa de nova solucao
                    
                    
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html(mensag);
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html(mensag);
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $(".bloc-novo #pesq-solucao-equivoco").css('border', '1px solid #f00');
        $(".bloc-novo #alert4").html('campo vazio');
    }
});

$('#button_novo_solucao_aluno').click(function(){ //salvar solucao aluno no banco pelo cadastro de equivoco
    var nome = $("#pesq-solucao-equivoco-aluno").val().trim();
    var alvo = $('[name=alvo_form_solucao_aluno]:checked').val();
    var descricao = $("[name=descricao_form_solucao_aluno]").val().trim();
   
    
    if(nome.length !== 0){
        var list_passos = new Array();
        
        $("input[name='passo_form_solucao_aluno[]']").each(function(){
           list_passos.push($(this).val());
        });

        var jsonString = JSON.stringify(list_passos);
        
        $.ajax({
            url: "save/save-solucao-equivoco.php",
            type: 'POST',
            data: {list_passos : jsonString, nome: nome, alvo: alvo, descricao: descricao},
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                var mensag = obj['mensag'];
                
                
                if(salvo){
                    var id_solucao = obj['id_solucao'];
                    
                    $("#pesq-solucao-equivoco-aluno").val(''); //limpa o campo
                    $("[name=alvo_form_solucao_aluno]").prop( "checked" , false);  
                    $("[name=descricao_form_solucao_aluno]").val('');
                    $('#passos-aluno-form>div').each(function(index){ //elimina passos vazios do form
                        if(index !== 0){
                            this.remove();
                        }
                    });
                    $('#adc-passo-aluno').prev().html('2.');
                    $("#passos-aluno-form input").val('');
                    $('#adc-passo-aluno').next().html('');
                    
                    $("[name=nome_solucao_aluno_form]").append('<option value="'+id_solucao+'">'+nome+'</option>'); //adiciona na lista das solucoes 
                    $("[name=nome_solucao_aluno_form]").val(id_solucao); //seleciona a solucao que cadastrou                    
                    
                    $('#passos-aluno>div').each(function(index){ //elimina passos vazios
                        if(index !== 0){
                            this.remove();
                        }
                    });
                    $("[name=passo1_aluno]").val('');
                    $("[name=solucao_aluno_form]").val('');
                    
                    $("[name=solucao_aluno_form]").val(descricao);

                    for(var k in list_passos) { //passos
                        var nk = parseInt(k) + 1; //numero do passo

                        var descricao_passo = list_passos[k];

                        if(nk > 1){
                            $('#passos-aluno').append('<div data-ord="'+nk+'" class="padd-soluc"><strong>'+nk+'.</strong><input class="campo-regis inativo" type="text" name="passo'+nk+'_aluno" value="'+descricao_passo+'" autocomplete="off"></div>');
                        }
                        $("[name=passo"+nk+"_aluno]").val(descricao_passo);                
                    }
                    
                    $('#bloc-novo-solucao-aluno').slideUp(); //fecha caixa de nova solucao
                    
                    
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html(mensag);
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html(mensag);
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $(".bloc-novo #pesq-solucao-equivoco-aluno").css('border', '1px solid #f00');
        $(".bloc-novo #alert4").html('campo vazio');
    }
});

$('form#save_equivoco').submit(function(e) { //salvar equivoco no banco
    e.preventDefault();
    var text = $("[name=titulo_form]").val().trim();
    
    if(text.length !== 0){
        
        var formData = new FormData(this);
        
        $.ajax({
            url: "save-equivoco.php",
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                var mensag = obj['mensag'];
                if(salvo){
                    $('#save_equivoco').each(function(){ //limpa formulario
                        this.reset();
                    });
                    $('#passos-aluno>div').each(function(index){ //elimina passos vazios do form
                        if(index !== 0){
                            this.remove();
                        }
                    });
                    $('#passos-prof>div').each(function(index){ //elimina passos vazios do form
                        if(index !== 0){
                            this.remove();
                        }
                    });
                    $('#tentativas>div').each(function(){ //elimina tentativas
                        var tentativa = parseInt($(this).data('ord'));
                        if(tentativa > 1){
                            this.remove();
                        }
                    });
                    $("#title-top").html('');
                    $("#id-top").html('');
                    $("#button_delete_equivoco").attr('disabled', 'disabled');
                    
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Salvo com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html(mensag);
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("[name=titulo_form]").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert1").html('*campo obrigatório');
    }
});

$('#button_delete_equivoco').click(function(){ //deletar equivoco
    var id_equivoco = $("[name=id_form]").val();
    var data = 'id='+id_equivoco;
    $.ajax({
        url: "remove/remove-equivoco.php",
        type: 'POST',
        data: data,
        success: function (retorno) {
            obj = JSON.parse(retorno);
            var removeu = obj['removeu'];
            if(removeu){
                $('#save_equivoco').each(function(){
                    this.reset();
                });
                $("#title-top").html('');
                $("#id-top").html('');
                $("#button_delete_equivoco").attr('disabled', 'disabled');
                $( ".notify" ).removeClass('alert');
                $( ".notify" ).html('Removido com Sucesso!');
                $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
            }else{
                $( ".notify" ).addClass('alert');
                $( ".notify" ).html('Falha ao Remover!');
                $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
            }
        }
    });
});



//-------------------------------- Tipo de Erro | Gerenciar ----------------------------

function resultsTipo(item, indice){ // mostrar resultados da pesquisa
    if(indice !== 0){
        $('#opc-tipo').append('<div>- '+item+'</div>');
    }
}
                    
$('#pesq-tipo').keyup(function(){ //pesquisar pelo tipo
    var text = $("#pesq-tipo").val().trim();
    if(text.length !== 0){
        $(".bloc-novo #alert2").html('');
        $("#alert1").html(''); //retira o alerta de campo vazio
        $(".regis-card #pesq-tipo").css("box-shadow", "none");
        $(".bloc-novo #pesq-tipo").css("border", "1px solid #b2d8d8");
        
        var data = 'string=' + text;
        $.ajax({
            type: 'POST',
            url: 'search/search_tipo.php', 
            data: data,
            success: function(retorno){
                $('#opc-tipo').html('');
                obj = JSON.parse(retorno);
                var vazio = obj[0];
                if(!vazio){
                    obj.forEach(resultsTipo);
                }
            }, error: function(error){ 
                alert(error); 
            }
        });
    }else{
        $('#opc-tipo').html('');
    }
});

$('#button_save_tipo').click(function(e) { //salvar tipo no banco
    e.preventDefault();
    var text = $("#pesq-tipo").val().trim();
    
    if(text.length !== 0){
        $.ajax({
            url: "save/save-tipo.php",
            type: 'POST',
            data: $('#save_tipo').serialize(),
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                if(salvo){
                    $("#pesq-tipo").val(''); //limpa o campo
                    $("[name=tipo_rem]").append('<option value="'+text+'">'+text+'</option>'); //adiciona na lista dos tipos para remover
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Cadastrado com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Tipo já cadastrado');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("#pesq-tipo").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert1").html('campo vazio');
    }
});

$('#button_remov_tipo').click(function(e) { //remover tipo do banco
    e.preventDefault();
    var val = $("[name=tipo_rem]").find(":selected").val();
    
    if(val !== ''){
        $.ajax({
            url: "remove/remove-tipo.php",
            type: 'POST',
            data: $('#remove_tipo').serialize(),
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var removeu = obj['removeu'];
                if(removeu){
                    $("[name=tipo_rem]").find(":selected").remove();
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Removido com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Falha ao Remover!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("[name=tipo_rem]").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert2").html('Selecione uma opção');
    }
});

$("[name=tipo_rem]").change(function() { // remove o alerta ao selecionar tipo de erro
    var val = $(this).find(":selected").val();
    if(val !== ''){
        $(this).css("box-shadow", "none");;
        $("#alert2").html('');
    }
});

//----------------------------- Linguagem | Gerenciar ---------------------------

function resultsLang(item, indice){ // mostrar resultados da pesquisa
    if(indice !== 0){
        $('#opc-linguagem').append('<div>- '+item+'</div>');
    }
}

$('#pesq-lang').keyup(function(){ //pesquisar pela linguagem
    var text = $(this).val().trim();
    $('#opc-linguagem').html('');
    
    if(text.length !== 0){
        $(".bloc-novo #alert3").html('');
        $(".bloc-novo #pesq-lang").css("border", "1px solid #b2d8d8");
        $("#alert1").html(''); //retira o alerta 'campo vazio'
        $(this).css("box-shadow", "none");
        
        var data = 'string=' + text;
        $.ajax({
            type: 'POST',
            url: 'search/search-linguagem.php', 
            data: data,
            success: function(retorno){
                obj = JSON.parse(retorno);
                var vazio = obj[0];
                if(!vazio){
                    obj.forEach(resultsLang);
                }
            }, error: function(error){ 
                alert(error); 
            }
        });
    }
});

$('#button_save_linguagem').click(function(e) { //salvar linguagem no banco
    e.preventDefault();
    var text = $("#pesq-lang").val().trim();
    
    if(text.length !== 0){
        $.ajax({
            url: "save/save-linguagem.php",
            type: 'POST',
            data: $('#save_linguagem').serialize(),
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                if(salvo){
                    $("#pesq-lang").val(''); //limpa o campo
                    $("[name=linguagem_rem]").append('<option value="'+text+'">'+text+'</option>'); //adiciona na lista das linguagens para remover
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Cadastrado com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Linguagem já cadastrado');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("#pesq-lang").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert1").html('campo vazio');
    }
});

$('#button_remove_linguagem').click(function(e) { //remover linguagem do banco
    e.preventDefault();
    var val = $("[name=linguagem_rem]").find(":selected").val();
    
    if(val !== ''){
        $.ajax({
            url: "remove/remove-linguagem.php",
            type: 'POST',
            data: $('#remove_linguagem').serialize(),
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var removeu = obj['removeu'];
                if(removeu){
                    $("[name=linguagem_rem]").find(":selected").remove();
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Removido com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Falha ao Remover!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("[name=linguagem_rem]").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert2").html('Selecione uma opção');
    }
});

$("[name=linguagem_rem]").change(function() { // remove o alerta ao selecionar linguagem
    var val = $(this).find(":selected").val();
    if(val !== ''){
        $(this).css("box-shadow", "none");;
        $("#alert2").html('');
    }
});

//-------------------------------- Conteúdo | Gerenciar --------------------------------

function resultsConteudo(item, indice){ // mostrar resultados da pesquisa
    if(indice !== 0){
        $('#opc-conteudo').append('<div>- '+item+'</div>');
    }
}

$('#pesq-conteudo').keyup(function(){ //pesquisar pelo conteudo
    var text = $(this).val().trim();
    $('#opc-conteudo').html('');
    
    if(text.length !== 0){
        $(".bloc-novo #alert4").html('');
        $(".bloc-novo #pesq-conteudo").css("border", "1px solid #b2d8d8");
        $("#alert1").html(''); //retira o alerta 'campo vazio'
        $(this).css("box-shadow", "none");
        
        var data = 'string=' + text;
        $.ajax({
            type: 'POST',
            url: 'search/search-conteudo.php', 
            data: data,
            success: function(retorno){
                obj = JSON.parse(retorno);
                var vazio = obj[0];
                if(!vazio){
                    obj.forEach(resultsConteudo);
                }else{
                    $('#opc-conteudo').html('');
                }
            }, error: function(error){ 
                alert(error); 
            }
        });
    }
});

$('#button_save_conteudo').click(function(e) { //salvar conteudo no banco
    e.preventDefault();
    var text = $("#pesq-conteudo").val().trim();
    
    if(text.length !== 0){
        $.ajax({
            url: "save/save-conteudo.php",
            type: 'POST',
            data: $('#save_conteudo').serialize(),
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                if(salvo){
                    $("#pesq-conteudo").val(''); //limpa o campo
                    $("[name=conteudo_rem]").append('<option value="'+text+'">'+text+'</option>'); //adiciona na lista dos conteudos para remover
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Cadastrado com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Conteúdo já cadastrado');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("#pesq-conteudo").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert1").html('campo vazio');
    }
});

$('#button_remove_conteudo').click(function(e) { //remover conteudo do banco
    e.preventDefault();
    var val = $("[name=conteudo_rem]").find(":selected").val();
    
    if(val !== ''){
        $.ajax({
            url: "remove/remove-conteudo.php",
            type: 'POST',
            data: $('#remove_conteudo').serialize(),
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var removeu = obj['removeu'];
                if(removeu){
                    $("[name=conteudo_rem]").find(":selected").remove();
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Removido com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Falha ao Remover!');
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("[name=conteudo_rem]").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert2").html('Selecione uma opção');
    }
});

$("[name=conteudo_rem]").change(function() { // remove o alerta ao selecionar conteudo
    var val = $(this).find(":selected").val();
    if(val !== ''){
        $(this).css("box-shadow", "none");;
        $("#alert2").html('');
    }
});

//-------------------------------- Solução | Gerenciar --------------------------------

$('#button-pesq-solucao').click(function(){//expandir caixa pesquisa solucao
    if($('#bloc-pesq-solucao').is(':visible')){
        $('#bloc-pesq-solucao').slideUp();
    }else{
        $('#bloc-pesq-solucao').slideDown();
    }
    
});

$('#pesq-solucao').keyup(function(){
    pesqSolucao();
});

$('#pesq-id-solucao').keyup(function(){
    pesqSolucao();
});

$("[name=conteudo_form_solucao]").change(function() {
    var val = $(this).find(":selected").val();
    if(val !== ''){
        pesqSolucao();
    }
});

function pesqSolucao(){ //pesquisar solucao no banco
    var text = $('#pesq-solucao').val().trim();
    var id_form = $('#pesq-id-solucao').val().trim();
    var id_conteudo = $("[name=conteudo_form_solucao]").find(":selected").val();
    
    $('#bloc-pesq-solucao').slideDown();
    
    if((text.length !== 0)||(id_form.length !== 0)||(id_conteudo.length !== 0)){
        
        var data = 'nome=' + text + '&id='+id_form + '&id_conteudo='+id_conteudo;
        $.ajax({
            type: 'POST',
            url: 'search/search-solucao.php', 
            data: data,
            success: function(retorno){
                $('#opc-solucao').html('');
                obj = JSON.parse(retorno);
                var vazio = obj[0];
               
                if(!vazio){
                    for(var k in obj) {
                        if(k !== '0'){
                            var nome = obj[k]['nome'];
                            var id = obj[k]['id'];
                            $('#opc-solucao').append('<div id="'+id+'" class="regis nome-opc"><div>'+nome+'</div><div class="id-opc campo-id">'+id+'</div></div>');
                        }
                     }
                }
            }, error: function(error){ 
                alert(error); 
            }
        });
    }else{
        $('#opc-solucao').html('');
    }
}

$('#adc-passo-solucao').click(function(){ //adicionar passo solucao
    var target = $('#passos-solucao').children().last();
    var passo = parseInt(target.data('ord'));
    var valor = target.children('input').val().trim();
    if(valor.length === 0){
        $(this).next().html('Passo anterior vazio');
        target.children('input').css('box-shadow', '0 0 5px #f00 inset');
    }else{
        $(this).next().html(''); //retira o alerta
        target.children('input').css("box-shadow", "none");
        if(passo<=19){
            $('#passos-solucao').append('<div data-ord="'+(passo+1)+'" class="padd-soluc"><strong>'+(passo+1)+'.</strong><input class="campo-regis" type="text" name="passo'+(passo+1)+'_form_solucao" value="" autocomplete="off"></div>');
            if(passo === 19){
                $(this).parent().hide();
            }else{
                $(this).prev().html((passo+2)+'.');
            }
        }
    }    
});

$('form#save_solucao').submit(function(e) { //salvar solucao no banco
    e.preventDefault();
    var text = $("[name=nome_form_solucao]").val().trim();
    var alvo = $("[name=alvo_form_solucao]:checked").val();
    
    if(text.length !== 0){
        
        var formData = new FormData(this);
        
        $.ajax({
            url: "save/save-solucao.php",
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                var mensag = obj['mensag'];
                if(salvo){
                    $('#save_solucao').each(function(){ //limpa formulario
                        this.reset();
                    });
                    $("#nome-top").html('');
                    $( ".notify" ).removeClass('alert');
                    $("#button_delete_solucao").attr('disabled', 'disabled');
                    $('#passos-solucao>div').each(function(index){ //elimina passos vazios
                        if(index !== 0){
                            this.remove();
                        }
                    });
                    $('#adc-passo-solucao').prev().html('2.');
                    $( ".notify" ).html(mensag);
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html(mensag);
                    $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $("[name=nome_form_solucao]").css('box-shadow', '0 0 5px #f00 inset');
        $("#alert1").html('*campo obrigatório');
    }
});

$(document).on('click', '.nome-opc', function(){
    var id = $(this).attr("id"); 
    
    $('#bloc-pesq-solucao').slideUp();
    var data = 'id=' + id;
    
    $.ajax({
        type: 'POST',
        url: 'search/load-solucao.php', 
        data: data,
        success: function(retorno){
            obj = JSON.parse(retorno);
            var nome = obj['nome'];
            var alvo = obj['alvo'];
            var descricao = obj['descricao'];
            var list_passos = obj['list_passos'];
            var list_relacao = obj['list_relacao'];
            
            $('#save_solucao').each(function(){
                this.reset();
            });
            
            $("#nome-top").html(nome);
            
            $("[name=nome_form_solucao]").val(nome);
            $("[name=id_form_solucao]").val(id);
            $("[name=alvo_form_solucao][value="+alvo+"]").prop( "checked" , true);
            $("[name=descricao_form_solucao]").val(descricao);
            
            for(var k in list_passos) { //passos
                var nk = parseInt(k) + 1; //numero do passo
                
                var descricao_passo = obj['list_passos'][k]['descricao_passo'];
                
                if(nk > 1){
                    $('#passos-solucao').append('<div data-ord="'+nk+'" class="padd-soluc"><strong>'+nk+'.</strong><input class="campo-regis" type="text" name="passo'+nk+'_form_solucao" value="" autocomplete="off"></div>');
                    $('#adc-passo-solucao').prev().html((nk+1)+'.');
                }
                $("[name=passo"+nk+"_form_solucao]").val(descricao_passo);                
            }
            for(var r in list_relacao) { //conteudos
                
                var id_conteudo = obj['list_relacao'][r];
                
                $("input[type=checkbox][value="+id_conteudo+"]").prop( "checked" , true);             
            }
            $("#button_delete_solucao").removeAttr('disabled');
            
        }, error: function(error){ 
            alert(error); 
        }
    });
});

$('#button_delete_solucao').click(function(){ //deletar solucao
    var id_solucao = $("[name=id_form_solucao]").val().trim();
    var data = 'id='+id_solucao;
    
    $.ajax({
        url: "remove/remove-solucao.php",
        type: 'POST',
        data: data,
        success: function (retorno) {
            obj = JSON.parse(retorno);
            var removeu = obj['removeu'];
            if(removeu){
                $('#save_solucao').each(function(){
                    this.reset();
                });
                $("#nome-top").html('');
                
                $('#passos-solucao>div').each(function(index){ //elimina passos vazios
                    if(index !== 0){
                        this.remove();
                    }
                });
                $('#adc-passo-solucao').prev().html('2.');
                $("#button_delete_solucao").attr('disabled', 'disabled');
                $( ".notify" ).removeClass('alert');
                $( ".notify" ).html('Removido com Sucesso!');
                $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
            }else{
                $( ".notify" ).addClass('alert');
                $( ".notify" ).html('Falha ao Remover!');
                $( ".notify" ).fadeIn( 300 ).delay( 4000 ).fadeOut( 400 );
            }
        }
    });
});

$('#button_novo_conteudo_solucao').click(function(){ //salvar conteudo no banco pelo cadastro de solucao
    var text = $("#pesq-conteudo").val().trim();
    
    if(text.length !== 0){
        var data = 'conteudo_cad=' + text;
        
        $.ajax({
            url: "save/save-conteudo.php",
            type: 'POST',
            data: data,
            success: function (retorno) {
                obj = JSON.parse(retorno);
                var salvo = obj['salvo'];
                var id = obj['id_conteudo'];
                if(salvo){
                    $("#pesq-conteudo").val(''); //limpa o campo
                    
                    $("[name=conteudo_form_solucao]").append('<option value="'+id+'">'+text+'</option>'); //adiciona na lista dos conteudos
                    
                    $("#relacoes_cont_solucao").append('<div class="opc"><label class="cont-rel">'+
                                                            '<input type="checkbox" class="checkbox-tag" name="conteudo_relacao[]" value="'+id+'">'+
                                                            '<i class="checkbox filters-checkbox-left"><i class="mark-check"></i></i>'+
                                                            '<span class="opc-font">'+text+'</span></label>'+
                                                        '</div>');
                    
                    $("input[value="+id+"]").prop( "checked" , true); //seleciona o conteudo que cadastrou
                    
                    $('#bloc-novo-conteudo').slideUp(); //fecha caixa de novo conteudo
                    $( ".notify" ).removeClass('alert');
                    $( ".notify" ).html('Conteúdo cadastrado com Sucesso!');
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }else{
                    $( ".notify" ).addClass('alert');
                    $( ".notify" ).html('Conteúdo já cadastrado');
                    $( ".notify" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
                }
            }
        });
    }else{
        $(".bloc-novo #pesq-conteudo").css('border', '1px solid #f00');
        $(".bloc-novo #alert4").html('campo vazio');
    }
});