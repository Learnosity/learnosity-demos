
( () => {

    const gradingInlineApp = () => {

        return {
            items: [],
            sessionId: '',
            studentId: '',
            graderId: '',
            activityId: '',
            readonly: false,
            wrapper: null,
            // Maps item_reference -> response_id (populated from GET scores)
            responseIdMap: {},
            _uiReady: false,

            redirect(url) {
                const { sessionId, studentId, items, graderId, activityId } = this;
                setTimeout(() => {
                    const urlParams = new URLSearchParams({
                        session_id: sessionId,
                        grader_id: graderId,
                        student_id: studentId,
                        activity_id: activityId,
                        items: items.toString()
                    });
                    window.location.href = `${url}?${urlParams.toString()}`;
                }, 1000);
            },

            buildScorePanel(itemRef, maxScore) {
                const max = maxScore ?? '';
                const maxLabel = max !== '' ? `${max} pts` : '— pts';
                const isReadonly = this.readonly;

                const panel = document.createElement('div');
                panel.className = 'col-md-5 mg-score-panel';
                panel.setAttribute('data-item-ref', itemRef);
                panel.innerHTML = `
                    <div class="lrn-mg-score-feedback">
                        <div class="lrn-mg-score-feedback-card lds-card">
                            <div class="lds-card-body">
                                <form novalidate="" class="">
                                    <div class="lrn-mg-score-input-group">
                                        <div class="lrn-mg-score-control">
                                            <label ${!isReadonly ? 'required=""' : ''} class="lds-form-label col-form-label col-form-label-sm lds-col">Score${!isReadonly ? '<span class="lrn-mg-score-required">*</span>' : ''}</label>
                                            <input min="0" ${max !== '' ? `max="${max}"` : ''} ${!isReadonly ? 'required=""' : ''}
                                                   aria-readonly="${isReadonly}" aria-disabled="false" aria-label="Score"
                                                   ${isReadonly ? 'readonly' : ''}
                                                   type="text" class="lrn-mg-score-input lds-form-control" value="">
                                        </div>
                                        <div class="lrn-mg-score-control">
                                            <label class="lrn-mg-no-label lds-form-label col-form-label col-form-label-sm lds-col"></label>
                                            <small class="lrn-mg-max-score-sep lds-form-text"> / </small>
                                        </div>
                                        <div class="lrn-mg-score-control">
                                            <label class="lrn-mg-no-label lds-form-label col-form-label col-form-label-sm lds-col"></label>
                                            <div class="lrn-mg-max-score-form">
                                                <small class="lrn-mg-max-score-label lds-form-text">${maxLabel}</small>
                                                ${!isReadonly ? `<div class="lrn-mg-max-score-button-wrapper">
                                                    <button type="button" aria-readonly="false" aria-disabled="false"
                                                            aria-label="Edit maximum points"
                                                            class="lrn-mg-max-score-button lds-btn lds-btn-ghost-secondary lds-btn-sm">
                                                        <svg class="lds-icon lds-icon--small" aria-hidden="true" focusable="false">
                                                            <use class="lds-icon-i" xlink:href="#pencil"></use>
                                                        </svg>
                                                    </button>
                                                    <span class="mg-tooltip" aria-hidden="true">Edit maximum points</span>
                                                </div>` : ''}
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Score cannot be empty</div>
                                    </div>
                                    <div class="lrn-mg-feedback-toggle">
                                        <button type="button" aria-expanded="true" tabindex="0"
                                                class="lrn-mg-feedback-toggle-btn lds-btn lds-btn-outline-secondary lds-btn-sm">
                                            <span class="lrn-mg-feedback-label">Grader feedback</span>
                                            <svg class="lds-icon lds-icon--small" aria-hidden="true" focusable="false">
                                                <use class="lds-icon-i" xlink:href="#carat-up"></use>
                                            </svg>
                                        </button>
                                        <div class="lrn-mg-feedback-content">
                                            <div>
                                                <textarea aria-readonly="${isReadonly}" aria-disabled="false" aria-label="Feedback"
                                                          ${isReadonly ? 'readonly' : ''}
                                                          class="lrn-mg-feedback-input lds-form-control"
                                                          maxlength="1000"></textarea>
                                                <div class="lrn-mg-character-count-container">
                                                    <small class="lrn-mg-character-count lds-form-text">0/1000 character limit</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    ${!isReadonly ? '<div class="mg-panel-footnote">This will be updated via Data API</div>' : ''}`;

                // Character counter
                const textarea = panel.querySelector('.lrn-mg-feedback-input');
                const counter  = panel.querySelector('.lrn-mg-character-count');
                textarea.addEventListener('input', () => {
                    counter.textContent = `${textarea.value.length}/1000 character limit`;
                });

                // Score input — single listener for real-time validation
                const scoreInput      = panel.querySelector('.lrn-mg-score-input');
                const invalidFeedback = panel.querySelector('.invalid-feedback');
                const scoreInputGroup = panel.querySelector('.lrn-mg-score-input-group');
                scoreInput.addEventListener('input', () => {
                    const val = scoreInput.value.trim();
                    // Read max from label text — single source of truth for both
                    // auto-scored (max attr set) and manual grading questions (label only)
                    const maxLabelTxt = panel.querySelector('.lrn-mg-max-score-label')?.textContent?.replace(' pts', '').trim();
                    const maxVal = (maxLabelTxt && maxLabelTxt !== '—' && !isNaN(Number(maxLabelTxt)))
                        ? Number(maxLabelTxt)
                        : null;

                    if (val === '') {
                        scoreInput.classList.add('is-invalid');
                        scoreInputGroup.classList.add('has-error');
                        invalidFeedback.textContent = 'Score cannot be empty';
                        invalidFeedback.style.display = 'block';
                    } else if (maxVal !== null && Number(val) > maxVal) {
                        scoreInput.classList.add('is-invalid');
                        scoreInputGroup.classList.add('has-error');
                        invalidFeedback.textContent = 'Score cannot exceed the maximum points';
                        invalidFeedback.style.display = 'block';
                    } else if (Number(val) < 0) {
                        scoreInput.classList.add('is-invalid');
                        scoreInputGroup.classList.add('has-error');
                        invalidFeedback.textContent = 'Score cannot be negative';
                        invalidFeedback.style.display = 'block';
                    } else {
                        scoreInput.classList.remove('is-invalid');
                        scoreInputGroup.classList.remove('has-error');
                        invalidFeedback.style.display = 'none';
                    }
                });

                // Feedback toggle (collapse / expand)
                const toggleBtn     = panel.querySelector('.lrn-mg-feedback-toggle-btn');
                const feedbackArea  = panel.querySelector('.lrn-mg-feedback-content');
                toggleBtn.addEventListener('click', () => {
                    const expanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                    toggleBtn.setAttribute('aria-expanded', String(!expanded));
                    feedbackArea.style.display = expanded ? 'none' : '';
                    const use = toggleBtn.querySelector('.lds-icon-i');
                    use.setAttribute('xlink:href', expanded ? '#carat-down' : '#carat-up');
                });

                // Edit max score inline — replaces label with input field
                // Uses event delegation so it works after DOM replacement
                panel.addEventListener('click', (e) => {
                    const btn = e.target.closest('.lrn-mg-max-score-button');
                    if (!btn) return;

                    const scoreControl = btn.closest('.lrn-mg-score-control');
                    const label = scoreControl.querySelector('.lrn-mg-max-score-label');
                    const current = label ? label.textContent.replace(' pts', '').trim() : '';
                    const currentVal = current === '—' ? '' : current;

                    // Replace with editable input
                    scoreControl.innerHTML = `
                        <label class="lds-form-label col-form-label col-form-label-sm lds-col" required="">Maximum points<span class="lrn-mg-score-required">*</span></label>
                        <input min="0" required="" aria-readonly="false" aria-disabled="false"
                               aria-label="Maximum points" type="text"
                               class="lrn-mg-max-score-input lds-form-control" value="${currentVal}">
                    `;

                    const maxInput = scoreControl.querySelector('.lrn-mg-max-score-input');
                    maxInput.focus();
                    maxInput.select();

                    const applyValue = () => {
                        const val = maxInput.value.trim();
                        const n = Number(val);

                        // Helper: show error without shifting layout (absolutely positioned)
                        const showMaxError = (msg) => {
                            maxInput.classList.add('is-invalid');
                            let errEl = scoreControl.querySelector('.mg-max-invalid-feedback');
                            if (!errEl) {
                                errEl = document.createElement('div');
                                errEl.className = 'mg-max-invalid-feedback';
                                errEl.style.cssText = 'color:#dd002f;font-size:12px;position:absolute;top:100%;left:0;white-space:nowrap;z-index:1;';
                                scoreControl.appendChild(errEl);
                            }
                            errEl.textContent = msg;
                        };

                        // Validation: Maximum points cannot be empty
                        if (val === '') {
                            showMaxError('Maximum points cannot be empty');
                            return; // Don't revert — keep input visible
                        }

                        // Validation: must be a valid positive number
                        if (isNaN(n) || n < 0) {
                            showMaxError('Maximum points must be a valid number');
                            return;
                        }

                        // Valid — apply and revert to label view
                        const newLabel = `${n} pts`;
                        scoreInput.setAttribute('max', String(n));

                        scoreControl.innerHTML = `
                            <label class="lrn-mg-no-label lds-form-label col-form-label col-form-label-sm lds-col"></label>
                            <div class="lrn-mg-max-score-form">
                                <small class="lrn-mg-max-score-label lds-form-text">${newLabel}</small>
                                <div class="lrn-mg-max-score-button-wrapper">
                                    <button type="button" aria-readonly="false" aria-disabled="false"
                                            aria-label="Edit maximum points" title="Edit maximum points"
                                            class="lrn-mg-max-score-button lds-btn lds-btn-ghost-secondary lds-btn-sm">
                                        <svg class="lds-icon lds-icon--small" aria-hidden="true" focusable="false">
                                            <use class="lds-icon-i" xlink:href="#pencil"></use>
                                        </svg>
                                    </button>
                                    <span class="mg-tooltip" aria-hidden="true">Edit maximum points</span>
                                </div>
                            </div>
                        `;

                        // Re-validate score against new max
                        const scoreVal = scoreInput.value.trim();
                        if (scoreVal !== '' && Number(scoreVal) > n) {
                            scoreInput.classList.add('is-invalid');
                            const group = scoreInput.closest('.lrn-mg-score-input-group');
                            if (group) group.classList.add('has-error');
                            const fb = group?.querySelector('.invalid-feedback');
                            if (fb) {
                                fb.textContent = 'Score cannot exceed the maximum points';
                                fb.style.display = 'block';
                            }
                        }
                    };

                    // Clear error on input
                    maxInput.addEventListener('input', () => {
                        maxInput.classList.remove('is-invalid');
                        const errEl = scoreControl.querySelector('.mg-max-invalid-feedback');
                        if (errEl) errEl.remove();
                    });

                    maxInput.addEventListener('blur', applyValue);
                    maxInput.addEventListener('keydown', (ev) => {
                        if (ev.key === 'Enter') { ev.preventDefault(); maxInput.blur(); }
                    });
                });

                return panel;
            },

            /**
             * Build one row per item and inject the learnosity-item span (needed
             * before LearnosityItems.init so the Items API can find the hooks).
             */
            buildItemRows() {
                this.items.forEach((itemRef) => {
                    const row = document.createElement('div');
                    row.className = 'row lrn-item-row';

                    if (itemRef === this.item2Ref) {
                        // Item 2: Grading API owns the full row (question + scoring panel)
                        const hook = document.createElement('div');
                        hook.className = 'lrn-mg-item-hook';
                        hook.setAttribute('data-item-ref', itemRef);
                        row.appendChild(hook);
                    } else {
                        // Items 1 & 3: Items API hook (left) + custom score/FA panel (right)
                        const itemCol = document.createElement('div');
                        itemCol.className = 'col-md-7';
                        const itemSpan = document.createElement('span');
                        itemSpan.className = 'learnosity-item';
                        itemSpan.setAttribute('data-reference', itemRef);
                        itemCol.appendChild(itemSpan);
                        row.appendChild(itemCol);

                        const panel = this.buildScorePanel(itemRef);
                        row.appendChild(panel);
                    }

                    this.wrapper.appendChild(row);

                    // Divider (hidden after last item via CSS)
                    const hr = document.createElement('div');
                    hr.className = 'hr-border';
                    this.wrapper.appendChild(hr);
                });
            },

            /**
             * Validate all visible (non-disabled) score panels.
             * Adds .is-invalid / .has-error for red-border + error message display.
             * Returns true if all panels pass, false if any fail.
             */
            validatePanels() {
                let valid = true;

                document.querySelectorAll('.mg-score-panel').forEach(panel => {
                    const scoreInput = panel.querySelector('.lrn-mg-score-input');
                    const group      = panel.querySelector('.lrn-mg-score-input-group');
                    const errorMsg   = panel.querySelector('.invalid-feedback');

                    // Skip read-only / FA-managed panels
                    if (!scoreInput || scoreInput.disabled) return;

                    const raw = scoreInput.value.trim();
                    const val = Number(raw);

                    // Resolve max score from the label text (mirrors what save() does).
                    // Manual grading questions have no validation.max_score so the `max`
                    // attribute is never set — the label is the single source of truth.
                    const maxLabel    = panel.querySelector('.lrn-mg-max-score-label');
                    const maxLabelTxt = maxLabel?.textContent?.replace(' pts', '').trim();
                    const maxScore    = (maxLabelTxt && maxLabelTxt !== '—' && !isNaN(Number(maxLabelTxt)))
                        ? Number(maxLabelTxt)
                        : null;

                    const setError = (msg) => {
                        scoreInput.classList.add('is-invalid');
                        if (group)    group.classList.add('has-error');
                        if (errorMsg) errorMsg.textContent = msg;
                        valid = false;
                    };

                    const clearError = () => {
                        scoreInput.classList.remove('is-invalid');
                        if (group) group.classList.remove('has-error');
                    };

                    if (raw === '') {
                        setError('Score is required');
                    } else if (isNaN(val)) {
                        setError('Score must be a valid number');
                    } else if (val < 0) {
                        setError('Score cannot be negative');
                    } else if (maxScore !== null && val > maxScore) {
                        setError(`Score cannot exceed the maximum points`);
                    } else {
                        clearError();
                    }
                });

                return valid;
            },

            async save() {
                // Validate before doing anything — bail early so button stays enabled
                if (!this.validatePanels()) return;

                const nextButton = document.querySelector('.mg-grading-next-btn');
                const spinner   = document.querySelector('.btn-spinner');
                nextButton.disabled = true;
                spinner.style.display = 'inline-block';

                try {
                    // 1. Save Grading API item (item 2)
                    if (window.gradingApp) {
                        const gradingResult = await window.gradingApp.save();
                        console.log('Grading API PUT result ::', gradingResult);
                    }

                    // 2. Save Feedback Aide sessions (if any)
                    if (this.feedbackApp && this.faItems && Object.keys(this.faItems).length > 0) {
                        await this.feedbackApp.save({ ready_for_review: true });
                    }

                    // 3. Collect scores from non-FA, non-Grading-API panels
                    const responses = [];
                    document.querySelectorAll('.mg-score-panel').forEach(panel => {
                        const itemRef       = panel.getAttribute('data-item-ref');
                        const scoreInput    = panel.querySelector('.lrn-mg-score-input');
                        const maxScoreLabel = panel.querySelector('.lrn-mg-max-score-label');
                        const score    = scoreInput?.value ?? '';

                        if (score !== '') {
                            const responseId = this.responseIdMap[itemRef] || itemRef;
                            const entry = {
                                item_reference: itemRef,
                                response_id: responseId,
                                score: Number(score),
                            };

                            const maxText = maxScoreLabel?.textContent?.replace(' pts', '').trim();
                            if (maxText && maxText !== '—' && !isNaN(Number(maxText))) {
                                entry.max_score = Number(maxText);
                            }

                            responses.push(entry);
                        }
                    });

                    // 4. Persist non-FA scores via Data API grading endpoint
                    if (responses.length > 0) {
                        const itemsPayload = responses.map(r => ({
                            item_reference: r.item_reference || r.response_id,
                            responses: [{
                                response_id: r.response_id,
                                scores: [{
                                    grader_id: this.graderId,
                                    score: r.score,
                                    ...(r.max_score != null ? { max_score: r.max_score } : {})
                                }]
                            }]
                        }));

                        await this.persistGrades({
                            session_id: this.sessionId,
                            user_id: this.studentId,
                            items: itemsPayload
                        });
                    }

                    // 4. Persist grader feedback via /sessions/responses/feedback
                    const feedbackItems = [];
                    document.querySelectorAll('.mg-score-panel').forEach(panel => {
                        const itemRef = panel.getAttribute('data-item-ref');
                        const feedbackInput = panel.querySelector('.lrn-mg-feedback-input');
                        const feedbackText = feedbackInput?.value?.trim() || '';
                        if (feedbackText) {
                            const responseId = this.responseIdMap[itemRef] || itemRef;
                            feedbackItems.push({
                                item_reference: itemRef,
                                responses: [{
                                    response_id: responseId,
                                    feedback: [{
                                        grader_id: this.graderId,
                                        content: feedbackText,
                                        rendering_format: 'plaintext_inline'
                                    }]
                                }]
                            });
                        }
                    });

                    if (feedbackItems.length > 0) {
                        try {
                            await this.persistFeedback(feedbackItems);
                        } catch (fbErr) {
                            console.warn('🔔 feedback save failed (non-blocking)', fbErr);
                        }
                    }

                    this.redirect('report.php');
                } catch (err) {
                    console.error('🔔 save error', err);
                    nextButton.removeAttribute('disabled');
                    spinner.style.display = 'none';
                }
            },

            async persistGrades(request) {
                const body = new URLSearchParams({
                    action:  'update',
                    request: JSON.stringify(request)
                });
                const res = await fetch('includes/endpoint.php', {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body
                });
                if (!res.ok) throw new Error(`HTTP error: ${res.status}`);
                const result = await res.json();
                console.log('Data API grading PUT result ::', result);
                return result;
            },

            /**
             * Fetch existing grader feedback from /sessions/responses/feedback
             */
            async fetchExistingFeedback() {
                const body = new URLSearchParams({
                    action:  'get',
                    request: JSON.stringify({ session_id: this.sessionId })
                });
                try {
                    const res = await fetch('includes/feedback-endpoint.php', {
                        method:  'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body
                    });
                    if (res.ok) {
                        const data = await res.json();
                        console.log('Data API feedback GET result ::', data);
                        // Response: { data: [{ session_id, items: [{ item_reference, responses: [{ response_id, graders: [{ grader_id, content }] }] }] }] }
                        const sessions = data?.data || [];
                        const session = sessions[0];
                        if (!session || !session.items) return {};

                        const feedbackMap = {}; // item_reference -> feedback content
                        session.items.forEach(item => {
                            if (item.responses) {
                                item.responses.forEach(resp => {
                                    const graders = resp.graders || [];
                                    const latest = graders.length > 0 ? graders[graders.length - 1] : null;
                                    if (latest && latest.content) {
                                        feedbackMap[item.item_reference] = latest.content;
                                    }
                                });
                            }
                        });
                        return feedbackMap;
                    }
                } catch (e) {
                    console.warn('Failed to fetch existing feedback', e);
                }
                return {};
            },

            /**
             * Populate feedback textareas from fetched data
             */
            populateFeedback(feedbackMap) {
                Object.entries(feedbackMap).forEach(([itemRef, content]) => {
                    const panel = document.querySelector(`.mg-score-panel[data-item-ref="${itemRef}"]`);
                    if (!panel) return;
                    const feedbackInput = panel.querySelector('.lrn-mg-feedback-input');
                    const counter = panel.querySelector('.lrn-mg-character-count');
                    if (feedbackInput) {
                        feedbackInput.value = content;
                        if (counter) counter.textContent = `${content.length}/1000 character limit`;
                    }
                });
            },

            /**
             * Persist grader feedback via /sessions/responses/feedback (update action)
             */
            async persistFeedback(feedbackItems) {
                const request = {
                    session_id: this.sessionId,
                    items: feedbackItems
                };
                const body = new URLSearchParams({
                    action:  'update',
                    request: JSON.stringify(request)
                });
                const res = await fetch('includes/feedback-endpoint.php', {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body
                });
                if (!res.ok) throw new Error(`HTTP error (feedback): ${res.status}`);
                const result = await res.json();
                console.log('Data API feedback PUT result ::', result);
                return result;
            },

            async fetchExistingScores() {
                const body = new URLSearchParams({
                    action:  'get',
                    request: JSON.stringify({ session_id: this.sessionId })
                });
                try {
                    const res = await fetch('includes/endpoint.php', {
                        method:  'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body
                    });
                    if (res.ok) {
                        const data = await res.json();
                        console.log('Data API grading GET result ::', data);

                        // The grading endpoint returns:
                        // { data: [{ session_id, items: [{ item_reference, responses: [{ response_id, graders: [{ grader_id, score, max_score }] }] }] }] }
                        // data can be an array (list of sessions) or an object with items directly
                        let items = [];

                        if (Array.isArray(data?.data)) {
                            // data is an array of session objects
                            const session = data.data.find(s => s.session_id === this.sessionId) || data.data[0];
                            items = session?.items || [];
                        } else if (data?.data?.items) {
                            // data is a single object with items
                            items = data.data.items;
                        }

                        const result = [];

                        items.forEach(item => {
                            const itemRef = item.item_reference;
                            if (item.responses && item.responses.length > 0) {
                                item.responses.forEach(resp => {
                                    // Store the response_id mapping
                                    if (itemRef && resp.response_id) {
                                        this.responseIdMap[itemRef] = resp.response_id;
                                    }

                                    // Scores can be in 'graders' array or 'scores' array
                                    const graders = resp.graders || resp.scores || [];
                                    const latestGrader = graders.length > 0
                                        ? graders[graders.length - 1]
                                        : null;

                                    // Use grader score if available, otherwise use auto-score
                                    const score = latestGrader?.score ?? resp.auto_score ?? resp.score ?? null;
                                    const maxScore = latestGrader?.max_score ?? resp.auto_max_score ?? resp.max_score ?? null;

                                    result.push({
                                        item_reference: itemRef,
                                        response_id: resp.response_id,
                                        score: score,
                                        max_score: maxScore,
                                        feedback: latestGrader?.feedback || '',
                                    });
                                });
                            }
                        });

                        return result;
                    }
                } catch (e) {
                    console.error('Failed to fetch existing scores', e);
                }
                return [];
            },

            populateScores(scores) {
                scores.forEach(s => {
                    // Match panel by item_reference (primary) or response_id (fallback)
                    let panel = null;
                    if (s.item_reference) {
                        panel = document.querySelector(`.mg-score-panel[data-item-ref="${s.item_reference}"]`);
                    }
                    if (!panel && s.response_id) {
                        // Try matching by response_id in case item_reference isn't present
                        panel = document.querySelector(`.mg-score-panel[data-item-ref="${s.response_id}"]`);
                    }
                    if (!panel) return;

                    const scoreInput    = panel.querySelector('.lrn-mg-score-input');
                    const feedbackInput = panel.querySelector('.lrn-mg-feedback-input');
                    const counter       = panel.querySelector('.lrn-mg-character-count');
                    const maxScoreLabel = panel.querySelector('.lrn-mg-max-score-label');

                    // Populate score
                    if (scoreInput && s.score != null) {
                        scoreInput.value = s.score;
                    }

                    // Populate max_score
                    if (maxScoreLabel && s.max_score != null) {
                        maxScoreLabel.textContent = `${s.max_score} pts`;
                        if (scoreInput) scoreInput.setAttribute('max', String(s.max_score));
                    }

                    // Populate feedback
                    if (feedbackInput) {
                        feedbackInput.value = s.feedback || '';
                        if (counter) counter.textContent = `${feedbackInput.value.length}/1000 character limit`;
                    }

                    if (this.readonly) {
                        if (scoreInput)    scoreInput.setAttribute('readonly', '');
                        if (feedbackInput) feedbackInput.setAttribute('readonly', '');
                    }
                });
            },

            async init(config, wrapper) {
                const { activity, gradingActivity, items, item2Ref, sessionId, studentId, graderId, activityId, readonly } = config;
                this.wrapper          = wrapper;
                this.items            = items;
                this.item2Ref         = item2Ref;       // item rendered by Grading API
                this.gradingActivity  = gradingActivity; // Grading API signed request
                this.sessionId        = sessionId;
                this.studentId        = studentId;
                this.graderId         = graderId;
                this.activityId       = activityId;
                this.readonly         = readonly ?? false;

                // 1. Stamp item hooks into the DOM before Items API init
                this.buildItemRows();

                // 2. Start Grading API init early (doesn't depend on Items API)
                this._gradingApiPromise = this.initGradingApi().catch(e => {
                    console.warn('Grading API initialization failed', e);
                });

                // 3. Initialise Items API (inline mode finds the spans we just created)
                const itemsApp = LearnosityItems.init(activity, {
                    readyListener: async () => {
                        console.log('🔔 Items API ready!');
                        window.itemsApp = itemsApp;
                        await this.onItemsReady(itemsApp);
                    },
                    errorListener: (errors) => {
                        console.error('🔔 Items API error', errors);
                        // Even on error, try to enable the UI since items may have partially loaded
                        this.onItemsReady(itemsApp);
                    }
                });

                // Fallback: if readyListener doesn't fire within 5 seconds, enable UI anyway
                setTimeout(() => {
                    if (!window.itemsApp) {
                        console.log('🔔 Items API readyListener timeout — enabling UI via fallback');
                        window.itemsApp = itemsApp;
                        this.onItemsReady(itemsApp);
                    }
                }, 5000);
            },

            async onItemsReady(itemsApp) {
                // Prevent double execution
                if (this._uiReady) return;
                this._uiReady = true;

                // 3. Extract response_ids and max_scores from Items API
                try {
                    const itemsData = itemsApp?.getItems?.();
                    if (itemsData) {
                        Object.keys(itemsData).forEach(ref => {
                            const item = itemsData[ref];
                            if (item.response_ids && item.response_ids.length > 0) {
                                this.responseIdMap[ref] = item.response_ids[0];
                            }
                            // Populate max_score from question validation if available
                            if (item.questions) {
                                item.questions.forEach(q => {
                                    const maxScore = q.validation?.max_score;
                                    if (maxScore != null) {
                                        const panel = document.querySelector(`.mg-score-panel[data-item-ref="${ref}"]`);
                                        if (panel) {
                                            const maxLabel = panel.querySelector('.lrn-mg-max-score-label');
                                            const scoreInput = panel.querySelector('.lrn-mg-score-input');
                                            if (maxLabel && maxLabel.textContent.includes('—')) {
                                                maxLabel.textContent = `${maxScore} pts`;
                                                if (scoreInput) scoreInput.setAttribute('max', String(maxScore));
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                } catch (e) {
                    console.warn('Could not extract response_ids from Items API', e);
                }

                // 4. Fetch scores and feedback in parallel, and wait for Grading API
                const [scores, feedbackMap] = await Promise.all([
                    this.fetchExistingScores().catch(e => { console.warn('Could not fetch existing scores', e); return []; }),
                    this.fetchExistingFeedback().catch(e => { console.warn('Could not fetch existing feedback', e); return {}; }),
                    this._gradingApiPromise,  // already started in init(), just await completion
                ]);

                if (scores.length > 0) this.populateScores(scores);
                if (Object.keys(feedbackMap).length > 0) this.populateFeedback(feedbackMap);

                // 5. Initialize Feedback Aide for questions with rubrics
                try {
                    await this.initFeedbackAide(itemsApp);
                } catch (e) {
                    console.warn('Feedback Aide initialization failed', e);
                }

                // 6. Enable save button (grading step only)
                if (!this.readonly) {
                    const nextButton = document.querySelector('.mg-grading-next-btn');
                    if (nextButton) {
                        nextButton.removeAttribute('disabled');
                        nextButton.addEventListener('click', this.save.bind(this));
                    }
                }
            },

            /**
             * Generate a deterministic UUID from a string input.
             * Creates a proper UUID v5-like value using a simple but effective hash.
             */
            generateUUIDFromString(input) {
                // Use a proper string hash that produces good distribution
                const bytes = new Uint8Array(16);
                for (let i = 0; i < input.length; i++) {
                    const charCode = input.charCodeAt(i);
                    for (let j = 0; j < 16; j++) {
                        bytes[j] = (bytes[j] + charCode * (i + j + 1)) & 0xff;
                    }
                }
                // Set version to 5 (bits 4-7 of byte 6)
                bytes[6] = (bytes[6] & 0x0f) | 0x50;
                // Set variant to RFC4122 (bits 6-7 of byte 8)
                bytes[8] = (bytes[8] & 0x3f) | 0x80;

                const hex = Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
                return `${hex.slice(0,8)}-${hex.slice(8,12)}-${hex.slice(12,16)}-${hex.slice(16,20)}-${hex.slice(20,32)}`;
            },

            /**
             * Request a Feedback Aide security token from the server.
             */
            async loadFAToken(sessionUUID, permission = 'RW', state = 'grade') {
                const res = await fetch('includes/fa-token.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        session_uuid: sessionUUID,
                        permission,
                        state,
                    })
                });
                if (!res.ok) throw new Error(`FA token error: ${res.status}`);
                const data = await res.json();
                if (data.error) throw new Error(data.error);
                return data;
            },

            /**
             * Initialize the Grading API for item 2 (manual grading).
             * The Grading API renders the student's response and scoring panel itself.
             */
            async initGradingApi() {
                if (!this.gradingActivity || !this.item2Ref) return;
                if (typeof LearnosityGrading === 'undefined') return;

                const hookEl = document.querySelector(`.lrn-mg-item-hook[data-item-ref="${this.item2Ref}"]`);
                if (!hookEl) return;

                // Grading API requires these attributes on the hook element before attachItem
                hookEl.setAttribute('session-id',     this.sessionId);
                hookEl.setAttribute('user-id',        this.studentId);
                hookEl.setAttribute('item-reference', this.item2Ref);

                const app = await LearnosityGrading.init(this.gradingActivity);
                window.gradingApp = app;
                console.log('Grading API GET result ::', app);

                const attached = await app.attachItem({
                    sessionId: this.sessionId,
                    userId:    this.studentId,
                    item:      this.item2Ref
                }, hookEl);
                console.log('Grading API attachItem result ::', attached);

                // Apply column layout (question left, score panel right)
                hookEl.querySelectorAll('[data-lrn-widget-type="question"]').forEach(el => el.classList.add('col-md-7'));
                hookEl.querySelectorAll('[data-lrn-widget-type="mg-score-feedback"]').forEach(el => el.classList.add('col-md-5'));

                // Append footnote inside the Grading API hook (step 2 only)
                if (!this.readonly) {
                    const footnote = document.createElement('p');
                    footnote.className = 'mg-panel-footnote';
                    footnote.textContent = 'This will be updated via Grading API';
                    hookEl.appendChild(footnote);
                }
            },

            /**
             * Initialize Feedback Aide for questions that have a rubric.
             * Hides the custom score panel for those items and attaches FA UI instead.
             */
            async initFeedbackAide(itemsApp) {
                if (typeof LearnosityFeedbackAide === 'undefined') {
                    console.log('LearnosityFeedbackAide not available, skipping FA init');
                    return;
                }

                const feedbackApp = await LearnosityFeedbackAide.init();
                this.feedbackApp = feedbackApp;

                const itemsData = itemsApp?.getItems?.();
                if (!itemsData) return;

                const state = this.readonly ? 'review' : 'grade';
                const questionsApp = itemsApp.questionsApp?.();

                for (const itemRef of this.items) {
                    const item = itemsData[itemRef];
                    if (!item || !item.questions) continue;

                    for (const question of item.questions) {
                        // Check if the question has a rubric (in validation.rubric or metadata.rubric)
                        const rubric = question.validation?.rubric || question.metadata?.rubric;
                        if (!rubric) continue;

                        const responseId = question.response_id;
                        if (!responseId) continue;

                        // Hide the custom score panel for this item
                        const panel = document.querySelector(`.mg-score-panel[data-item-ref="${itemRef}"]`);
                        const panelRow = panel?.parentElement;
                        if (panel) panel.remove();

                        // Mark this item as FA-scored
                        this.faItems = this.faItems || {};
                        this.faItems[itemRef] = responseId;

                        // Get the student's response
                        let responseValue = '';
                        try {
                            const qApp = questionsApp?.question?.(responseId);
                            const resp = qApp?.getResponse?.();
                            responseValue = resp?.value || '';
                        } catch (e) {
                            console.warn('Could not get response for', responseId, e);
                        }

                        // Create FA session container
                        const sessionContainer = document.createElement('div');
                        sessionContainer.className = 'col-md-5 lrn-fa';
                        sessionContainer.setAttribute('data-feedback-session-item', responseId);

                        // Insert it in the same row as the question (where the panel was)
                        if (panelRow) {
                            panelRow.appendChild(sessionContainer);
                        } else {
                            // Fallback: find the row by item reference
                            const fallbackRow = document.querySelector(`.lrn-item-row:has([data-reference="${itemRef}"])`);
                            if (fallbackRow) {
                                fallbackRow.appendChild(sessionContainer);
                            } else {
                                const questionEl = document.querySelector(`[id="${responseId}"]`);
                                if (questionEl) questionEl.parentElement.appendChild(sessionContainer);
                            }
                        }

                        // Create FA session
                        try {
                            const sessionUUID = this.generateUUIDFromString(responseId);
                            const tokenData = await this.loadFAToken(sessionUUID, 'RW', state);
                            const feedbackSession = await feedbackApp.feedbackSession(tokenData, {
                                state,
                                session_uuid: sessionUUID,
                                stimulus: question.stimulus || '',
                                response: responseValue,
                                rubric: rubric,
                                sources: question.metadata?.sources || undefined,
                            });
                            const ui = await feedbackSession.createUI({
                                modules: {
                                    response: false,
                                    stimulus: false,
                                    submit: false,
                                    satisfaction: false
                                }
                            });
                            await ui.attach(sessionContainer);

                            // Generate feedback (grade mode) or load existing (review mode)
                            if (state === 'grade') {
                                try {
                                    await ui.generateFeedback({ model: 'advanced-shortresponse' });
                                } catch (genErr) {
                                    console.warn('Feedback Aide generateFeedback failed (non-blocking)', genErr);
                                }
                            }

                            // Hide FA's built-in "Submit scores" button and "How did we do?" elements
                            // Footnote is also appended here (after FA DOM settles) so FA render can't overwrite it
                            setTimeout(() => {
                                const container = sessionContainer;
                                // Strategy: find the submit button (already works), then hide its grandparent
                                // which wraps both "How did we do?" and "Submit scores"
                                container.querySelectorAll('button').forEach(btn => {
                                    const text = btn.textContent.trim().toLowerCase();
                                    if (text.includes('submit scores') || text.includes('submitted scores')) {
                                        // btn > span > div._lrn-fa__jz4Ws > div._lrn-fa__vJgAF
                                        const topWrapper = btn.parentElement?.parentElement?.parentElement;
                                        if (topWrapper && topWrapper !== container) {
                                            topWrapper.style.setProperty('display', 'none', 'important');
                                        }
                                    }
                                });

                                // Append footnote inside sessionContainer — grading step only (step 2)
                                if (!this.readonly && !container.querySelector('.mg-panel-footnote')) {
                                    const footnote = document.createElement('div');
                                    footnote.className = 'mg-panel-footnote mg-fa-footnote';
                                    footnote.textContent = 'This will be updated via Feedback Aide';
                                    container.appendChild(footnote);
                                }
                            }, 1000);
                        } catch (e) {
                            console.error('FA session creation failed for', responseId, e);
                            // Remove the FA container on failure
                            sessionContainer.remove();
                            delete this.faItems[itemRef];
                        }
                    }
                }
            },
        };
    };


    /**
     * Grading App initialization
     */

    const gradingInlineScript = document.querySelector('#grading-inline-script');
    const wrapper = document.querySelector('#inline-items-wrapper');

    if (gradingInlineScript) {
        window.__gradingConfig = JSON.parse(gradingInlineScript.getAttribute('data-parameters'));
        const gradingAppInstance = gradingInlineApp();
        gradingAppInstance.init(window.__gradingConfig, wrapper);
        window.gradingInlineApp = gradingAppInstance;
    }

})();
