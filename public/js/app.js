/**
 * Created by hp on 21/05/2017.
 */
$(document).ready(function (e) {
    $('.footer-links-holder h3').click(function () {
        $(this).parent().toggleClass('active');
    });
    var modal = document.getElementById('myModal');

// Get the button that opens the modal
    var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    $('#option').change(function(e) {
        e.preventDefault()
        var site = $(this).val()
        var local=$('#local')
        var url=$(location).attr('href')
        if (site != '') {
            if(site=='TAC' || site=='TP'){
                $('#autre').addClass('hide')
                $('#local').prop("disabled",true)
                $('#localisation').removeClass('hide')
            }
            if(site=='TFZ' || site=='TOS') {
                $('#autre').addClass('hide')
                $('#localisation').addClass('hide')
                $('#local').empty()
                $('#local').prop("disabled",false)
                $url=$(location).attr('href').replace("intervention/interventionRegister","lib/recupe.php")
                $.post($url, {option: site}, function (data, success) {
                    local.html(data)
                    console.log(data)
                });
            }
            if(site=='Autres'){
                $('#autre').removeClass('hide')
                $('#localisation').removeClass('hide')
            }
        }
    });
    var r=1;
    var $a;
    $('.table').on('click','.btn-danger',function(e) {

        e.preventDefault()
        e.stopPropagation();
        $a=$(this);
        var url=$a.attr('href');
        modal.style.display = "block";
        $('.ok').click(function (e) {
            e.preventDefault()
            $a.text('..chargement..');
            console.log(url)
                $.ajax(url).done(function (data, text, jqxhr) {
                    // if(r==1) {
                    $a.parents('tr').fadeOut();
                    // r=0
                    // }
                }).fail(function (jqxhr) {
                    alert(jqxhr.responseText());
                })
                modal.style.display = "none";
        });
        $('.ko').click(function () {
            modal.style.display = "none";
            url=null
        })


    });

    //verification des erreur
    $ch=$(location).attr('href').replace("admin/g_site","lib/recupe.php");
    $('.nsite').on('input',function (e) {
        var site=$(this).val();
        $.post($ch, {nsite: site}, function (data, success) {
            if(data){
                $('#message').removeClass('hide').addClass("btn btn-danger").text("  ce site existe deja !").addClass("glyphicon glyphicon-exclamation-sign");
                $('#nsite').attr("disabled","disabled");
            }
            else{
                $('#message').addClass('hide');
                $('#nsite').prop("disabled",false);
            }
        });
    })

// When the user clicks on <span> (x), close the modal
//     span.onclick = function() {
//         modal.style.display = "none";
//     }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    // modifier un site
   $(".table").on('click','#updat_i',function (e) {
       e.preventDefault()
       var $url=$(this).attr('alt');
       var $action=$(this).attr('href');
       $("#update").removeClass("cacher");
       $("#update").hide().fadeIn();
       $("#img_updat").attr("src",$url);
       var $site=$(this).parent('td').prev().prev().text();
       $('#upsite').val($site);
       $('#updat_img').attr('action',$action);

   })
    

})
