
(function ($) {
    "use strict";


    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })
  
  
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

    function passValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('');
    }
    
    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).addClass('active');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).removeClass('active');
            showPass = 0;
        }
        
    });

    $("#example-async").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        titleTemplate : '<div class="title"><span class="title-text">#title#</span><span class="title-number">0#index#</span></div>',
        labels: {
            previous : 'Previous',
            next : 'Next',
            finish : 'Submit',
            current : ''
        },
        onFinished: function (event, currentIndex)
        {
            alert("Add Certication successfully!");
            var x = document.getElementById("successicon");
            var y = document.getElementById('addicon');

            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                 x.style.display = "none";
                 y.style.display = "block";
                }
            }
    });

    $("#example-async2").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        titleTemplate : '<div class="title"><span class="title-text">#title#</span><span class="title-number">0#index#</span></div>',
        labels: {
            previous : 'Previous',
            next : 'Next',
            finish : 'Submit',
            current : ''
        },
        onFinished: function (event, currentIndex)
        {
            alert("Add Certication successfully!");
        }
    });


})(jQuery);

