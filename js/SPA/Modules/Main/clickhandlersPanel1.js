// Handle adding initial menu item
$('#dzParentMenuItem').on('keypress', function(e) {
	if(e.which == 13) {
		e.preventDefault();
		e.stopPropagation();
		addParentMenu();
	}
});
$('a[name="addMenuParentItem"]').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	addParentMenu();
});
/**
 * [addParentMenu method grabs parent menu item from UI, adds value to history
 * then checks to see if any parent menu items exist yet. If they do not the
 * parent UL is created with the first menu item, otherwise child li's are appended.]
 */
function addParentMenu () {
	var menuItem = $('#dzParentMenuItem').val();
	var initialMenuCheck = $('#dzParentMenuUl').length;
	var li = '<li><a href="#">' + menuItem + '</a></li>';
	var historyItemKey = menuItem;
	Dropzilla.history.set("parentMenuItems", li, {
		item: "parentMenuItems",
		key: historyItemKey
	});
	if (initialMenuCheck === 0) {
		$('#drozillaStage').html('<ul id="dzParentMenuUl">' + li + '</ul>');
	} else {
		$('#dzParentMenuUl').append(li);
	}
}
// Handle change event on menu orientation
$('#dzMenuOrientation').on('change', function(e){
	e.preventDefault();
	e.stopPropagation();
	var orientation = $(this).val();

	if (orientation == "horizontal") {
		$("#dzParentMenuUl li").css("float", "left");
		Dropzilla.history.set("parentMenuItemsCss", "left", {
			item:"parentMenuItemsCss",
			key: "float"
		});
	} else {
		Dropzilla.history.set("parentMenuItemsCss", "", {
			item:"parentMenuItemsCss",
			key: "float"
		});
		$("#dzParentMenuUl li").css("float", "");
	}
});
// Handle change event on link type
$('#dzMenuLinkType').on('change', function(e){
	e.preventDefault();
	e.stopPropagation();
	var linkType = $(this).val();
	Dropzilla.history.set("parentMenuItemsCss", linkType, {
		item: "parentMenuItemsCss",
		key: "display"
	});
	if (linkType == "block") {
		$("#dzParentMenuUl li a").css("display", "block");
	} else {
		$("#dzParentMenuUl li a").css("display", "");
	}
});
// Handle adding padding to parent menu
$('a[name="addMenuParentPadding"]').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	var topPadding = $('#dzParentPaddingTop').val();
	var padding;
	if(topPadding.length > 0) {
		topPadding += "px";
		var rightPadding = $('#dzParentPaddingRight').val() + "px";
		var bottomPadding = $('#dzParentPaddingBottom').val() + "px";
		var leftPadding = $('#dzParentPaddingLeft').val()  + "px";
		Dropzilla.history.set("parentMenuItemsCss", topPadding, {
			item: "parentMenuItemsCss",
			key: "padding-top"
		});
		Dropzilla.history.set("parentMenuItemsCss", rightPadding, {
			item: "parentMenuItemsCss",
			key: "padding-right"
		});
		Dropzilla.history.set("parentMenuItemsCss", bottomPadding, {
			item: "parentMenuItemsCss",
			key: "padding-bottom"
		});
		Dropzilla.history.set("parentMenuItemsCss", leftPadding, {
			item: "parentMenuItemsCss",
			key: "padding-left"
		});
		$("#dzParentMenuUl li a").css("padding-top", topPadding);
		$("#dzParentMenuUl li a").css("padding-right", rightPadding);
		$("#dzParentMenuUl li a").css("padding-bottom", bottomPadding);
		$("#dzParentMenuUl li a").css("padding-left", leftPadding);
	} else {
		padding = $("#dzParentPadding").val() + "px";
		Dropzilla.history.set("parentMenuItemsCss", padding, {
			item: "parentMenuItemsCss",
			key: "padding"
		});
		$("#dzParentMenuUl li a").css("padding", padding);
	}
});

// Toggle padding options click handler
$('a[name="dzTogglePaddingOptions"]').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();

	Dropzilla.history.remove("parentMenuItemsCss", "padding");
	Dropzilla.history.remove("parentMenuItemsCss", "padding-top");
	Dropzilla.history.remove("parentMenuItemsCss", "padding-right");
	Dropzilla.history.remove("parentMenuItemsCss", "padding-bottom");
	Dropzilla.history.remove("parentMenuItemsCss", "padding-left");

	$("#dzParentPadding").val("");
	$('#dzParentPaddingTop').val("");
	$('#dzParentPaddingRight').val("");
	$('#dzParentPaddingBottom').val("");
	$('#dzParentPaddingLeft').val("");
	$('.dzPaddingOptionsA').toggle('fast');
	$('.dzPaddingOptionsB').toggle('fast');
});
// Handle adding margins
$('a[name="addMenuParentMargins"]').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	var topMargin = $('#dzParentMarginTop').val();
	var allMargins;
	if(topMargin.length > 0) {
		topMargin += "px";
		var rightMargin = $('#dzParentMarginRight').val() + "px";
		var bottomMargin = $('#dzParentMarginBottom').val() + "px";
		var leftMargin = $('#dzParentMarginLeft').val() + "px";
		Dropzilla.history.set("parentMenuItemsCss", topMargin, {
			item: "parentMenuItemsCss",
			key: "margin-top"
		});
		Dropzilla.history.set("parentMenuItemsCss", rightMargin, {
			item: "parentMenuItemsCss",
			key: "margin-right"
		});
		Dropzilla.history.set("parentMenuItemsCss", bottomMargin, {
			item: "parentMenuItemsCss",
			key: "margin-bottom"
		});
		Dropzilla.history.set("parentMenuItemsCss", leftMargin, {
			item: "parentMenuItemsCss",
			key: "margin-left"
		});

		$('#dzParentMenuUl li').css('margin-top', topMargin);
		$('#dzParentMenuUl li').css('margin-right', rightMargin);
		$('#dzParentMenuUl li').css('margin-bottom', bottomMargin);
		$('#dzParentMenuUl li').css('margin-left', leftMargin);
	} else {
		allMargins = $('#dzParentMargins').val() + "px";
		Dropzilla.history.set("parentMenuItemsCss", allMargins, {
			item: "parentMenuItemsCss",
			key: "margin"
		});
		$("#dzParentMenuUl li").css("margin", allMargins);
	}
});

// Toggle margins options click handler
$('a[name="dzToggleMarginOptions"]').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();

	Dropzilla.history.remove("parentMenuItemsCss", "margin");
	Dropzilla.history.remove("parentMenuItemsCss", "margin-top");
	Dropzilla.history.remove("parentMenuItemsCss", "margin-right");
	Dropzilla.history.remove("parentMenuItemsCss", "margin-bottom");
	Dropzilla.history.remove("parentMenuItemsCss", "margin-left");

	$('#dzParentMargins').val("");
	$('#dzParentMarginTop').val("");
	$('#dzParentMarginRight').val("");
	$('#dzParentMarginBottom').val("");
	$('#dzParentMarginLeft').val("");
	$('.dzMarginOptionsA').toggle('fast');
	$('.dzMarginOptionsB').toggle('fast');
});
// Handle change event on border type
$('#dzBorderType').on('change', function(e){
	e.preventDefault();
	e.stopPropagation();
	var type = $(this).val();
	Dropzilla.history.set("borderType", type);
});
// Handle adding borders
$('a[name="addMenuParentBorders"]').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	var topBorder = $('#dzParentBorderTop').val();
	var allBorders;
	if(topBorder.length > 0) {
		topBorder += "px " + Dropzilla.history.get("borderType") + " " + Dropzilla.history.get("borderColor");
		var rightBorder = $('#dzParentBorderRight').val() + "px " + Dropzilla.history.get("borderType") + " " + Dropzilla.history.get("borderColor");
		var bottomBorder = $('#dzParentBorderBottom').val() + "px " + Dropzilla.history.get("borderType") + " " + Dropzilla.history.get("borderColor");
		var leftBorder = $('#dzParentBorderLeft').val() + "px " + Dropzilla.history.get("borderType") + " " + Dropzilla.history.get("borderColor");
	
		Dropzilla.history.set("parentMenuItemsCss", topBorder, {
			item: "parentMenuItemsCss",
			key: "border-top"
		});
		Dropzilla.history.set("parentMenuItemsCss", rightBorder, {
			item: "parentMenuItemsCss",
			key: "border-right"
		});
		Dropzilla.history.set("parentMenuItemsCss", bottomBorder, {
			item: "parentMenuItemsCss",
			key: "border-bottom"
		});
		Dropzilla.history.set("parentMenuItemsCss", leftBorder, {
			item: "parentMenuItemsCss",
			key: "border-left"
		});

		$('#dzParentMenuUl li').css('border-top', topBorder);
		$('#dzParentMenuUl li').css('border-right', rightBorder);
		$('#dzParentMenuUl li').css('border-bottom', bottomBorder);
		$('#dzParentMenuUl li').css('border-left', leftBorder);
	} else {
		allBorders = $('#dzParentBorders').val() + "px " + Dropzilla.history.get("borderType") + " " + Dropzilla.history.get("borderColor");

		Dropzilla.history.set("parentMenuItemsCss", allBorders, {
			item: "parentMenuItemsCss",
			key: "border"
		});

		$("#dzParentMenuUl li").css("border", allBorders);
	}
});

// Toggle border options click handler
$('a[name="dzToggleBorderOptions"]').on('click', function(e){
	e.preventDefault();
	e.stopPropagation();

	Dropzilla.history.remove("parentMenuItemsCss", "border");
	Dropzilla.history.remove("parentMenuItemsCss", "border-top");
	Dropzilla.history.remove("parentMenuItemsCss", "border-right");
	Dropzilla.history.remove("parentMenuItemsCss", "border-bottom");
	Dropzilla.history.remove("parentMenuItemsCss", "border-left");

	$('#dzParentBorders').val("");
	$('#dzParentBorderTop').val("");
	$('#dzParentBorderRight').val("");
	$('#dzParentBorderBottom').val("");
	$('#dzParentBorderLeft').val("");
	$('.dzBorderOptionsA').toggle('fast');
	$('.dzBorderOptionsB').toggle('fast');
});
// Handle Get Code button
$("#dzGetCode").on('click', function(e){
	e.preventDefault();
	e.stopPropagation();
	/*var dropzillaCode = $("#drozillaStage").html();
	var baseCSS = "<style>#dzParentMenuUl { list-style-type: none; } #dzParentMenuUl a:link { text-decoration: none; }</style>";*/
	// TODO: Change Dropzilla.history.set to use an array full of property objects so you can set the parent link color
	// TODO: Chage the styles model to iterate through the properties with the new construct
	$.ajax({
		type: 'POST',
		url:'http://dropzilla.dev/api/styles/aggregate',
		cache: false,
		data: JSON.stringify({"fileName":"newTest","cssSelector":"#test","properties": Dropzilla.history.config["parentMenuItemsCss"]}),
		success: function(result) {
			//alert('made it');
		}
	});

	for (var k in Dropzilla.history.config)
	{
		for (var key in Dropzilla.history.config["parentMenuItems"])
		{
			console.log(key + " => " + Dropzilla.history.config["parentMenuItems"][key]);
		}
	}

	for (var j in Dropzilla.history.config)
	{
		for (var jkey in Dropzilla.history.config["parentMenuItemsCss"])
		{
			console.log(jkey + " => " + Dropzilla.history.config["parentMenuItemsCss"][jkey]);
		}
	}

	//$("#dropzillaCodeView").text(baseCSS + dropzillaCode);
});