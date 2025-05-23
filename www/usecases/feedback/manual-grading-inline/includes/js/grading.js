
( () => {

    const EVENT_NAMES = {
        saveStart: 'save:start',
        saveComplete: 'save:complete',
        saveError: 'save:error',
        saveFieldError: 'save:fields:error',
        attachItemStart: 'attachitem:start',
        attachItemComplete: 'attachitem:complete',
        attachItemError: 'attachitem:error',
        detachItemStart: 'detachitem:start',
        detachItemComplete: 'detachitem:complete',
        detachItemError: 'detachitem:error',
        resetStart: 'reset:start',
        resetComplete: 'reset:complete',
        resetError: 'reset:error',
        error: 'error',
        ready: 'ready',
    };

    const EVENTS = Object.keys(EVENT_NAMES);

    const GradingApi = {

        initApi(activity, readyListener, errorListener) {

            LearnosityGrading.init(activity)
                .then((app) => {
                    window.gradingApp = app;
                    readyListener();
                })
                .catch((error) => {
                    errorListener(error);
                });
        },

        attachItem(
            sessionId,
            userId,
            item,
            wrapper) {
            const hookElement = document.createElement('DIV');
            const payload = {
                sessionId,
                userId,
                item
            };

            hookElement.setAttribute('session-id', sessionId);
            hookElement.setAttribute('user-id', userId);
            hookElement.setAttribute('item-reference', item);
            hookElement.className = `lrn-mg-item-hook`;
            wrapper.appendChild(hookElement);

            return window.gradingApp.attachItem(payload, hookElement)
        },

        detachItem(sessionId, userId, item) {
            const payload = {
                sessionId,
                userId,
                item
            };

            return window.gradingApp.detachItem(payload);
        },

        reset() {
            return window.gradingApp.reset();
        },

        save() {
            return window.gradingApp.save();
        },

        setAllEventListeners() {
            EVENTS.forEach( (eventName) => {
                window.gradingApp.on(EVENT_NAMES[eventName], (data) => {
                    console.log(`📌 Grading-API event :: ${eventName} [${JSON.stringify(data)}]`);
                })
            });
        },

        // ideally the save should return the error for dirty fields or save error
        // this is a workaround to get the error from the save event

        setSaveListener() {
            window.gradingApp.on(EVENT_NAMES.saveFieldError, (data) => {
                console.log('🔔 Grading-API Save Field Error:: ', data);
            })
            window.gradingApp.on(EVENT_NAMES.saveError, (data) => {
                console.log('🔔 Grading-API Save Error:: ', data);
            })
        }
    }


    const gradingInlineApp = () => {

        const getItemElement = (sessions, payload) => {
            const { sessionId, userId, item } = payload;

            return sessions.reduce( (prev, acc) => {
                if(prev) {
                    return prev;
                }
                const foundItem = sessions.find((session) => {
                    return session.sessionId === sessionId
                        && session.userId === userId
                })?.items.find(i => i.reference === item);

                return foundItem?.element;
            }, null);
        };

        const getItems = (sessions, payload) => {
            const { sessionId, userId } = payload;

            return sessions.find(session => {
                return session.sessionId === sessionId
                    && session.userId === userId
            })?.items || [];
        };


        return {
            items: [],
            sessionId: '',
            studentId: '',
            graderId: '',
            wrapper: null,

            async redirect(url) {
                const { sessionId, studentId, items, graderId } = this;

                // set a delay to transition to the next page smoothly
                setTimeout(() => {
                    const urlParams = new URLSearchParams({
                        session_id: sessionId,
                        grader_id: graderId,
                        student_id: studentId,
                        items: items.toString()
                    });

                    window.location.href = `${url}?${urlParams.toString()}`;
                }, 1000);
            },

            async save() {
                let isSuccessful = false;
                const nextButton = document.querySelector('.mg-grading-next-btn');
                const spinner = document.querySelector('.btn-spinner');

                nextButton.disabled = true;
                spinner.style.display = 'inline-block';

                await GradingApi.save()
                    .then((savedItems) => {
                        console.log('save :: ', savedItems);

                        isSuccessful = savedItems && savedItems.some(
                            (savedItem) =>
                                savedItem?.updated_scores?.length > 0
                        );
                    }).catch( (error) => {
                        console.error('🔔 save error ', error);
                        isSuccessful = false
                    });

                if (isSuccessful) {
                    this.redirect('report.php');
                } else {
                    nextButton.removeAttribute('disabled');
                    spinner.style.display = 'none';
                }
            },

            async renderItems() {
                let ctr = 0;
                const { items, sessionId, studentId: userId, wrapper } = this;

                while( ctr < items.length ) {
                    const itemRef = items[ctr];

                    await GradingApi.attachItem(sessionId, userId, itemRef, wrapper)
                        .then(async (attachedItems) => {
                            await this.attachItemSuccess(attachedItems, itemRef);
                            ctr++;
                            return attachedItems;
                        }).catch( (error) => {
                            console.error(`attach item error userId : ${userId} : sessionId ${sessionId} : itemRef ${itemRef}`, error);
                            ctr++;
                        });
                }
                this.setUiReady();
                console.log('🔔 renderItems done!');
            },


            setLayout(element) {
                const mgScoreFeedbackElements = element.querySelectorAll(`[data-lrn-widget-type='mg-score-feedback']`);
                const questionElements = element.querySelectorAll(`[data-lrn-widget-type='question']`);

                mgScoreFeedbackElements.forEach((hook) => {
                    hook.classList.add('col-md-5');
                });
                questionElements.forEach((hook) => {
                    hook.classList.add('col-md-7');
                    // hook.parentElement.classList.add("row");
                });
            },

            attachItemSuccess(attachedItems, item) {
                const { sessionId, studentId: userId } = this;
                const payload = { sessionId, userId , item };
                const element = getItemElement(attachedItems, payload);

                console.log('🔔 Grading-API Attached Item:: ', attachedItems);

                if (element) {
                    const dataRef = element.querySelector(`[data-reference="${item}"]`);
                    // item title
                    const header = document.createElement('DIV');

                    const itemsCount = getItems(attachedItems, payload)?.length;
                    header.innerHTML = `<h3 class="lrn-report-item-title">Item ${itemsCount}</h3>`;
                    element.insertBefore(header, dataRef);

                    const hr = document.createElement('DIV');
                    hr.className = 'hr-border'
                    dataRef.append(hr);

                    this.setLayout(element);

                    return Promise.resolve(element);
                }

            },

            setUiReady() {
                // submit button
                const nextButton = document.querySelector('.mg-grading-next-btn');
                if (nextButton) {
                    nextButton.removeAttribute('disabled');
                    nextButton.addEventListener('click', this.save.bind(this));
                }
            },


            readyListener() {
                console.log("🔔 api is ready!");

                GradingApi.setSaveListener();

                // render
                if (this.items?.length) {
                    this.renderItems();
                }

            },

            errorListener(error) {
                console.error(`🔔 #App Error ${error}`);
            },

            init(config, wrapper) {
                const { activity, items, sessionId, studentId, graderId } = config;
                this.wrapper = wrapper;
                this.items = items;
                this.sessionId = sessionId;
                this.studentId = studentId;
                this.graderId = graderId;

                // initiate the app
                GradingApi.initApi(activity, this.readyListener.bind(this), this.errorListener.bind(this));
            },
        }
    }


    /**
     * Grading App initialization
     */

    const gradingInlineScript = document.querySelector('#grading-inline-script');
    const wrapper = document.querySelector('#inline-items-wrapper');

    if (gradingInlineScript) {
        // set a global copy of config and gradingInlineApp for reference
        window.__gradingConfig = JSON.parse(gradingInlineScript.getAttribute('data-parameters'));
        const gradingAppInstance = gradingInlineApp();

        // init the gradingApp
        gradingAppInstance.init(window.__gradingConfig, wrapper);
        window.gradingInlineApp = gradingAppInstance;
    }

})();
