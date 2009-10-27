/**
function getCookie(name) {
    var start = document.cookie.indexOf( name + "=" );
    var len = start + name.length + 1;
    if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) {
        return null;
    }
    if ( start == -1 ) return null;
    var end = document.cookie.indexOf( ";", len );
    if ( end == -1 ) end = document.cookie.length;
    return unescape( document.cookie.substring( len, end ) );
}    

function setCookie( name, value, expires, path, domain, secure ) {
    var today = new Date();
    today.setTime( today.getTime() );
    if ( expires ) {
        expires = expires * 1000 * 60 * 60 * 24;
    }
    var expires_date = new Date( today.getTime() + (expires) );
    document.cookie = name+"="+escape( value ) +
        ( ( expires ) ? ";expires="+expires_date.toGMTString() : "" ) + //expires.toGMTString()
        ( ( path ) ? ";path=" + path : "" ) +
        ( ( domain ) ? ";domain=" + domain : "" ) +
        ( ( secure ) ? ";secure" : "" );
}
    
function deleteCookie( name, path, domain ) {
    if ( getCookie( name ) ) document.cookie = name + "=" +
            ( ( path ) ? ";path=" + path : "") +
            ( ( domain ) ? ";domain=" + domain : "" ) +
            ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

**/
function get_cookie(name) {
	cookiename = name + '=';
	cookiepos = document.cookie.indexOf(cookiename);
	if(cookiepos != -1) {
		cookiestart =cookiepos+cookiename.length;
		cookieend = document.cookie.indexOf(';', cookiestart);
		if(cookieend == -1) {
			cookieend = document.cookie.length;
		}
		return unescape(document.cookie.substring(cookiestart, cookieend));
	}
	return '';
}

function set_cookie(name, value) {
	expires = new Date();
	expires.setTime(expires.getTime() + 2592000);
	document.cookie = name + "=" + value + "; path=/; expires=" + expires.toGMTString();
}

function $(id) {
	return document.getElementById(id);
}

var collapsed = get_cookie('bbs_collapse');
function collapse_change(menucount) {
	if($('menu_' + menucount).style.display == 'none') {
		$('menu_' + menucount).style.display = '';collapsed = collapsed.replace('[' + menucount + ']' , '');
		$('menuimg_' + menucount).src = './images/menu_reduce.gif';
	} else {
		$('menu_' + menucount).style.display = 'none';collapsed += '[' + menucount + ']';
		$('menuimg_' + menucount).src = './images/menu_add.gif';
	}
	set_cookie('bbs_collapse', collapsed);
}