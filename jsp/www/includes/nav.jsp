<%@ page import="java.util.LinkedHashMap" %>


<%
    LinkedHashMap<String, Object> menu = new LinkedHashMap();
    LinkedHashMap<String, String> assessment = new LinkedHashMap();
    //, authoring = new LinkedHashMap(), reporting = new LinkedHashMap(), misc = new LinkedHashMap();
    //assessment.put("/assessment/questions/.jsp", "Questions API");
    assessment.put(request.getContextPath() + "/assessment/items/index.jsp", "Items API");
    //assessment.put("/assessment/assess/index.jsp", "Assess API");

    //authoring.put("/authoring/author/index.jsp", "Author API");
    //authoring.put("/authoring/questioneditor/index.jsp", "Question Editor API");

    //reporting.put("/reporting/reports/index.jsp", "Reports API");
    //reporting.put("/reporting/sso/index.jsp", "Single Sign On API");

    //misc.put("/misc/security_check.jsp","Security Check");

    menu.put("Assessment", assessment);
    //menu.put("Authoring", authoring);
    //menu.put("Reporting", reporting);
    //menu.put("Misc", misc);


%>


<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand logo" href="/">Learnosity Demos</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <%

                    for (String header : menu.keySet()) {
                        out.println("<li class=\"dropdown\" id=\"" + header + "\">");
                        out.println("<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" + header + " <b class=\"caret\"></b></a>");
                        out.println("<ul class=\"dropdown-menu\">");
                        LinkedHashMap<String, String> menuElems = (LinkedHashMap<String, String>)menu.get(header);
                        for(String url : menuElems.keySet()) {
                            out.println("<li id=\""+ menuElems.get(url) +"\"><a href = \"" + url + "\">" + menuElems.get(url) + "</a></li>");
                        }
                        out.print("</ul>");
                        out.print("</li>");
                    }
                %>
            </ul>
            <div class="pull-right">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="https://github.com/Learnosity/learnosity-php-examples" class="text-muted">
                            <span class="glyphicon glyphicon-file"></span> View source
                        </a>
                    </li>
                    <li>
                        <a href="https://github.com/Learnosity/learnosity-php-examples/archive/master.zip" class="text-muted">
                            <span class="glyphicon glyphicon-cloud-download"></span> Download
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
