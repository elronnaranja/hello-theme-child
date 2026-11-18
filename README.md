# HELLO ELEMENTOR CHILD

Contributors: [Elron Naranja](https://elronnaranja.com), Jermaine Lorenzo | Starter child theme for Connective Web Design (CWD) projects (first made for [Creative Bananas](https://creativebananas.com)).

# How we build (v2)

1. **Globals only.** Elementor > Site Settings: set **Global Colors** and **Global Fonts** only. Typography, Buttons, Form Fields and the rest of Theme Style pick from those globals, never their own values.
2. **Base fonts on every project:** Page Title = H1 (system *Primary*), Section Title = H2 (*Secondary*), Module Title = H3 (*Accent*), Body Text (*Text*). Other fonts (eyebrow, H4-H6, quote, button...) are per project.
3. **Readable IDs.** Give each custom global a readable ID (e.g. `cream`, `eyebrow`) so its CSS variable reads `--e-global-color-cream` / `--e-global-typography-eyebrow-font-size`. Use those variables in `style.css`; never hard-code a hex or font.
4. **One `style.css`, one `js/script.js`.** All custom styling and all jQuery. Use Elementor's own options before custom code.
5. **Slick** for sliders (loaded by `functions.php`, base CSS at the end of `style.css`).
6. **Icons are SVG.** Upload SVGs (Elementor > Settings > Advanced > Unfiltered file uploads) and turn on Elementor's inline SVG icons.
7. **Brand guide page** on every site: all globals, H1 to H6, buttons and form fields in one page.
8. **Layout width** from the design goes in Site Settings > Layout > Content width.

Files are versioned by their last change (`filemtime`), so edits show up at once and caching still works.

# Plugins

### [Slick](https://kenwheeler.github.io/slick/)
Already loaded. Example set-up is in `js/script.js` > SLIDERS.

### [Linkify](https://www.jqueryscript.net/text/jQuery-Plugin-To-Transform-URLs-In-Text-Into-Links-linkify.html)
Uncomment the two Linkify lines in `functions.php`, then in `script.js`:
```
$("selector").linkify();
```

# jQuery Hacks 

### [MEGA MENU]
**How to set up**
1. Create a WP Menu.
2. Add a <code>class</code> "mega-menu prevented" to specific menu item as trigger. 
3. Create an elementor section as your mega menu with <code>class</code> and <code>ID</code>.
	- <code>class</code> = mega-menu
	- <code>ID</code> = Use the label used in the WP menu trigger. E.g "Main Services" = "main-services".

Notes: It might appear to be buggy when you don't have anything on page except the header & menu. It doesn't hide the menu but only "z-index: -1" which make it still hoverable if there are no other sections on the page to cover it.

**Script**
```
// Mega Menu
$("li.mega-menu").each(function(){
	// Variable the menu label as selector
	var menuClass = $(this).find("a")[0].childNodes[0].nodeValue.trim();
	menuClass = menuClass.replace(/\s+/g, '-').toLowerCase();

	$(this).hover(function() {
		// Add active to menu trigger to preserved hovered state
		$(this).find("a").addClass("active");
		$("#"+menuClass).addClass("active");
	}, function() {
		$(this).find("a").removeClass("active");
		$("#"+menuClass).removeClass("active");
	});
	// Preserve the hover on mega menu container
	$("#"+menuClass).hover(function() {
		$(this).addClass("active");
		$("li.mega-menu a:contains("+menuClass+")").addClass("active");
	}, function() {
		$(this).removeClass("active");
		$("li.mega-menu a:contains("+menuClass+")").removeClass("active");
	});
	//// Prevent going to URL on first click on Touch Devices
	$(this).on("touch", function(e) {
		if($(this).hasClass("prevented")) {
			event.preventDefault();
			$(this).removeClass("prevented");
		} else {
			$(this).addClass("prevented");
			$(this).unbind("click");
		}
	});
});
```
**Style**
```
section.mega-menu {
	position: absolute;
	top: 0;
	width: 100%;
	display: block;
	opacity: 0;
	transition: .3s !important;
	z-index: -1;
}
section.mega-menu.active {
	opacity: 1;
	z-index: 10;
}
#menu-main li.mega-menu a:hover:before {
	content: '';
	height: 20px; //Height of the distance from <a> to mega-menu
	width: 300vw;
	left: -100vw;
	position: absolute;
	top: 100%;
}
```

### [READ MORE/READ LESS]

**HTML Structure**
```
<div>
	This is the active/visible content. 
	<div class="read-more"> 
		<span>This is the hidden content that'll show when the Read More is triggered.</span>
		<a class="read-more-button" href="#!">READ MORE</a>
	</div>
</div>
```

**Script**
```
$(".read-more").each(function(){
	// This hides the span
	$(this).find("span").hide();
	$(this).find(".read-more-button").click(function(){
		// Handles the toggle HIDE/SHOW
		$(this).prev("span").slideToggle();
		
		// Changes READ MORE to READ LESS
		if ($(this).text() == "READ MORE") {
			$(this).text("READ LESS")
		} else {
			$(this).text("READ MORE")
		}
	});
});
```

**Style**
```
.read-more {
	display: inline;
}
```

### [SPLIT/WRAP TEXT]
```
// Initial HTML <div>This is a text & span</div>
// Result <div>This is a text & <span>span</span></div>
$('div').html(function(i, v){
	// Ampersand(&) is the trigger. The wrap will show after the ampersand(&)
	var html = v.split('&');
	return html[0] + ': ' + '<span>' + html[1] + '</span>';
});
```

# Elementor Manipulations

### [ACCORDION ON HOVER]

**Instructions**
1. Create an accordion in Elementor.
2. Add "active-hover" <code>class</code>  in the accordion.

**Script**
```
// Elementor Accordion
$(".active-hover .elementor-accordion-item").on("mouseenter click", function() {
	$(this).find(".elementor-tab-title").addClass("elementor-active");
	$(this).find(".elementor-tab-content").addClass("elementor-active");
	$(this).find(".elementor-tab-content").stop().slideDown("slow");
	// Slide off on others
	$(this).siblings().find(".elementor-tab-title").removeClass("elementor-active");
	$(this).siblings().find(".elementor-tab-content").removeClass("elementor-active");
	$(this).siblings().find(".elementor-tab-content").stop().slideUp("slow");
});
```

This code will reset the first child as active state.
```
// Reset to first child active
$(".active-hover .elementor-accordion").on("mouseleave", function() {
	$(this).find(".elementor-accordion-item:first-child .elementor-tab-title").addClass("elementor-active");
	$(this).find(".elementor-accordion-item:first-child .elementor-tab-content").addClass("elementor-active");
	$(this).find(".elementor-accordion-item:first-child .elementor-tab-content").stop().slideDown("slow");
	// Slide off on others
	$(this).find(".elementor-accordion-item:first-child").siblings().find(".elementor-tab-title").removeClass("elementor-active");
	$(this).find(".elementor-accordion-item:first-child").siblings().find(".elementor-tab-content").removeClass("elementor-active");
	$(this).find(".elementor-accordion-item:first-child").siblings().find(".elementor-tab-content").stop().slideUp("slow");
});
```

# Functions