function chk(ival)
{
 var tot=0;
for (var i=0;i<ival;i++)
{
var x=eval("document.form1."+"chb"+i+".checked");
if(x)
     {
     tot=1;
     }
 }
 if(tot==0)
 {
 return false;
 }else
 return true;
}

function sel(name,ival)
{var tot=0;
 	for(var i=0;i<ival;i++)
 	{var k=document.getElementById(name+i).options[document.getElementById(name+i).selectedIndex].value;
 	if(k=="0")
 	{tot=1;
 	}
	}
if(tot==1)
{return false;
	}else
	{return true;}
}


document.getElementById("frm1").onsubmit = function() {

	var par=getUrlParameters("page", "", true);
alert(par);
alert("form is submitted");
}


document.getElementById("btn").onclick = function() {
 if(document.getElementById("btn").value=="Update")
 {
 var k=chk(document.getElementById("user_appraisal").rows.length-1);
 if(k)
 {
 }else
 {alert("Please Select at least one checkbox to update!");
 return false;
 }
}
/* if(document.getElementById("btn").value=="Update Payroll")
{
	var cout = document.getElementById("count_op").value;
	alert(cout);
	var cout1 = document.getElementById("count_cl").value;
	alert(cout1);
	if(cout>=1 ){alert("You Can't Open Multiple Payrolls...!!");return false;}

	
} */
}

// Start Autopopulated Empid in Paystate
document.getElementsByName("empid0")[0].onclick = function() {
var emp = document.getElementById("emp").value;
document.getElementsByName("empid0")[0].value = emp;
document.getElementsByName("empid0")[0].readOnly = true;
}
// End Autopopulated Empid in Paystate

//Start AutoCalculate Total in Investment Form
document.getElementsByName("april_amt")[0].onclick = function() {

}
//End AutoCalculate Total in Investment Form


document.getElementById("btn1").onclick = function() {
	var k = chk(document.getElementById("user_appraisal").rows.length-1);
	if(k)
	{
	alert("Please Click Update Button before "+ document.getElementById("btn1").value);
	return false;
	}
if(document.getElementById("btn1").value == "Submit\ for\ review")
{
var k=sel("self_rating",document.getElementById("user_appraisal").rows.length-1);
if(k)
{}else{alert("You cannot submit for review unless you change all the 0 ratings and update them"); return false;}
}
if(document.getElementById("btn1").value == "Submit\ for\ rating")
{
	var k=sel("mgr_rating",document.getElementById("user_appraisal").rows.length-1);
	if(k)
	{}else{alert("You cannot submit for review unless you change all the 0 ratings and update them"); return false;}
	if(document.getElementById("user_rating").rows[1].cells[1].innerHTML=="0")
	{
	alert("You should submit for rating after overall rating in Appraisal Rating link");
	return false;
	}
}
return true;
}

document.getElementById("btn_del").onclick = function() {
	 if(document.getElementById("btn_del").value=="Delete")
	 {
	 var k=chk(document.getElementById("user_appraisal").rows.length-1);
	 if(k)
	 {
	 }else
	 {
		 alert("Please Select at least one checkbox to update!");
		 return false;
	 }
	}
}


