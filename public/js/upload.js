$(document).ready(function () {
    $('#form-add').on('submit',function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $form=$(this);
        if(!$('#site').val()){
            alert("Veuillez entrer un site");
            return false;
        }

        var image_name=$('#image').val()
        if(!image_name){
            alert("Veuillez choisir un logo");
            return false;
        }
        var extention=$('#image').val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extention,['png','jpg','jpeg','gif'])==-1){
            alert('image invalide')
            $('#image').val('')
            return false
        }
//
//
        var $url=$(location).attr('href').replace("admin/g_site","lib/operation.php");
        $form.find('button').text('..chargement..');
//         console.log($form.serializeArray())
//         // $.post($url,$form.serializeArray())
//         //     .done(function (data,text,jqxhr) {
//         //         $tr=$(jqxhr.responseText);
//         //        $('.table tbody').prepend($tr);
//         //        $tr.hide().fadeIn();
//         // })
//         //     .fail(function (jqxhr) {
//         //         alert(jqxhr.responseText());
//         //     }).always(function () {
//         //     $form.find('button').text('Ajouter').prepend("<span class='glyphicon glyphicon-floppy-saved'></span> ");
//         //     $('#site').val('');
//         //     $('#image').val('');
//         //     })
        $.ajax({
            url: $url,
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            timeout: 1000 * 100,
            processData:false,
        }).done(function (data,text,jqxhr) {
            $tr=$(jqxhr.responseText);
            $('.table tbody').prepend($tr);
            $tr.hide().fadeIn();
        }).always(function () {
            $form.find('button').text('Ajouter').prepend("<span class='glyphicon glyphicon-floppy-saved'></span> ");
            $('#site').val('');
            $('#image').val('');

        })

    })
})