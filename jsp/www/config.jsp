<%


String consumer_key = "yis0TYCu7U9V4o7M";
// Note - Consumer secret should never get displayed on the page - only used for creation of signature server side
String consumer_secret = "74c5fd430cf1242a527f6223aebd42d30464be22";

// Setup some basic variables
String courseid  = "demo_" + consumer_key;
String studentid = "demo_student";
String teacherid = "demo_teacher";
String schoolid  = "demo_school";

// Generate timestamp in format YYYYMMDD-HHMM for use in signature

Date date = new Date();
SimpleDateFormat sdf = new SimpleDateFormat("YYYYMMdd-HHmm");
String timestamp = sdf.format(date);
String domain    = request.getServerName(); // Tested on "localhost"
String thispage  = "http://" + request.getServerName() + request.getServerPort() + request.getContextPath();

%>