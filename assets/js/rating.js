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
      $('#carouselExampleIndicators').carousel('next');
      //var l = document.getElementById('carnextid');
      //l.click();
    }
    
    clickself=1;
});

$('input').on('click', function(){
    //alert(this.id);
    //alert(this.name);
    //alert(this.value);
    if (this.type != 'checkbox' && (this.name != 'dbfile'))
    {
    var loc = window.location;
    var pathName = loc.pathname.substring(loc.pathname.lastIndexOf('/')+1);
    //alert(pathName);
    
    var thekey = this.name;
    var thevalue = this.value;
    var thepair = {};
    thepair[thekey] = thevalue;
    checkedcount += 1;
    //postx('../aquestion/' + pathName, thepair);
    
    $.post('../aquestion/' + pathName, thepair, function(data){
            // show the response
            $('#response').html(data); 
            $('#carouselExampleIndicators').carousel('next');
        }).fail(function() {
            // just in case posting your form failed
            //alert( "Posting failed." );     
        });
        updateSurveyCount();
        return false;
    }
    else
    {
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
    //var checkedcount = getCheckedCount(radioscount);
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
        $(location).attr('href','../thanks/');
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
    if (currentIndex != 'null')
    {
      var classNamePrefix = 'ratings';
      updateSurveyCount();
      checkedValue = getCheckedValue(classNamePrefix.concat(String(currentIndex)));
      if (checkedValue != null)
      {
        var idPrefix = 'rating_';
        var idRadioButton = idPrefix.concat(String(checkedValue));
        //alert(idRadioButton);
        var l = document.getElementById(idRadioButton);
        clickself = '0';
        l.click();
        
        //alert(idRadioButton);
      }
    }
  });
});

function getCheckedCount( numslides ) {
    var classNamePrefix = 'ratings';
    var checkedcnt = 0;
    for (currSlide = 1; currSlide <= numslides; currSlide++)
    {
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

idleTimer = null;
idleState = false;
idleWait = 30000;

(function ($) {

    $(document).ready(function () {
    
        $('*').bind('mousemove keydown scroll', function () {
        
            clearTimeout(idleTimer);
                    
            if (idleState == true) { 
                
                // Reactivated event
                //$("body").append("<p>Welcome Back.</p>");            
            }
            
            idleState = false;
            
            idleTimer = setTimeout(function () { 
                
                // Idle Event
                //$("body").append("<p>You've been idle for " + idleWait/1000 + " seconds.</p>");
                if(document.getElementById('mainsurveyform') != null)document.getElementById('mainsurveyform').submit(); return false;
                //redirectOnClick(base_url)

                idleState = true; }, idleWait);
        });
        
        $("body").trigger("mousemove");
    
    });
}) (jQuery)