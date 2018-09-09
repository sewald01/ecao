window.onload = function() {
		
	// toggle the main menu and current sub-menu
	
	var menuClicked = true;
	
	
		
	jQuery("#menu-toggle").click(function() { 
	
		var menuMain = $("#menu-main");
			
		if (menuClicked == true) {
		
			menuMain.animate({left: "-=280"});
			menuClicked = false;
			return false;
		}else{
			
			jQuery("#menu-main").animate({left: "100%"});
			menuClicked = true;
			return false;
		
		};
		
		
	});

	
	
	jQuery(".arrow").click(function() { 
		var arrowVariable = $(this);
		var parentMenu = arrowVariable.parent();
		var childMenu = parentMenu.children('#sub-menu');
		$( childMenu ).slideToggle();
		//jQuery("#sub-menu").slideToggle();
		return false;
	});
	
	jQuery(".arrow2").click(function() { 
		jQuery("#sub-menu2").slideToggle();
		return false;
	});
	
};
