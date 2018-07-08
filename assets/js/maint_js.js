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

function refreshvolume(){ 
    var mymodal = $('#adjustVolume');
    var url = base_url+'reloadvolume';
    document.getElementById("adjustVolume").style.display = "";
    
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        success:function(response){
            document.getElementById("volid").value = response;
            document.getElementById("voltxtid").innerHTML = response;
            //mymodal.find('.modal-body').load(url);
            mymodal.modal('show');
        }
    });
    
    
//    $('.modal-body').load(base_url+'reloadlist',function(){
//        $('#loadDBFile').modal({show:true});
//    });
}

function inputPinCode()
{
    document.getElementById("password").click();
}

$("input").change(function(){
    if (this.type === 'password'){
        checkPinCode(base_url+'maint/loaddb');
    }
});


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
                    //respdata = response.split("*");
                    //url = base_url+'assets/downloads/download.php?srcfile='+respdata[0]+'&dstpath='+respdata[1]+respdata[0].substring(respdata[0].lastIndexOf('/')+1);
                    //downloadFile(respdata[0], respdata[0].substring(respdata[0].lastIndexOf('/')+1));
                    
                    
                    //document.getElementById("target").href = url;
                    //document.getElementById("target").click();
                    //$successmsg = response; //respdata[0]+' exported successfully to '+respdata[1]+'!';
                    redirectOnClick(base_url+'maint/displayexport'+'?exportresult='+encodeURI(response));
                    //alert(url);
//                    $.ajax({
//                            type: "GET",
//                            url: url,
//                            data: {},
//                            success:function(data){
//                                $successmsg = respdata[0]+' exported successfully to '+respdata[1]+'!';
//                                redirectOnClick(base_url+'maint/displayexport'+'?exportresult='+encodeURI($successmsg));
//                            }
//                    });
            }
            });
            
    return true; 
}

function downloadFile(srcFile, destFileName){
    var req = new XMLHttpRequest();
    req.open("GET", srcFile, true);
    req.responseType = "blob";

    req.onload = function (event) {
      var blob = req.response;
      var fileName = null;
      var contentType = req.getResponseHeader("content-type");

      // IE/EDGE seems not returning some response header
      if (req.getResponseHeader("content-disposition")) {
        var contentDisposition = req.getResponseHeader("content-disposition");
        fileName = contentDisposition.substring(contentDisposition.indexOf("=")+1);
      } else {
        fileName = destFileName; //+"." + contentType.substring(contentType.indexOf("/")+1);
      }

      if (window.navigator.msSaveOrOpenBlob) {
        // Internet Explorer
        window.navigator.msSaveOrOpenBlob(new Blob([blob], {type: contentType}), fileName);
      } else {
        var el = document.getElementById("target");
        el.href = window.URL.createObjectURL(blob);
        el.download = fileName;
        el.click();
      }
    };
    req.send();
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

function setvolume(vol) {
    var thekey = '';
    var thevalue = '';
    var thepair = {};
    
    thekey = "vol";
    thevalue = vol;
    thepair = {};
    thepair[thekey] = thevalue;

    if(document.getElementById("adjustVolume").style.display != "none"){
        $.ajax({
        type: "POST",
        url: base_url+'adjustsound',
        data: thepair,
        success:function(response){
            //alert(response);
            var aud = document.getElementById('popsoundonvol');
            //if(!aud.paused){
                aud.play();
            //}
        }
        });
    }
    return false; 
}

$(function() {
    var $document = $(document);
    var selector = '[data-rangeslider]';
    var $element = $(selector);
    // For ie8 support
    var textContent = ('textContent' in document) ? 'textContent' : 'innerText';
    // Example functionality to demonstrate a value feedback
    function valueOutput(element) {
        var value = element.value;
        var output = element.parentNode.getElementsByTagName('output')[0] || element.parentNode.parentNode.getElementsByTagName('output')[0];
        output[textContent] = value;
        setvolume(value);
    }
    $document.on('input', 'input[type="range"], ' + selector, function(e) {
        valueOutput(e.target);
    });
    // Example functionality to demonstrate disabled functionality
    $document .on('click', '#js-example-disabled button[data-behaviour="toggle"]', function(e) {
        var $inputRange = $(selector, e.target.parentNode);
        if ($inputRange[0].disabled) {
            $inputRange.prop("disabled", false);
        }
        else {
            $inputRange.prop("disabled", true);
        }
        $inputRange.rangeslider('update');
    });
    // Example functionality to demonstrate programmatic value changes
    $document.on('click', '#adjustVolume1', function(e) {
        //alert((e.target.parentNode)[0].value);

        var $inputRange = $(selector, e.target.parentNode);
        var value = $('input[type="number"]', e.target.parentNode)[0].value;
        $inputRange.val(value).change();
        element = e.target;
        var output = element.parentNode.getElementsByTagName('output')[0] || element.parentNode.parentNode.getElementsByTagName('output')[0];
        output[textContent] = value;
    });
    // Example functionality to demonstrate programmatic attribute changes
    $document.on('click', '#js-example-change-attributes button', function(e) {
        var $inputRange = $(selector, e.target.parentNode);
        var attributes = {
                min: $('input[name="min"]', e.target.parentNode)[0].value,
                max: $('input[name="max"]', e.target.parentNode)[0].value,
                step: $('input[name="step"]', e.target.parentNode)[0].value
            };
        $inputRange.attr(attributes);
        $inputRange.rangeslider('update', true);
    });
    // Example functionality to demonstrate destroy functionality
    $document
        .on('click', '#js-example-destroy button[data-behaviour="destroy"]', function(e) {
            $(selector, e.target.parentNode).rangeslider('destroy');
        })
        .on('click', '#js-example-destroy button[data-behaviour="initialize"]', function(e) {
            $(selector, e.target.parentNode).rangeslider({ polyfill: false });
        });
    // Example functionality to test initialisation on hidden elements
    $document
        .on('click', '#js-example-hidden button[data-behaviour="toggle"]', function(e) {
            var $container = $(e.target.previousElementSibling);
            $container.toggle();
        });
    // Basic rangeslider initialization
    $element.rangeslider({
        // Deactivate the feature detection
        polyfill: false,
        // Callback function
        onInit: function() {
            valueOutput(this.$element[0]);
        },
        // Callback function
        onSlide: function(position, value) {
            console.log('onSlide');
            console.log('position: ' + position, 'value: ' + value);

        },
        // Callback function
        onSlideEnd: function(position, value) {
            console.log('onSlideEnd');
            console.log('position: ' + position, 'value: ' + value);
        }
    });
});

