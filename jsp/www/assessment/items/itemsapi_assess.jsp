
<%@include file="../../config.jsp"%>

<jsp:include page= '../../includes/header.jsp' />


<%@ page import="com.learnosity.security.RequestHelper" %>
<%@ page import="java.util.Date" %>
<%@ page import="java.util.LinkedHashMap" %>
<%@ page import="java.text.SimpleDateFormat" %>
<%@ page import="java.util.UUID" %>



<%

        String service = "items";

        LinkedHashMap<String, Object> securityPacket = new LinkedHashMap(),
        requestPacket = new LinkedHashMap(), configObject = new LinkedHashMap(),
        navObject = new LinkedHashMap(), timeObject = new LinkedHashMap();

        securityPacket.put("consumer_key",consumer_key);
        securityPacket.put("domain", domain);


        String[] items = {"ccore_video_260_classification", "ccore_parcc_tecr_grade3"};

        securityPacket.put("timestamp", timestamp);

        requestPacket.put("user_id", "12345678");
        requestPacket.put("rendering_type", "assess");
        requestPacket.put("name", "Items API demo - Assess activity.");
        requestPacket.put("state", "initial");
        requestPacket.put("activity_id", "itemsassessdemo");
        requestPacket.put("session_id",UUID.randomUUID());
        requestPacket.put("course_id", courseid);
        requestPacket.put("items",items);
        requestPacket.put("type","submit_practice");

        navObject.put("show_next", true);
        navObject.put("show_prev", true);
        navObject.put("show_fullscreencontrol", false);
        navObject.put("show_progress", true);
        navObject.put("show_submit", false);
        navObject.put("show_title", false);
        navObject.put("show_save", false);
        navObject.put("show_calculator", false);
        navObject.put("scroll_to_top", false);
        navObject.put("scroll_to_test", false);
        navObject.put("show_itemcount", true);
        navObject.put("toc", true);
        navObject.put("transition", "slide");
        navObject.put("transition_speed", 400);

        timeObject.put("max_time", 10);
        timeObject.put("limit_type", "soft");
        timeObject.put("show_pause", true);
        timeObject.put("warning_time", 60);
        timeObject.put("show_time", true);

        configObject.put("title", "");
        configObject.put("subtitle", "Walter White");
        configObject.put("navigation",navObject);
        configObject.put("time", timeObject);
        configObject.put("uistyle","main");
        configObject.put("renderSaveButton",true);
        configObject.put("ignore_validation",false);

        requestPacket.put("config", configObject);

        RequestHelper reqHelp = new RequestHelper(service, securityPacket, consumer_secret, requestPacket, null);
        String signedActivity = reqHelp.generateRequest();

%>


<div class="jumbotron">
    <h1>Items API – Assess</h1>
    <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.<p>
    <div class="row">
        <div class="col-md-10">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
            <!--
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#settings">
                <span class="glyphicon glyphicon-list-alt"></span> Customise API Settings
            </a></h4>
            <h4><a href="#" class="text-muted" data-toggle="modal" data-target="#initialisation-preview">
                <span class="glyphicon glyphicon-share-alt"></span> Preview API Initialisation Object
            </a></h4>
            -->
        </div>
        <div class="col-md-2"><p class='text-right'><a class="btn btn-primary btn-lg" href="itemsapi_inline.jsp">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<!-- Container for the items api to load into -->
<span id="learnosity_assess"></span>
<script src="http://items.learnosity.com"></script>
<script>
    var activity =<%out.print(signedActivity); %>;
    LearnosityItems.init(activity);
</script>
<jsp:include page= '../../includes/footer.jsp' />