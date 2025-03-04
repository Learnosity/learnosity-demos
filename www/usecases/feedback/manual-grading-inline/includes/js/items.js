(()=>{
    const itemsScript = document.querySelector('#items-script');
    const itemData = JSON.parse(itemsScript.getAttribute('data-parameters'));
    const callback = {
        readyListener: function () {
            window.itemsApp = itemsApp;
            const sessionId = itemData?.request?.session_id || '';
            const activityId =  itemData?.request?.activity_id || '';
            //add to history to support back button and show in resume mode
            history.pushState({}, '', window.location.pathname + `?session_id=${sessionId}&activity_id=${activityId}`);
        },
        errorListener: function (err) {
            console.log('Error on loading the itemsApp: ', err);
        }
    }

    const signedRequest =  JSON.parse(itemsScript.getAttribute('data-parameters'));
    const itemsApp = LearnosityItems.init(signedRequest, callback);
})()
