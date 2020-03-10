$(document).ready(function() {

    $.fn.editable.defaults.mode = 'inline';     
    
    //make firstname editable
    $('#firstname').editable({
        type: "text",              
        title: "firstName",            
        disabled: false,           
        emptytext: "empty",          
        mode: "inline",              
        validate: function (value) { 
            if (!$.trim(value)) {
                return 'cannot be empty';
            }
        }
    });
    var form = $("#signup-form");
    $(".acc-wizard").accwizard({
        labels: {
            finish : 'Submit',
            current : ''
        }
        
    });

    // $('.panel-group .panel-default').on('click', function() {
    //     $('.panel-group').find('.active').removeClass("active");
    //     $(this).addClass("active");
    // });
    $('.panel').on('show.bs.collapse', function (e) {
        $(this).addClass('active');
    })
    $('.panel').on('hide.bs.collapse', function (e) {
        $(this).removeClass('active');
    })

    //make surname editable
    $('#surname').editable({
        type: "text",               
        title: "Surname",            
        disabled: false,            
        emptytext: "empty",          
        mode: "inline",              
        validate: function (value) { 
            if (!$.trim(value)) {
                return 'cannot be empty';
            }
        }
    });     

    //edit email address
    $('#email').editable({
        url: '/post',
        title: 'Enter email',          
        mode: "inline",
        type:"email",
        validate: function (value) { 
            if (!$.trim(value)) {
                return 'cannot be empty';
            }
        }
    });  

    //edit phone number
    //make surname editable
    $('#phone').editable({
        type: "number",               
        title: "Edit Phone number",            
        disabled: false,            
        emptytext: "empty",          
        mode: "inline",              
        validate: function (value) { 
            if (!$.trim(value)) {
                return 'cannot be empty';
            }
        }
    }); 

    $('#dob').editable({
        type: "combodate",
        title: "select dob",
        disabled: false,
        mode: "inline",
        format: 'YYYY-MM-DD',    
        viewformat: 'DD.MM.YYYY',    
        template: 'D / MMMM / YYYY',    
        combodate: {
                minYear: 1900,
                maxYear: 2020,
                minuteStep: 1
        }
    }); 

    $('#occupation').editable({ 
        source: [
              {value: 1, text: 'Contracts Manager'},
              {value: 2, text: 'Project Manager'},
              {value: 3, text: 'Architect'},
              {value: 4, text: 'Structural Engineer'},
              {value: 5, text: 'Mechanical Engineer'},
              {value: 6, text: 'Civil Engineer / Site Engineer'},
              {value: 7, text: 'General Foreman'},
              {value: 8, text: 'Specialist Foreman'},
              {value: 9, text: 'General Operative'},
              {value: 10, text: 'Plumber'},
              {value: 11, text: 'Electrician'},
              {value: 12, text: 'Scaffolder'},
              {value: 13, text: 'Plasterer'},
              {value: 14, text: 'Block / Bricklayer'},
              {value: 15, text: 'Painter'},
              {value: 16, text: 'Lift Installer'},
              {value: 17, text: 'Fireprooding'},
              {text: 'Machine Operator', 
                children: [
                    { value: 18, text:'Excavator Driver'},
                    { value: 19, text:'Telehandler Driver'},
                    { value: 20, text:'Crane Operator'},
                    { value: 21, text:'Specialist Foreman'} 
               ]},
              {value: 22, text: 'Other'}

           ]
    });

    $('#position').editable({
        source: [
              {value: 1, text: 'General'},
              {value: 2, text: 'Manager'},
              {value: 3, text: 'Foreman'},
              {value: 4, text: 'Other'}
            ]
    });


     //local source
     $('#country').editable({
        source: [
              {value: 1, id: 'ir', text: 'Ireland'},
              {value: 2, id: 'gb', text: 'United Kindom'},
              {value: 3, id: 'us', text: 'United States'},
              {value: 4, id: 'ru', text: 'Poland'}

           ]
    });


});

