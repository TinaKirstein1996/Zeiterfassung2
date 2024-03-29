

function displayDate() {
  document.getElementById("Startzeitpunkt").innerHTML = Date();
}









            //const nativePicker = document.querySelector('.nativeTimePicker');
const fallbackPicker = document.querySelector('.fallbackTimePicker');
const fallbackLabel = document.querySelector('.fallbackLabel');

const hourSelect_start = document.querySelector('#hour_start');
const minuteSelect_start = document.querySelector('#minute_start');
const hourSelect_end = document.querySelector('#hour_end');
const minuteSelect_end = document.querySelector('#minute_end');
const hourSelect_pause = document.querySelector('#hour_pause');
const minuteSelect_pause = document.querySelector('#minute_pause');
const submitButtonTest = document.querySelector('#submitButtonTest');


hourSelect_end.disabled = true;
minuteSelect_end.disabled = true;
hourSelect_pause.disabled = true;
minuteSelect_pause.disabled = true;
submitButtonTest.disabled=true;

  fallbackPicker.style.display = 'block';
  fallbackLabel.style.display = 'block';

  // Populate the hours and minutes dynamically
  populateHours(hourSelect_start);
  populateMinutes(minuteSelect_start);


function populateHours(hourSelect,start=0,end=23) {
  // Populate the hours <select> with the 6 open hours of the day
    let options = hourSelect.getElementsByTagName('option');

for (var i=options.length; i--;) {
    hourSelect.removeChild(options[i]);
}
    for (let i = start; i <= end; i++) {
    const option = document.createElement('option');
    option.textContent = i;
    hourSelect.appendChild(option);
  }
}

function populateMinutes(minuteSelect,start_min=0,end_min=59) {
  // populate the minutes <select> with the 60 hours of each minute
    let options = minuteSelect.getElementsByTagName('option');

for (var i=options.length; i--;) {
    minuteSelect.removeChild(options[i]);
}
    for (let i = start_min; i <= end_min; i++) {
    const option = document.createElement('option');
    option.textContent = (i < 10) ? `0${i}` : i;
    minuteSelect.appendChild(option);
  }
}

// make it so that if the hour is 18, the minutes value is set to 00
// — you can't select times past 18:00
 function setMinutesToZero() {
   if (hourSelect.value === '18') {
     minuteSelect.value = '00';
   }
 }

 function setEndSelectableTime(){
    if((hourSelect_start.value||hourSelect_start.value==0)&&minuteSelect_start.value){
        hourSelect_end.disabled=false;
        minuteSelect_end.disabled=false;

        populateHours(hourSelect_end,start=hourSelect_start.value);
        populateMinutes(minuteSelect_end);
    }
    else{
        hourSelect_end.disabled=true;
        minuteSelect_end.disabled=true;

        hourSelect_end.value=undefined;
        minuteSelect_end.value=undefined;
        
    }
}
function CheckPossibleEndMinutes(){
    if(hourSelect_end.value==hourSelect_start.value){
        populateMinutes(minuteSelect_end,start_min=Number(minuteSelect_start.value));
        
    }
    else{
        populateMinutes(minuteSelect_end);

    }
}
hourSelect_end.onchange = ()=>{
    CheckPossibleEndMinutes();
    setPauseSelectableTime();
}

hourSelect_start.onchange = ()=>{
    setEndSelectableTime();
    CheckPossibleEndMinutes();
    setPauseSelectableTime();
 }
 minuteSelect_start.onchange = ()=>{
    setEndSelectableTime();
    CheckPossibleEndMinutes();
    setPauseSelectableTime();
 }

 
 
 
 
 
 //muss noch realisiert werden pause
 function setPauseSelectableTime(){
    if((hourSelect_end.value)&&minuteSelect_start.value){
        hourSelect_pause.disabled=false;
        minuteSelect_pause.disabled=false;
        submitButtonTest.disabled=false;
        minZeit = 0
        maxZeit = hourSelect_end.value - hourSelect_start.value
        populateHours(hourSelect_pause, start=minZeit, end=maxZeit);
        minZeit = 0
        maxZeit = 59
        populateMinutes (minuteSelect_pause, start=minZeit, end=maxZeit);
    }
    else{
        hourSelect_pause.disabled=true;
        minuteSelect_pause.disabled=true;
        submitButtonTest.disabled=true;
        hourSelect_pause.value=undefined;
        minuteSelect_pause.value=undefined;
        hourSelect_start.value!=undefined
        
    }
}
 function populsteHoursPause(){
	    if(hourSelect_pause, start = 0){
	        
	        
	    }
	    else{
	    	end=maximaleStundenanzahl;
	    }   
}
	
 maximaleStundenanzahl = hourSelect_end.value - hourSelect_start.value


//Funktion, die den Submit abfängt/durchführt
submitButtonTest.onclick= ()=>{
  console.log("Clicked")
  let startTime = (hourSelect_start.value<10?"0":"")+String(hourSelect_start.value)+":"+(Number(minuteSelect_start.value)<10?"0":"")+String(Number(minuteSelect_start.value));
  let endTime = (hourSelect_end.value<10?"0":"")+String(hourSelect_end.value)+":"+(Number(minuteSelect_end.value)<10?"0":"")+String(Number(minuteSelect_end.value));
  let startAsDateObject = new Date('1970-01-01T' + startTime + ':00Z');
  let endAsDateObject = new Date('1970-01-01T' + endTime + ':00Z');
  console.log(startTime,endTime)
  let gearbeiteteZeit = endAsDateObject.getTime()-startAsDateObject.getTime();
  console.log(gearbeiteteZeit,endAsDateObject.getTime(),startAsDateObject.getTime())
  
  const sendToDB = async () => {
  const rawResponse = await fetch('/euerPHP_Endpoint.php', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({workingDuration:gearbeiteteZeit}) //Übergibt die gearbeitete Zeit in Millisekunden, vermutlich ist es noch sinnvoll die BenutzerIdentität mit zu schicken, damit das richtig in der DB gespeichert werden kann.
  });
  const content = await rawResponse.json();

  console.log(content); //gibt die Antwort der PHP seite in der Browser Console aus
};
sendToDB();

}

 //hourSelect.onchange = setMinutesToZero;
 //minuteSelect.onchange = setMinutesToZero;



var hours =0;
var mins =0;
var seconds =0;

$('#start').click(function(){
      startTimer();
});

$('#stop').click(function(){
      clearTimeout(timex);
});

$('#reset').click(function(){
      hours =0;      mins =0;      seconds =0;
  $('#hours','#mins').html('00:');
  $('#seconds').html('00');
});

function startTimer(){
  timex = setTimeout(function(){
      seconds++;
    if(seconds >59){seconds=0;mins++;
       if(mins>59) {
       mins=0;hours++;
         if(hours <10) {$("#hours").text('0'+hours+':')} else $("#hours").text(hours+':');
        }
                       
    if(mins<10){                     
      $("#mins").text('0'+mins+':');}       
       else $("#mins").text(mins+':');
                   }    
    if(seconds <10) {
      $("#seconds").text('0'+seconds);} else {
      $("#seconds").text(seconds);
      }
     
    
      startTimer();
  },1000);
}

