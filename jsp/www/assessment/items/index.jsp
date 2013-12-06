
<jsp:include page= '../../includes/header.jsp' />



<div class="jumbotron">
    <h1>Items API</h1>
    <p>
        Learnosity's <b>Items API</b> provides a simple way to access content from the Learnosity item bank to pull in activities and assessments from the author site’s data store that can be embedded in your pages.</p>
    <div class="row">
        <div class="col-md-8">
            <h4><a href="http://docs.learnosity.com/itemsapi/" class="text-muted">
                <span class="glyphicon glyphicon-book"></span> Documentation
            </a></h4>
        </div>
        <div class="col-md-4"><p class='text-right'><a class="btn btn-primary btn-lg" href="../assess/index.jsp">Next <span class="glyphicon glyphicon-chevron-right"></span></a></p></div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Items API Demos</h2>
            <p>Try one of the Demos below.</p></br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Items API - Assess</h2>
                </div>
                <div class="panel-body">
                    <p>With the flick of a switch make the items into an assessment. Truly write once - use anywhere.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./itemsapi_assess.jsp">Demo</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Items API - Inline</h2>
                </div>
                <div class="panel-body">
                    <p>Display items from the Learnosity Item Bank in no time with the Items API. The Items API builds on the Questions API's power and makes it quicker to integrate.</p>
                    <p class="text-right">
                        <a class="btn btn-primary btn-md" href="./itemsapi_inline.jsp">Demo</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<jsp:include page= '../../includes/footer.jsp' />
