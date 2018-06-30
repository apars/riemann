/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var clickself = 1;
var checkedcount = 0;
$('li').on('click', function(){
    $('li').removeClass('active');
    $('li').removeClass('secondary-active');
    $(this).addClass('active');
    $(this).prevAll().addClass('secondary-active');
    
    
    if(clickself===1)
    {
        document.getElementById('popsound').onended = function () {
            $('#carouselExampleIndicators').carousel('next');
        }
      //var l = document.getElementById('carnextid');
      //l.click();
    }
    
    clickself=1;
});

$('input').on('click', function(){
    //Accept only radio input types.
    if (this.type != 'checkbox' && (this.name != 'dbfile') && (this.id != 'password') && (this.id != 'text-basic'))
    {
        var loc = window.location;
        var pathName = loc.pathname.substring(loc.pathname.lastIndexOf('/')+1);
        var thekey = this.name;
        var thevalue = this.value;
        var thepair = {};
        var isfailed=0;
        
        thepair[thekey] = thevalue;
        checkedcount += 1;
        document.getElementById('popsound').play();

        $.post('../aquestion/' + pathName, thepair, function(data){
            // show the response
            $('#response').html(data);    
        }).fail(function() {
            isfailed=1;
            // just in case posting your form failed
            //alert( "Posting failed." );     
        });
        
        updateSurveyCount();
        var radioscount =  document.getElementsByName('carindicate').length;
        
        if ((isfailed===0) && ((checkedcount)!= 0)){
            document.getElementById('popsound').onended = function () {
                $('#carouselExampleIndicators').carousel('next');
            }
        }
        return false;
    }
    else{
        return true;
    }   
})

function submitCheckbox(thecheckbox)
{
    var chkboxes = document.getElementsByName(thecheckbox);
    var loc = window.location;
    var pathName = loc.pathname.substring(loc.pathname.lastIndexOf('/')+1);
    
    checkedcount += 1;
    //alert(chkboxes.length);
    for( i = 0; i < chkboxes.length; i++ ) {
        if( chkboxes[i].checked ) {
            var thekey = thecheckbox;
            var thevalue = chkboxes[i].value;
            var thepair = {};
            thepair[thekey] = thevalue;
    
            //alert(thekey);
            //alert(thevalue);
            $.post('../aquestion/' + pathName, thepair, function(data){            
                // show the response
                $('#response').html(data);   
            }).fail(function() {         
                // just in case posting your form failed
                //alert( "Posting failed." );             
            });
        }
    }
    updateSurveyCount();
}

function updateSurveyCount()
{
    var radioscount =  document.getElementsByName('carindicate').length;
    var surveycount = "";
      
    if(document.getElementById("answeredsurvey")!=null)
    {
        document.getElementById("answeredsurvey").innerHTML = surveycount.concat(" [",String(checkedcount),"/",String(radioscount),"]");
    }
    if(radioscount===checkedcount)
    {
        //Submit after all questions are answered.
        //if(document.getElementById('mainsurveyform') != null)document.getElementById('mainsurveyform').submit(); return false;
        checkedcount = 0;
        //$(location).attr('href','../thanks/');
        //paparece 06/25/2018 - Removed audio play end checking to reduce delay on final answer.
        document.getElementById('popsound').onended = function () {
            redirectOnClick(base_url+'reward');
        }
    }
}

$('a[data-slide="prev"]').click(function() {
    $('#myCarousel').carousel('prev');
});

$('a[data-slide="next"]').click(function() {
    $('#myCarousel').carousel('next');
});

$(document).ready(function(){
    $("#carouselExampleIndicators").on('slid.bs.carousel', function () {
        currentIndex = $('div.active').index()+1;
        //$('.num').html(''+currentIndex+'/'+totalItems+'');
        //alert(String(currentIndex));
        if (currentIndex != 'null'){
            var classNamePrefix = 'ratings';
            
            updateSurveyCount();
            checkedValue = getCheckedValue(classNamePrefix.concat(String(currentIndex)));
            if (checkedValue != null){
                var idPrefix = 'rating_';
                var idRadioButton = idPrefix.concat(String(checkedValue));
                var l = document.getElementById(idRadioButton);
                
                clickself = '0';
                l.click();
            }
        }
    });
});

function getCheckedCount( numslides ) {
    var classNamePrefix = 'ratings';
    var checkedcnt = 0;
    
    for (currSlide = 1; currSlide <= numslides; currSlide++){
        var radios = document.getElementsByName( classNamePrefix.concat(String(currSlide)) );
    
        for( i = 0; i < radios.length; i++ ) {
            if( radios[i].checked ) {
                checkedcnt += 1;
            }
        }
    }
    return checkedcnt;
};

function getCheckedValue( groupName ) {
    var radios = document.getElementsByName( groupName );
    
    for( i = 0; i < radios.length; i++ ) {
        if( radios[i].checked ) {
            return radios[i].value;
        }
    }
    return null;
};  

//window.alert = function(message, title) {
//    if($("#bootstrap-alert-box-modal").length == 0) {
//        $("body").append('<div id="bootstrap-alert-box-modal" class="modal fade">\
//            <div class="modal-dialog">\
//                <div class="modal-content">\
//                    <div class="modal-header" style="min-height:40px;">\
//                        <h4 class="modal-title"></h4>\
//                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
//                    </div>\
//                    <div class="modal-body"><p></p></div>\
//                    <div class="modal-footer">\
//                        <a href="#" data-dismiss="modal" class="btn btn-default">Close</a>\
//                    </div>\
//                </div>\
//            </div>\
//        </div>');
//    }
//    $("#bootstrap-alert-box-modal .modal-header h4").text(title || "");
//    $("#bootstrap-alert-box-modal .modal-body p").text(message || "");
//    $("#bootstrap-alert-box-modal").modal('show');
//};
//window.confirm = function(message, title, yes_label, callback) {
//    $("#bootstrap-confirm-box-modal").data('confirm-yes', false);
//    if($("#bootstrap-confirm-box-modal").length == 0) {
//        $("body").append('<div id="bootstrap-confirm-box-modal" class="modal fade">\
//            <div class="modal-dialog">\
//                <div class="modal-content">\
//                    <div class="modal-header" style="min-height:40px;">\
//                        <h4 class="modal-title"></h4>\
//                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
//                    </div>\
//                    <div class="modal-body"><p></p></div>\
//                    <div class="modal-footer">\
//                        <a href="#" data-dismiss="modal" class="btn btn-default">Cancel</a>\
//                        <a href="#" class="btn btn-primary">' + (yes_label || 'OK') + '</a>\
//                    </div>\
//                </div>\
//            </div>\
//        </div>');
//        $("#bootstrap-confirm-box-modal .modal-footer .btn-primary").on('click', function () {
//            $("#bootstrap-confirm-box-modal").data('confirm-yes', true);
//            $("#bootstrap-confirm-box-modal").modal('hide');
//            return false;
//        });
//        $("#bootstrap-confirm-box-modal").on('hide.bs.modal', function () {
//            if(callback) callback($("#bootstrap-confirm-box-modal").data('confirm-yes'));
//        });
//    }
// 
//    $("#bootstrap-confirm-box-modal .modal-header h4").text(title || "");
//    $("#bootstrap-confirm-box-modal .modal-body p").text(message || "");
//    $("#bootstrap-confirm-box-modal").modal('show');
//};