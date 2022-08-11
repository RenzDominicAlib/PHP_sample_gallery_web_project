function confirmDel(){
	var confirmMessage = "Are you sure to delete this permanently?";

	if (confirm(confirmMessage)) {
		return true;
	}
	
	else{
		return false;
	}
	
}