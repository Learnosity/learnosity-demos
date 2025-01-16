(()=>{
    const itemsScript = document.querySelector('#items-script');
    const callback = {
        readyListener: function () {
            window.itemsApp = itemsApp;
            //add to history to support back button and show in resume mode
            history.pushState({}, '', window.location.pathname + '?session_id=<?php echo $session_id; ?>&activity_id=<?php echo $activity_id; ?>');
        },
        errorListener: function (err) {
            console.log('Error on loading the itemsApp: ', err);
        }
    }

    const signedRequest =  JSON.parse(itemsScript.getAttribute('data-parameters'));
    const itemsApp = LearnosityItems.init(signedRequest, callback);
})()
