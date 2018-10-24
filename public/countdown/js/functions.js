$(document).ready(function() {

  	if ( top !== self ) { // we are in the iframe
  		$("header").remove();
  		$('body').css('background', 'transparent');
  	} else { // not an iframe
  		console.log('I\'m not in an iframe')
  	}

  });
