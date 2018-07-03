var screenSaver = {};
var imagenum = 0;

$(document).ready(function () {
    startScreenSaver({
        timeout:60000,
        width: 120,
        height: 70,
        //exitTimeout: 1000,
    }); 
});

function startScreenSaver(options) {

  //* attach event listeners to exit screensaver
  attachScreenSaverEventListeners();

  if(!screenSaver.initiated) {

    //* set screensaver options
    screenSaver.options = {

       timeout: options.timeout || 60000, //* default timer to start screensaver is 10 minutes

        width: options.width || 25,   //* default width is 25rem

        height: options.height || 25, //* default height is 25rem

        exitTimeout: options.exitTimeout || null, //* default timer to exit screensaver is disabled

    }

    //* create elements
    var overlay = document.createElement("div");

    overlay.setAttribute('class', 'screensaver-overlay');

    document.body.appendChild(overlay);

    var createBadge = document.createElement("div");

    createBadge.setAttribute('id', 'saver-badge');

    document.body.appendChild(createBadge);

    createBadge.style.width = screenSaver.options.width + 'rem';

    createBadge.style.height = screenSaver.options.height + 'rem';

  }

  document.getElementsByTagName("body")[0].classList.remove('screensaver');

  screenSaver.initiated = true;

  screenSaver.setTimeoutValue = screenSaver.options.timeout; 

  screenSaver.setTimeoutExit = screenSaver.options.timeoutExit; 

  screenSaver.setTimeout = null; //* clear timeout

  screenSaver.inProgress = false;

  screenSaver.timerStarted = false;

  clearTimeout(screenSaver.setTimeout);

  screenSaver.setTimeout = setTimeout(function() {
    
    document.getElementsByTagName("body")[0].classList.add('screensaver');

      screenSaver.inProgress = true;

      var saverBadge = document.getElementById("saver-badge");

      clearInterval(screenSaver.setInterval); //* clear badge display interval

      screenSaver.setInterval = null;

      //* get dimensions in em
      var windowHeight = window.outerHeight / parseFloat(window.getComputedStyle(document.getElementsByTagName("body")[0], null).getPropertyValue('font-size'));
      
      var windowWidth = window.outerWidth / parseFloat(window.getComputedStyle(document.getElementsByTagName("body")[0], null).getPropertyValue('font-size'));
      
      screenSaver.setInterval = setInterval(function() {
          
        if (screenSaver.inProgress === true) {

          saverBadge.classList.remove('visible');
          
          setTimeout(function() {
            //Load background based on random number 1-10.
            //alert(window.outerHeight);
            //alert(window.outerWidth);
            if ((imagenum + 1) > 10){
                imagenum = 1;
            }
            else{
                imagenum = imagenum + 1;
            }
            var randnumber = 0; // Math.floor((Math.random() * 10) + 1);
            saverBadge.style.backgroundImage = "url("+base_url+"assets/images/screensave/page"+imagenum+".gif?id="+randnumber+")";
            saverBadge.style.backgroundRepeat = "no-repeat";
            saverBadge.style.backgroundAttachment = "fixed";
            saverBadge.style.backgroundPosition = "center center";
            saverBadge.style.backgroundSize = "100% auto";
            saverBadge.style.overflowX = "hidden";
            saverBadge.offsetWidth = saverBadge.offsetWidth;

            saverBadge.classList.add('visible');

          },1);

          var saverTopValue = Math.floor(Math.random() * windowHeight) - screenSaver.options.width;

          var saverLeftValue = Math.floor(Math.random() * windowWidth) - screenSaver.options.height;

          if (saverTopValue <= 0) { //* make sure the badge doesn't go off the screen

            saverTopValue = saverTopValue + 15;

          }

          if (saverLeftValue <= 0) {

            saverLeftValue = saverLeftValue + 15;

          }
//          Set Top and Left position to upper left side.
          saverTopValue = 0;
          saverLeftValue = 0;
          saverBadge.style.top = saverTopValue + 'rem';

          saverBadge.style.left = saverLeftValue + 'rem';

          if(screenSaver.timerStarted === false && screenSaver.options.exitTimeout != null) {

            startScreenSaverTimer();

          }
        }
      }, 6000);

    }, screenSaver.setTimeoutValue);
}

function startScreenSaverTimer() {

  screenSaver.timerStarted = true;

  setTimeout(function() {

    stopScreenSaver();

  }, screenSaver.setTimeoutExit);

}

function stopScreenSaver() {

  startScreenSaver();

  clearInterval(screenSaver.setInterval);

  document.getElementsByTagName("body")[0].classList.remove('screensaver');

  screenSaver.timerStarted = false;

}

function attachScreenSaverEventListeners() {

  var events = ['touchstart', 'mousedown', 'mousemove', 'touchmove', 'keypress', 'scroll'];

  var resetScreenSaver = function(e) {

    if (screenSaver.inProgress) {

      e.stopPropagation();

      e.preventDefault();

    }

    clearTimeout(screenSaver.setTimeout);

    clearInterval(screenSaver.setInterval);

    document.getElementsByTagName("body")[0].classList.remove('screensaver');

    startScreenSaver();

  }

  var checkClick = function(e) {

    if (screenSaver.inProgress) {

      startScreenSaver();

    }

  }

  var bindEvents = function(eventName) {

    document.addEventListener(eventName, screenSaver.initialize);

    //* bind click as fallback for touchstart and mousedown
    document.addEventListener('click', checkClick);

  }

  var unbindEvents = function(eventName) {

    document.removeEventListener(eventName, screenSaver.initialize);

  }

  for (var i=0;i<events.length;i++) {

    bindEvents(events[i]);

  }

}