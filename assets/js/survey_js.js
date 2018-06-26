/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function myFunction() {
    //document.getElementById("demo").style.color = "red";
    $(location).attr('href',"http://localhost/surveynow2/");
}

function redirectOnClick(url) {
    //document.getElementById("demo").style.color = "red";
    $(location).attr('href',url);
}

function redirectOnBeginClick(url) {
    //document.getElementById("demo").style.color = "red";
    document.getElementById('popsoundbegin').play();
    document.getElementById('popsoundbegin').onended = function () {
    $(location).attr('href',url);
    }
}

function redirect2importDB(url) {
    
    thedbfile = document.getElementsByName("dbfile");
    
    var thekey = '';
    var thevalue = '';
    var thepair = {};
    for( i = 0; i < thedbfile.length; i++ ) {
        
        if( thedbfile[i].checked ) {
            document.getElementById("theloaddbbuttons").style.display = "none";
            document.getElementById("theloader").style.display = "";
            
            thekey = thedbfile[i].name;
            thevalue = thedbfile[i].value;
            thepair = {};
            thepair[thekey] = thevalue;
            
            $.post(url, thepair, function(data){
             
                // show the response
                $('#response').html(data);
                document.getElementById("theloaddbbuttons").style.display = "";
                document.getElementById("theloader").style.display = "none";
             
            }).fail(function() {
         
                // just in case posting your form failed
                //alert( "Posting failed." );
                document.getElementById("theloaddbbuttons").style.display = "";
                document.getElementById("theloader").style.display = "none";
            });
            $('#loadDBFile').modal('hide');
            return false; 
        }
    }
    alert('You must select a file.');  
}

function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}

function redirect2exportData(url, url2) {
        document.getElementById("beginintro").style.display = "none";
        document.getElementById("beginloader").style.display = "";
        $('#myModal').modal('hide');
            
        var datafromajax="";
        
        $.post(url, "", function(data){
            // show the response
            $('#response').html(data);
            datafromajax = data; 
            
            //document.getElementById("beginintro").style.display = "";
            //document.getElementById("beginloader").style.display = "none";
            redirectOnClick(url2+'/'+datafromajax);
            
        }).fail(function() {
            // just in case posting your form failed
            //alert( "Posting failed." );
            document.getElementById("beginintro").style.display = "";
            document.getElementById("beginloader").style.display = "none";
        });
        return true; 
}

function date_time(id)
{
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
        d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        result = ''+days[day]+' '+months[month]+' '+d+', '+year+' '+h+':'+m+':'+s;
        document.getElementById(id).innerHTML = result;
        setTimeout('date_time("'+id+'");','1000');
        return true;
}

idleTimer = null;
idleState = false;
idleWait = 30000;

window.onload = function() {
    date_time('date_time');
};

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
                //if(document.getElementById('mainsurveyform') != null)document.getElementById('mainsurveyform').submit(); return false;
                var loc = window.location;
                var pathName = loc.pathname.substring(loc.pathname.lastIndexOf('/')+1);
                if (pathName!=base_url.substring(base_url.lastIndexOf('/')+1))
                {
                    redirectOnClick(base_url+'/thanks');
                }

                idleState = true; }, idleWait);
        });
        
        $("body").trigger("mousemove");
    
    });
}) (jQuery)