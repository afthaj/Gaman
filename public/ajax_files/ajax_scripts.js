<script type="text/javascript">

function change_object_type(str, related_object) {
	
	if (str == "") {
		related_object.innerHTML = "<p>nothing</p>";
		return;
		}
		
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		request = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
	request.onreadystatechange = function() {
		
		if (request.readyState == 4 && request.status == 200) {
			related_object.innerHTML = request.responseText;
			}
		
		}
		
	request.open("GET","../ajax_files/get_object_types.php?q=" + str, true);
	
	request.send();
	
	}

</script>