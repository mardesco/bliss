// collapsing-nav-menu.js
/*
@package Collapsing Nav Menu
@author Jesse Smith
@copyright 2014
@license MIT license
@instructions To keep the script lightweight (not dependent on jQuery) place it in the footer of your document. (That way there's no need for an onload event handler.) Functionality depends on the collapsing-nav-menu.css.  If you received this script bundled with a WordPress theme file, the collapsing-nav-menu.css may be integrated with your theme's primary stylesheet.
*/

// initialize the feature.
var is_menu_resized,is_menu_open,menu,menu_element,trigger_width,menuClass,clickMe;

/* you can edit these default variables to suit your design.  */
	
menu_element = 'headerNavWrap';//should be the element ID of a parent or container element.
	
trigger_width = 760;// integer.  Minimum width, in pixels, of the screen before the menu will be resized.
	
/* you should not need to edit below this line.  */


	
is_menu_resized = false;//initial condition
is_menu_open = false;

menu = document.getElementById(menu_element);
	
should_menu_be_resized();

clickMe = document.createElement('a');
clickMe.className = 'open_menu_button';// style it with CSS.
clickMe.innerHTML = "MENU";

menu.firstChild.parentNode.insertBefore(clickMe, menu.firstChild);

clickMe.onclick = function(e){
	e.preventDefault();
	e.stopPropagation();
	if(is_menu_open){
		close_collapsed();
	}else{
		unfold_collapsed();
	}
}

function collapse_menu(){
	menu.className += ' collapsed';
	is_menu_resized = true;
}

function unfold_collapsed(){
	menu.className += ' open';
	is_menu_open = true;
}

function close_collapsed(){
	menuClass = menu.className;
	menu.className = menuClass.replace(' open', '');
	is_menu_open = false;
}

function expand_menu(){
	menuClass = menu.className;
	menu.className = menuClass.replace(' collapsed', '');
	is_menu_resized = false;
}

function should_menu_be_resized(){
	if(window.innerWidth < trigger_width && is_menu_resized == false){collapse_menu();}
	if(window.innerWidth >= trigger_width && is_menu_resized == true){expand_menu();}
}

window.onresize = function(e){should_menu_be_resized();}