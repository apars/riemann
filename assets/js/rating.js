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

