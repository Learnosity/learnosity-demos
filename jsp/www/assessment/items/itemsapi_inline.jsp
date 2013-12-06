
<%@include file="../../config.jsp"%>

<jsp:include page= '../../includes/header.jsp' />


<%@ page import="com.learnosity.security.RequestHelper" %>
<%@ page import="java.util.Date" %>
<%@ page import="java.util.LinkedHashMap" %>
<%@ page import="java.text.SimpleDateFormat" %>
<%@ page import="java.util.UUID" %>


<%

        String service = "items";

        LinkedHashMap<String, Object> securityPacket = new LinkedHashMap(), requestPacket = new LinkedHashMap(), configObject = new LinkedHashMap();

        securityPacket.put("consumer_key",consumer_key);
        securityPacket.put("domain", domain);


        String[] items = {"ccore_video_260_classification", "ccore_parcc_tecr_grade3"};

        securityPacket.put("timestamp", timestamp);

        requestPacket.put("user_id", "12345678");
        requestPacket.put("rendering_type", "inline");
        requestPacket.put("name", "Items API demo - inline activity.");
        requestPacket.put("state", "initial");
        requestPacket.put("activity_id", "itemsinlinedemo");
        requestPacket.put("session_id",UUID.randomUUID());
        requestPacket.put("course_id", courseid);
        requestPacket.put("items",items);
        requestPacket.put("type","submit_practice");

        configObject.put("renderSubmitButton", true);

        requestPacket.put("config", configObject);

        RequestHelper reqHelp = new RequestHelper(service, securityPacket, consumer_secret, requestPacket, null);
        String signedActivity = reqHelp.generateRequest();

%>

<!-- Container for the items api to load into -->
<script src="http://items.learnosity.com/"></script>
<script>
    var activity = <%out.print(signedActivity); %>;
    LearnosityItems.init(activity);
</script>

<div class="jumbotron">
    <h1>Items API – Inline</h1>
    <p>Display items from the Learnosity Item Bank in no time with the Items API.  The Items API builds on the Questions API's power and makes it quicker to integrate.<p>
    <div class="row">
        <div class="col-md-10">
            <!--
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#settings">
                <span class="glyphicon glyphicon-list-alt"></span> Customise API Settings
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
            -->
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="./../assess/index.php">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<p>
    <span class="learnosity-item" data-reference="ccore_video_260_classification"></span>
    <span class="learnosity-item" data-reference="ccore_parcc_tecr_grade3"></span></p>
    <span class="learnosity-submit-button"></span>
</p>


<jsp:include page= '../../includes/footer.jsp' />
