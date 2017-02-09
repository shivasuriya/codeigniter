<script src='jquery.min.js'></script>
<script>
//login();
function login()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/session/login',
  type : 'POST',
  datatype : 'JSONP',
  data : {uname:'admin',pwd:'admin'},
  success : function(data){
   alert(data);
  }
 });
}
//logout();
function logout()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/session/logout/1',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'4rfupDPNjD0GloRx'},
  success : function(data){
   alert(data);
  }
 });
}
//demo_get();
function demo_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/demographics/get/DEM',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//demo_fields();
function demo_fields()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/demographics/fields/DEM/1Who',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//demo_ins_tabs();
function demo_ins_tabs()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/demographics/get_ins_tabs/1',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//demo_ins_details();
function demo_ins_details()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/demographics/get_ins_details/1',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//provider_get();
function provider_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/provider/get/1/username',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//appointment_status_get();
function appointment_status_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/appointment_status/get',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//eligibility_get();
function eligibility_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/eligibility/get/1',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//insurance_get();
function insurance_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/insurance/get/2',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//calendar_category_get();
function calendar_category_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/calendar_category/get',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//facility_get();
function facility_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/facility/get/fac',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//patient_get();
function patient_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/patient/get/1',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//appointment_get();
function appointment_get()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/appointment/get/2016/06/1',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD'},
  success : function(data){
   alert(data);
  }
 });
}
//appointment_insert();
function appointment_insert()
{
 $.ajax({
  url : 'http://localhost/openemr/codeigniter/index.php/appointment/insert',
  type : 'POST',
  datatype : 'JSONP',
  data : {accesstoken:'lmTj3r0jQ0BB5SaD',args:{'recurrspec':'a:6:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";s:6:"exdate";s:0:"";}','location':'a:6:{s:14:"event_location";s:0:"";s:13:"event_street1";s:0:"";s:13:"event_street2";s:0:"";s:10:"event_city";s:0:"";s:11:"event_state";s:0:"";s:12:"event_postal";s:0:"";}','aid':1,pid:1,title:'Office Visit','hometext':'',apptstatus:'-',eventDate:'2016-06-28',enddate:'0000-00-00',starttime:'08:45:00',endtime:'09:00:00',catid:5,duration:900,recurrtype:0,allday:0,facility:3,billing_facility:3}},
  success : function(data){
   alert(data);
  }
 });
}
</script>
