jQuery.fn.center = function(parent)
{
	if (parent) parent = this.parent();
	else parent = window;
	this.css
	({
		"position": "relative",
		"top": ((($(parent).height() - this.height()) / 2) + $(parent).scrollTop() + "px"),
		"left": ((($(parent).width() - this.width()) / 2) + $(parent).scrollLeft() + "px")
	});

	return this;
}

jQuery.fn.vcenter = function(parent)
{
	if (parent) parent = this.parent();
	else parent = window;
	this.css(
	{
		"position": "relative",
		"top": ((($(parent).height() - this.outerHeight()) / 2) + $(parent).scrollTop() + "px"),
		"left": "auto"
	});

	return this;
}

jQuery.fn.hcenter = function(parent)
{
	if (parent) parent = this.parent();
	else parent = window;
	this.css(
	{
		"position": "relative",
		"top": "auto",
		"left": ((($(parent).width() - this.outerWidth()) / 2) + $(parent).scrollLeft() + "px")
	});

	return this;
}