/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function redirectOnClick(url) {
    $(location).attr('href',url);
}

function registerCellNumber(url){
    thekey = 'cellnumber';
    thevalue = document.getElementById("text-basic").value;
    thepair = {};
    thepair[thekey] = thevalue;
    $.post(url, thepair, function(data){
        // show the response
        $('#response').html(data);
        redirectOnClick(base_url+'thanks');
    }).fail(function() {
        // just in case posting your form failed
        
    });
}

function redirectOnBeginClick(url) {
    document.getElementById('popsoundbegin').play();
    document.getElementById('popsoundbegin').onended = function () {
        redirectOnClick(url);
    }
}

function wait(ms){
    var start = new Date().getTime();
    var end = start;
    while(end < start + ms) {
        end = new Date().getTime();
    }
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
    if(h<10){
            h = "0"+h;
    }
    m = date.getMinutes();
    if(m<10){
            m = "0"+m;
    }
    s = date.getSeconds();
    if(s<10){
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
    
    $.ajax({
            type: "GET",
            url: base_url+"survey/getfooterhidden",
            data: {},
            success:function(response){
                //your code goes here
                if (response == "false"){
                   displayval = document.getElementById("thefooter").style.display = "";
                   footerhidden = false;
                }
                else{
                    displayval = document.getElementById("thefooter").style.display = "none";
                    footerhidden = true;
                }
            }
        })
};

(function ($) {
    var footerhidden = true;
    
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
                    var pathName = loc.pathname.substring(loc.pathname.lastIndexOf('/')+1);
                    if (pathName != 'loaddb'){
                        redirectOnClick(base_url+'thanks');
                    }
                }
                idleState = true; }, idleWait);
        });        
        $("body").trigger("mousemove");    
        
    });
    
    $('#sonnetimg').click(function(){
        var displayval = document.getElementById("thefooter").style.display;
        if (displayval == "none"){
           displayval = document.getElementById("thefooter").style.display = "";
           footerhidden = false;
        }
        else{
            displayval = document.getElementById("thefooter").style.display = "none";
            footerhidden = true;
        }
        $.ajax({
            type: "POST",
            url: base_url+"survey/setfooterhidden",
            data: { footerhidden: footerhidden },
            success:function(response){
                //your code goes here
            }
        })
    });
}) (jQuery)