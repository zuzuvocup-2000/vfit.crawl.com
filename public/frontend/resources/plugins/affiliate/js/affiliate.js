/*$(document).ready(function(e){

   var search_url = 'https://gomarkets.eappform.com/initiate.aspx';

   var search_url2 = 'https://app.gomarkets.com/index.php';

   var url = '';

   var new_url = new_url2 = '';

   var Pcode   = readCookie('AFFILIATE_PCODE');

   var utm_medium = getCookie('utm_medium');

   var utm_source = getCookie('utm_source');

   var utm_campaign = getCookie('utm_campaign');

	 		

   

   if(Pcode != null) { 

     $("a").each(function(i,e) {

      url = $(e).attr('href');

      if(url==search_url) {

          new_url = search_url+"?Pcode="+Pcode;

          if(utm_medium!="" && utm_medium!=undefined){

	 		new_url = new_url+"&utm_medium="+utm_medium+"&utm_source="+utm_source+"&utm_campaign="+utm_campaign;

	 	  }

          $(e).attr('href',new_url);

      }



      if(url==search_url2) {

          new_url2 = search_url2+"?Pcode="+Pcode;

          if(utm_medium!="" && utm_medium!=undefined){

	 		new_url2 = new_url2+"&utm_medium="+utm_medium+"&utm_source="+utm_source+"&utm_campaign="+utm_campaign;

	 	  }

          $(e).attr('href',new_url2);

      }

   })  

   } 

   

   

   function readCookie(name) {

    var nameEQ = name + "=";

    var ca = document.cookie.split(';');

    for (var i = 0; i < ca.length; i++) {

        var c = ca[i];

        while (c.charAt(0) == ' ') c = c.substring(1, c.length);

        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);

    }

    return null;

}

});*/





/* UtM Code */

(function() {



		jQuery(document).ready(function($){



        console.log("11111");

	 	var exdays = 30;

	 	/* Setting Cookie */

	 	var utm_medium   = getUrlParameter('utm_medium');

	 	var utm_source   = getUrlParameter('utm_source');

	 	var utm_campaign = getUrlParameter('utm_campaign');

    var Pcode        = getUrlParameter('Pcode');
    var cxd          = getUrlParameter('cxd');
    var affid        = getUrlParameter('affid');

        

        if(Pcode!="" && Pcode!=undefined){

	 		setCookie("AFFILIATE_PCODE", Pcode, exdays); 

	 	} else {

	 		var Pcode = getCookie('AFFILIATE_PCODE'); 

	 	}

	 	/*cxd*/
	 	if(cxd!="" && cxd!=undefined){

	 		setCookie("AFFILIATE_CXD", cxd, exdays); 

	 	} else {

	 		var cxd = getCookie('AFFILIATE_CXD'); 

	 	}

	 	/*affid*/
	 	if(affid!="" && affid!=undefined){

	 		setCookie("AFFILIATE_AFFID", affid, exdays); 

	 	} else {

	 		var affid = getCookie('AFFILIATE_AFFID'); 

	 	}

	 	if(utm_medium!="" && utm_medium!=undefined){

	 		setCookie("utm_medium", utm_medium, exdays);

	 		setCookie('utm_source', utm_source, exdays);

	 		setCookie('utm_campaign', utm_campaign, exdays);

	 	} else {

	 		var utm_medium = getCookie('utm_medium');

	 		var utm_source = getCookie('utm_source');

	 		var utm_campaign = getCookie('utm_campaign');

	 	}



	 	if(utm_medium=="" && Pcode=="" && affid==""){

	 		return false;

	 	}



	 	var utmInheritingDomains = [

	     "gomarkets.com",

	   ],





	 utmRegExp = /(\&|\?)utm_[A-Za-z]+=[A-Za-z0-9]+/gi,

	 links = $(".utm-forward-link"),

	 utms = [

	   "Pcode="+Pcode, // IN GTM, CREATE A URL VARIABLE utm_medium  
	   "affid="+affid,
	   "cxd="+cxd,
	   "utm_medium="+utm_medium, // IN GTM, CREATE A URL VARIABLE utm_medium

	   "utm_source="+utm_source, // IN GTM, CREATE A URL VARIABLE utm_source

	   "utm_campaign="+utm_campaign, // IN GTM, CREATE A URL VARIABLE utm_campaign

	 ];



	 for (var index2 = 0; index2 < links.length; index2 += 1) {

	 for (var index = 0; index < links.length; index += 1) {

	 var tempLink = links[index].href,

	 tempParts; 

	 if (tempLink.indexOf(utmInheritingDomains[index2]) > 0) { // The script is looking for all links with the utmInheritingDomain

	 tempLink = tempLink.replace(utmRegExp, "");

	 tempParts = tempLink.split("#");

	 if (tempParts[0].indexOf("?") < 0 ) {

	 tempParts[0] += "?" + utms.join("&"); // The script adds UTM parameters to all links with the domain you've defined

	 } else {

	 tempParts[0] += "&" + utms.join("&");

	 }

	 tempLink = tempParts.join("#");

	 }

	 links[index].href = tempLink;

	 }

	 }

 	 

 	 });



	 }()); 



	 function setCookie(cname, cvalue, exdays) { 

	  var d = new Date();

	  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

	  var expires = "expires="+d.toUTCString();

	  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

	}



	function getCookie(cname) {

	  var name = cname + "=";

	  var ca = document.cookie.split(';');

	  for(var i = 0; i < ca.length; i++) {

	    var c = ca[i];

	    while (c.charAt(0) == ' ') {

	      c = c.substring(1);

	    }

	    if (c.indexOf(name) == 0) {

	      return c.substring(name.length, c.length);

	    }

	  }

	  return "";

	}



	function checkCookie(cname) {

	  var user = getCookie(cname);

	  if (user != "") {

	    return true;

	  } else {

	    return false;

	  }

	}





	function getUrlParameter(sParam) {

	    var sPageURL = window.location.search.substring(1),

	        sURLVariables = sPageURL.split('&'),

	        sParameterName,

	        i;



	    for (i = 0; i < sURLVariables.length; i++) {

	        sParameterName = sURLVariables[i].split('=');



	        if (sParameterName[0] === sParam) {

	            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);

	        }

	    }

	}