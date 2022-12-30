function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}

date = new Date();
year = date.getFullYear();
month = date.getMonth() + 1;
day = date.getDate();
document.getElementById("current_date").innerHTML = "Heute, " + day + "." + month + "." + year;
document.getElementById("current_date2").innerHTML = year + "-" + month + "-" + day;

function quicktracking() {
	Swal.fire(
		'Erfolg!',
		'Ihre Arbeitszerit wurde erfolgreich erfasst.',
		'success'
	)
}