/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function redirectOnClick(url) {
    $(location).attr('href',url);
}

function refreshfilelist(){ 
    var mymodal = $('#loadDBFile');
    var url = base_url+'reloadlist';
    mymodal.find('.modal-body').load(url);
    mymodal.modal('show');
    
//    $('.modal-body').load(base_url+'reloadlist',function(){
//        $('#loadDBFile').modal({show:true});
//    });
}

function refreshzipfilelist(){ 
    var mymodal = $('#loadCodeFile');
    var url = base_url+'reloadziplist';
    mymodal.find('.modal-body').load(url);
    mymodal.modal('show');
    
//    $('.modal-body').load(base_url+'reloadlist',function(){
//        $('#loadDBFile').modal({show:true});
//    });
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

function checkPinCode(url){
    var pincode = document.getElementById("password").value;
    //alert(pincode);
    if (pincode == '1128147'){
        redirectOnClick(url);
    }
    else{
        document.getElementById("password").value = '';
    }
}

function redirectOnBeginClick(url) {
    document.getElementById('popsoundbegin').play();
    document.getElementById('popsoundbegin').onended = function () {
        redirectOnClick(url);
    }
}

function redirect2importDB(url) {
    var thedbfile = document.getElementsByName("dbfile");
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
                location.reload(url);
            }).fail(function() {
                // just in case posting your form failed
                document.getElementById("theloaddbbuttons").style.display = "";
                document.getElementById("theloader").style.display = "none";
            });
            $('#loadDBFile').modal('hide');
            return false; 
        }
    }
    alert('You must select a file.');  
}

function redirect2loadcode(url) {
    var thedbfile = document.getElementsByName("dbfile");
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
                location.reload(url);
            }).fail(function() {
                // just in case posting your form failed
                document.getElementById("theloaddbbuttons").style.display = "";
                document.getElementById("theloader").style.display = "none";
            });
            $('#loadCodeFile').modal('hide');
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
    document.getElementById("theloaddbbuttons").style.display = "none";
    document.getElementById("theloader").style.display = "";
    $('#myModal').modal('hide');
            
    var datafromajax="";
        
    $.post(url, "", function(data){
        // show the response
        $('#response').html(data);
        datafromajax = data; 
            
        //document.getElementById("beginintro").style.display = "";
        //document.getElementById("beginloader").style.display = "none";
        redirectOnClick(url2+'?exportresult='+encodeURI(datafromajax));
            
    }).fail(function() {
        // just in case posting your form failed
        document.getElementById("theloaddbbuttons").style.display = "";
        document.getElementById("theloader").style.display = "none";
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
            type: "POST",
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
                    redirectOnClick(base_url+'thanks');
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