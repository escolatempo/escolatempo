var script = window.location.pathname.split("/").slice(0,2).join("/");

if (script == '/') {
	script = "index";
}

document.write('<script src="../js/auto_load/'+ script +'.js"></script>');