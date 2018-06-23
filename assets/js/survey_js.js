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

window.onload = function() {
    date_time('date_time');
};