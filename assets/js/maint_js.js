/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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

function refreshcodefolderlist(){ 
    var mymodal = $('#loadCodeList');
    var url = base_url+'reloadcodelist';
    mymodal.find('.modal-body').load(url);
    mymodal.modal('show');
    
//    $('.modal-body').load(base_url+'reloadlist',function(){
//        $('#loadDBFile').modal({show:true});
//    });
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

function redirect2importDB(url) {
    var thedbfile = document.getElementsByName("dbfile");
    var thekey = '';
    var thevalue = '';
    var thepair = {};
    for( i = 0; i < thedbfile.length; i++ ) {
        if( thedbfile[i].checked ) {
            document.getElementById("theloadertext").style.display = "";
            document.getElementById("theloadertext").innerHTML = "Loading Database. Please wait...<br><br>";
            document.getElementById("theloaddbbuttons").style.display = "none";
            document.getElementById("theloader").style.display = "";
            
            thekey = thedbfile[i].name;
            thevalue = thedbfile[i].value;
            thepair = {};
            thepair[thekey] = thevalue;
            
            $.ajax({
            type: "POST",
            url: url,
            data: thepair,
            success:function(response){
                redirectOnClick(base_url+'maint/displayexport'+'?exportresult='+encodeURI(response));
            }
            });
            
//            $.post(url, thepair, function(data){
//                // show the response
//                $('#response').html(data);
//                document.getElementById("theloaddbbuttons").style.display = "";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloadertext").style.display = "none";
//                location.reload(url);
//                
//            }).fail(function() {
//                // just in case posting your form failed
//                document.getElementById("theloaddbbuttons").style.display = "";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloadertext").style.display = "none";
//            });
            $('#loadDBFile').modal('hide');
            return false; 
        }
    }
    alert('You must select a file.');  
}

function redirect2stagecode(url) {
    var thecodefile = document.getElementsByName("codefile");
    var thekey = '';
    var thevalue = '';
    var thepair = {};
    for( i = 0; i < thecodefile.length; i++ ) {
        if( thecodefile[i].checked ) {
            document.getElementById("theloadertext").style.display = "";
            document.getElementById("theloadertext").innerHTML = "Loading Code. Please wait...<br><br>";
            document.getElementById("theloaddbbuttons").style.display = "none";
            document.getElementById("theloader").style.display = "";
            
            thekey = thecodefile[i].name;
            thevalue = thecodefile[i].value;
            thepair = {};
            thepair[thekey] = thevalue;
            
            $.ajax({
            type: "POST",
            url: url,
            data: thepair,
            success:function(response){
                redirectOnClick(base_url+'maint/displayexport'+'?exportresult='+encodeURI(response));
            }
            });
            
//            $.post(url, thepair, function(data){
//                // show the response
//                $('#response').html(data);
//                document.getElementById("theloaddbbuttons").style.display = "";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloadertext").style.display = "none";
//                location.reload(url);
//                alert(data);
//            }).fail(function() {
//                // just in case posting your form failed
//                document.getElementById("theloaddbbuttons").style.display = "";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloadertext").style.display = "none";
//            });
            $('#loadCodeFile').modal('hide');
            return false; 
        }
    }
    alert('You must select a file.');  
}

function redirect2loadcode(url) {
    var thecodefile = document.getElementsByName("codefolder");
    var thekey = '';
    var thevalue = '';
    var thepair = {};
    for( i = 0; i < thecodefile.length; i++ ) {
        if( thecodefile[i].checked ) {
            document.getElementById("theloadertext").style.display = "";
            document.getElementById("theloadertext").innerHTML = "Loading Code. Please wait...<br><br>";
            document.getElementById("theloaddbbuttons").style.display = "none";
            document.getElementById("theloader").style.display = "";
            
            thekey = thecodefile[i].name;
            thevalue = thecodefile[i].value;
            thepair = {};
            thepair[thekey] = thevalue;

            $.ajax({
            type: "POST",
            url: url,
            data: thepair,
            success:function(response){
                redirectOnClick(base_url+'maint/displayexport'+'?exportresult='+encodeURI(response));
            }
            });
            
//            $.post(url, thepair, function(data){
//                // show the response
//                $('#response').html(data);
//                document.getElementById("theloaddbbuttons").style.display = "";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloadertext").style.display = "none";
//                location.reload(url);
//                alert(data);
//            }).fail(function() {
//                // just in case posting your form failed
//                document.getElementById("theloaddbbuttons").style.display = "";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloader").style.display = "none";
//                document.getElementById("theloadertext").style.display = "none";
//            });
            $('#loadCodeList').modal('hide');
            return false; 
        }
    }
    alert('You must select a file.');  
}

function redirect2exportData(url) {
    document.getElementById("theloadertext").style.display = "";
    document.getElementById("theloadertext").innerHTML = "Exporting Data. Please wait...<br><br>";
    document.getElementById("theloaddbbuttons").style.display = "none";
    document.getElementById("theloader").style.display = "";
    $('#myModal').modal('hide');
            
    var datafromajax="";
    $.ajax({
            type: "POST",
            url: url,
            data: {},
            success:function(response){
                redirectOnClick(base_url+'maint/displayexport'+'?exportresult='+encodeURI(response));
            }
            });
            
//    $.post(url, "", function(data){
//        // show the response
//        $('#response').html(data);
//        datafromajax = data; 
//            
//        //document.getElementById("beginintro").style.display = "";
//        //document.getElementById("beginloader").style.display = "none";
//        redirectOnClick(url2+'?exportresult='+encodeURI(datafromajax));
//            
//    }).fail(function() {
//        // just in case posting your form failed
//        document.getElementById("theloaddbbuttons").style.display = "";
//        document.getElementById("theloader").style.display = "none";
//    });
    return true; 
}

function rebootsystem(){
    if(confirm('Are you sure?', 'Reboot the system.')==true){
        document.getElementById("theloadertext").style.display = "";
        document.getElementById("theloadertext").innerHTML = "Rebooting System. Please wait...<br><br>";
        document.getElementById("theloaddbbuttons").style.display = "none";
        document.getElementById("theloader").style.display = "";
        $.ajax({
            type: "GET",
            url: base_url+"maint/rebootsystem",
            data: {},
            success:function(response){
                //your code goes here
                if(response=='false'){
                    document.getElementById("theloaddbbuttons").style.display = "";
                    document.getElementById("theloader").style.display = "none";
                    alert('Cannot reboot the system...');
                    window.location.reload();                   
                }
            }
        });
    }
}

