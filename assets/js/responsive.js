function unwrap() {
	var dropdown = document.getElementById("dropdown-mobile");
	if (dropdown.dataset.wrapped == "true") {
		dropdown.style.display = 'block';
		dropdown.dataset.wrapped = "false";
	} else {
		dropdown.style.display = 'none';
		dropdown.dataset.wrapped = "true";
	}
	return false;
}
