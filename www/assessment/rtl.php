<?php

//common environment attributes including search paths. not specific to Learnosity
include_once '../env_config.php';

//site scaffolding
include_once 'includes/header.php';

//common Learnosity config elements including API version control vars
include_once '../lrn_config.php';

use LearnositySdk\Request\Init;
use LearnositySdk\Utils\Uuid;

$security = [
    'consumer_key' => $consumer_key,
    'domain'       => $domain
];


//simple api request object for Items API
$request = [
    'activity_id' => 'rtldemo',
    'name' => 'Learnosity Right to Left Demo',
    'rendering_type' => 'assess',
    'type' => 'submit_practice',
    'session_id' => Uuid::generate(),
    'user_id' => '$ANONYMIZED_USER_ID',
    'items' => [
        'ARABIC_Demo9',
        'salim-arabic-mcq-2',
        'ar-drawing-rtl'
    ],
    'config' => [
        'regions' => 'main',
        'navigation' => [
            'show_intro' => true,
            "show_outro" => false,
            "skip_submit_confirmation" => false,
            "show_acknowledgements" => false
        ],
        'labelBundle' => [
            'actionsave' => 'حفظ',
            'actionsubmit' => 'محاولة',
            'acknowledgement' => 'امتنان',
            'allQuestionsAttempted' => 'تمت محاولة جميع الأسئلة' ,
            'apply' => 'تطبيق',
            'assessmentTimeExpired' => 'لقد انتهى وقت التقويم الخاص بك ويطلب منك الإرسال الآن.',
            'assetUploadError' => 'خطأ في تحميل الاستجابة' ,
            'assetUploadRetry' => 'حاول ثانية',
            'assetUploadErrorDetail' => 'تعذر تحميل واحد أو أكثر من اجاباتك.',
            'assetUploadErrorRetryDetail' => 'يرجي التحقق من اتصال الشبكة والمحاولة مرة أخرى.' ,
            'assetUploadErrorDeclineDetail' => 'إذا اخترت الإلغاء , فستفقد الاستجابات التي لم يتم تحميلها وسيتم وضع علامة عليها كغير خالية.',
            'confirm' => 'موافق',
            'continue' => 'استمر/تابع',
            'close' => 'غلق',
            'decline' => 'إلغاء',
            'elapsedTime' => 'الوقت المنقضي',
            'allowedTime' => 'الوقت المسموح به' ,
            'countDownRemainingTime' => 'الوقت المتبقي هو' ,
            'timeNearlyExpired' => 'اوشك وقت التقويم علي الانتهاء.' ,
            'remainingReadingTime' => 'وقت القراءة {{وقت القراءة}} ',
            'remainingReadingTimeWarning' => 'وقت القراءة {{وقت القراءة}} المتبقي!' ,
            'error' => 'خطأ',
            'fullScreen' => 'شاشة كاملة',
            'calculator' => 'آلة حاسبة',
            'accessibility' => 'إمكانية الوصول',
            'answerMasking' => 'إخفاء الاجابة' ,
            'configuration' => 'ضوابط الإدارة' ,
            'goBack' => 'رجوع',
            'yes' => 'نعم',
            'no' => 'لا',
            'introItemMessage' => 'من فضلك انقر <b>ابدأ</b> عندما تكون مستعدًا لبدء النشاط. ',
            'invalidQuestionsMessage' => 'الأسئلة التالية ليست صالحة حاليًا. الرجاء اتبع الروابط للمراجعة' ,
            'reachedLastItem' => 'لقد وصلت إلى السؤال الأخير لهذا النشاط. سيتم تقديم النشاط الآن.',
            'idleSaveSuccess' => 'تم إنهاء جلستك بعد فترة من عدم النشاط وتم حفظ نشاطك.',
            'idleSaveError' => 'حدث خطأ أثناء حفظ نشاطك.',
            'idleWarningMsg' => 'اوشكت جلستك على الانتهاء. انقر\' نعم , اسمح لي بالاستمرار! \' للرجوع ومتابعة نشاطك , أو سنحفظ تقدمك الحالي ونخرج من النشاط. ',
            'idleHeadingMsg' => 'هل مازلت هناك؟',
            'idleCancelButton' => 'نعم , دعني استمر!' ,
            'idleQuitButton' => 'خروج',
            'warningOnChangeHeadingMsg' => 'السؤال غير مكتمل' ,
            'warningOnChangeBodyMsg' => 'بعض العناصر في السؤال الحالي لا تزال بدون اجابة. هل ترغب في الانتقال إلى سؤال آخر على أي حال؟' ,
            'warningOnChangeCancelButton' => 'إلغاء',
            'warningOnChangeContinueButton' => 'استمر',
            'fetchingErrorHeadingMsg' => 'خطأ في تحميل الأسئلة' ,
            'fetchingErrorBodyMsg' => 'حدث خطأ أثناء تحميل الأسئلة التالية.',
            'question' => 'سؤال',
            'loading' => 'جار التحميل',
            'nextButtonLabel' => 'التالى',
            'ruler' => 'مسطرة',
            'protractor' => 'منقلة',
            'imagetool' => 'أداة الصور' ,
            'menuRegionToggle' => 'قائمة',
            'menuRegionClose' => 'إغلاق القائمة' ,
            'pause' => 'توقف مؤقت',
            'resume' => 'استئنف',
            'play' => 'تشغيل',
            'previousButtonLabel' => 'السابق',
            'quit' => 'خروج',
            'retry' => 'إعادة المحاولة',
            'saveButtonLabel' => 'خروج',
            'save' => 'حفظ',
            'saveInProgress' => 'جاري الحفظ',
            'saveWarningMsg' => 'تم إيقاف نشاطك مؤقتًا بواسطة المسؤول وسيخرج منه' ,
            'saveError' => 'فشل عملية الحفظ.',
            'saving' => 'جار الحفظ',
            'saved' => 'تم الحفظ',
            'item' => 'سؤال',
            'page' => 'الصفحة',
            'startTest' => 'ابدأ',
            'submitWarningMsg' => 'تم إيقاف نشاطك مؤقتًا بواسطة المسؤول وسيخرج منه' ,
            'submitFailed' => 'تعذر حفظ نشاطك. يرجى التحقق من اتصال الشبكة والمحاولة مرة أخرى.',
            'submitFailedWithOnlyAccessRawDataOption' => 'إذا استمرت المشكلة , فحدد كل النص في المنطقة أدناه , وانسخها , واعرضها علي المسئول. يحتوي هذا النص على البيانات الكاملة لنشاطك واجاباتك.',
            'submitFailedWithOtherOptions' => 'إذا استمرت المشكلة , فاستخدم أحد الخيارات التالية للوصول إلى البيانات الكاملة لنشاطك وإجاباتك. ',
            'actionDownloadAsFile' => 'تنزيل كملف' ,
            'actionSendEmail' => 'إرسال كبريد إلكتروني' ,
            'actionAccessRawData' => 'عرض سلسلة مشفرة' ,
            'actionAccessRawDataDescription' => 'حدد كل النص في المنطقة أدناه , وانسخه , واعرضه علي المسئول.',
            'submit' => 'ارسال',
            'submitButtonLabel' => 'إنهاء',
            'submitCriteriaNotMet' => 'لم يتم استيفاء المعايير التالية للتقديم' ,
            'submitInProgress' => 'جاري الارسال...',
            'submitting' => 'جاري الارسال...',
            'submitComplete' => 'تم ارساله...',
            'test' => 'النشاط',
            'testPaused' => 'تم إيقاف النشاط مؤقتًا' ,
            'testPausedProctor' => 'تم إيقاف نشاطك مؤقتًا بواسطة المسؤول.',
            'timeoutMsg' => 'يرجى إعادة المحاولة أو الاتصال بالمسؤول.',
            'tryAgain' => 'اعد المحاولة',
            'unavailable' => 'غير متوفر',
            'flagItem' => 'تحديد العنصر' ,
            'unflagItem' => 'عدم تحديد العنصر' ,
            'errorOccurredWhile' => 'حدث خطأ أثناء',
            'contactAdministrator' => 'الرجاء الاتصال بالمسؤول الخاص بك.',
            'itemTryAgain' => 'اعد المحاولة',
            'regionHeaderTopLeft' => 'عنوان التقويم' ,
            'regionHeaderTopRight' => 'مؤقت التقويم والعد' ,
            'regionHeaderRight' => 'شريط قوائم التقويم' ,
            'regionHeaderBottomRight' => 'الانتقال داخل التقويم' ,
            'regionHeaderBottomLeft' => '',
            'regionHeaderBottom' => 'الانتقال داخل التقويم' ,
            'regionHeaderItems' => 'أسئلة التقويم' ,
            'regionHeaderMenu' => 'قائمة التقويم' ,
            'questionHeader' => 'أسئلة',
            'singleQuestionHeader' => '',
            'tocElementHelp' => 'جدول المحتويات. تنقل بين الأسئلة باستخدام مفتاحي الأسهم الأيسر والأيمن.',
            'itemNestedHelp' => 'هذا السؤال متداخل في الصفحة' ,
            'administrationPanel' => 'ضوابط الإدارة' ,
            'saveQuit' => 'حفظ &amp;؛ خروج' ,
            'submitQuit' => 'إرسال&amp; خروج' ,
            'exitDiscard' => 'تجاهل &amp; وخروج' ,
            'discardInProgress' => 'جار الخروج ...',
            'discardError' => 'فشل الخروج &amp;؛والتجاهل.',
            'discardWarningMsg' => 'تم إيقاف نشاطك مؤقتًا بواسطة المسؤول وسيخرج منه' ,
            'hour' => 'ساعة (ساعات)',
            'minute' => 'دقيقة (دقائق)',
            'seconds' => 'ثواني',
            'saveQuitConfirmationMsg' => 'هل أنت متأكد أنك تريد الحفظ & amp؛ الخروج من هذه الجلسة؟' ,
            'submitQuitConfirmationMsg' => 'هل أنت متأكد أنك تريد الإرسال & amp؛ الخروج من هذه الجلسة؟' ,
            'exitDiscardConfirmationMsg' => 'هل أنت متأكد أنك تريد تجاهل هذه الجلسة؟' ,
            'lockMsg' => 'لقد تجاوزت الحد المسموح به في محاولات كلمة المرور. وقت القفل هو' ,
            'password' => 'كلمه المرور',
            'wrongPasswordMsg' => 'كلمة المرور غير صحيحة. من فضلك حاول مرة اخري.',
            'proctorModalTitle' => 'تنشيط التحكم عن بعد' ,
            'accessibilityPanel' => 'خيارات الوصول',
            'colorScheme' => 'نظام الألوان',
            'fontSize' => 'حجم الخط',
            'zoom' => 'تكبير',
            'paletteInstructions' => 'تغيير الخلفية وألوان المقدمة من نشاطك.',
            'blackOnWhite' => 'أسود على أبيض (افتراضي)' ,
            'purpleOnGreen' => 'أرجواني على أخضر فاتح' ,
            'yellowOnBlue' => 'أصفر على ازرق غامق' ,
            'blackOnRose' => 'أسود على بنفسج' ,
            'greyOnGrey' => 'رمادي على رمادي فاتح' ,
            'whiteOnBlack' => 'أبيض على أسود' ,
            'customColorPalette' => 'مخطط مخصص' ,
            'fontSizeInstructions' => 'اضبط حجم الخطوط في نشاطك.',
            'small' => 'صغير',
            'normal' => 'عادي',
            'large' => 'كبير',
            'xlarge' => 'كبير جدا',
            'xxlarge' => 'ضخم',
            'zoomInstructions' => 'يمكنك التكبير والتصغير باستخدام اختصارات لوحة المفاتيح التالية=>',
            'command' => 'أمر',
            'control' => 'السيطرة',
            'zoomIn' => 'تكبير' ,
            'zoomOut' => 'تصغير',
            'returnZoom' => 'إعادة ضبط التكبير' ,
            'toZoomIn' => 'للتكبير , اضغط' ,
            'toZoomOut' => 'للتصغير , اضغط' ,
            'toReturnZoom' => 'إعادة ضبط مستوى التكبير بالضغط علي',
            'plus' => 'زائد' ,
            'minus' => 'ناقص',
            'zero' => 'صفر' ,
            'zoomInResult' => 'سيتم تكبير المتصفح بشكل متزايد في كل مرة تضغط فيها على مفتاح زائد (+).',
            'zoomOutResult' => 'سيتم تصغير المتصفح بشكل متزايد في كل مرة تضغط فيها على مفتاح الطرح (-).',
            'returnZoomResult' => 'سيعود المتصفح إلى المستوى الافتراضي له.',
            'collapseMenu' => 'طي القائمة',
            'itemCountOf' => 'من',
            'reviewScreen' => 'مراجعة',
            'reviewScreenFilters' => 'مرشح',
            'fullyAttempted' => 'محاولة كاملة' ,
            'partiallyAttempted' => 'محاولة جزئية' ,
            'notAttempted' => 'عدم المحاولة',
            'viewed' => 'معروض',
            'flagged' => 'محدد',
            'filterResults' => 'ترشيح النتائج',
            'timerHour' => 'ساعة',
            'timerHours' => 'ساعات',
            'timerMinute' => 'دقيقة',
            'timerMinutes' => 'دقائق',
            'timerSecond' => 'ثانية',
            'timerSeconds' => 'ثواني',
            'timerSeparator' => 'بعيدا عن',
            'submittingInProgress' => 'إرسال قيد التقدم' ,
            'savingInProgress' => 'حفظ قيد التقدم' ,
            'saveTestSuccessfully' => 'تم حفظ {{اختبارك}}.',
            'saveTestSuccessfullyPrompt' => 'هل ترغب في استئناف {{الاختبار}} , أو الخروج؟' ,
            'submitCriteriaLessThanRequiredAttemptedQuestionsWarning' => 'يُطلب منك محاولة {{عدد }}٪ من الأسئلة. يرجى المحاولة على الأقل {{عدد من الاسئلة الاضافية المطلوبة}} كأسئلة اضافية.',
            'submitCriteriaRequiredEnoughCorrectQuestionsWarning' => 'يُطلب منك الإجابة علي {{عدد}}٪ من الأسئلة بشكل صحيح. يرجى الإجابة على الأقل على {{عدد من الاسئلة الاضافية المطلوبة}} كأسئلة أخرى بشكل صحيح.',
            'submitActionConfirmation' => 'هل متأكد أنك تريد {{إجراء}} {{الاختبار}}؟' ,
            'submitWithUnattemptedQuestion' => '{{عددعدم محاولات الاجابة}} لم تتم المحاولة للاجابة علي السؤال.',
            'submitWithUnattemptedQuestions' => '{{عددعدم محاولات الاجابة}} لم تتم المحاولة للاجابة علي الاسئلة.',
            'submitFailedDownloadAsFile' => '(للنسخ الاحتياطي محليًا أو إرفاقه برسالة بريد إلكتروني) ',
            'submitFailedSendEmail' => '(يتطلب إعداد برنامج بريد للعميل على هذا الجهاز)' ,
            'isAllResponsesAttempted' => '{{allQuestionsAttempted}}.هل تريد {{إجراء}} {{الاختبار}} الآن؟ ',
            'copyToClipboard' => 'نسخ البيانات' ,
            'saveErrorTitle' => 'خطأ في حفظ النشاط' ,
            'existingResponsesTitle' => 'تم العثور على الردود الموجودة' ,
            'existingResponsesMessage' => 'يبدو أن هذا الاختبار قد تمت محاولته بالفعل. ربما تكون قد دخلت هنا باستخدام المتصفح الخاص بك\'s back button.',
            'existingResponsesDetail' => 'إذا كان الأمر كذلك , يرجي النقر على زر إعادة التوجيه في المتصفح للعودة إلى الصفحة السابقة',
            'addStickyNote' => 'أضافة ملحوظة ملصقة',
            'annotationsApiLabelBundle' => [],
            'drawingMode' => 'وضع الرسم',
            'expandMenu' => 'قائمة موسعة',
            'fewerTools' => 'ادوات اقل',
            'hideDrawings' => 'اخفاء الرسومات',
            'hideStickyNotes' => 'إخفاء ملاحظات ملصقة',
            'moreTools' => 'More tools',
            'notepad' => 'مفكرة',
            'showDrawings' => 'اظهار الرسومات',
            'showStickyNotes' => 'إظهار ملاحظات ملصقة',
            'stickynote' => 'ملاحظات ملصقة',
            'warningOnSectionChangeBodyMsg' => 'أنت على وشك الانتقال إلى قسم جديد ولن تتمكن من العودة. هل ترغب في الانتقال من هذا القسم على أي حال؟',
            'warningOnSectionChangeCancelButton' => 'الغاء',
            'warningOnSectionChangeContinueButton' => 'استمرار',
            'warningOnSectionChangeHeadingMsg' => 'تغييرقسم '
        ],
        'questions_api_init_options' => [
            'labelBundle' => [
                'drawing' => [
                    'toolbar' => [
                        'clear' => 'مسح',
                        'compass' => 'بوصلة',
                        'eraser' => 'ممحاة',
                        'redo' => 'إعادة',
                        'scribble' => 'خربشة',
                        'straightedge' => 'خط',
                        'undo' => 'تراجع'
                     ]
                ]
            ]
        ]
    ]
];

$Init = new Init('items', $security, $consumer_secret, $request);
$signedRequest = $Init->generate();

?>

    <div class="jumbotron section">
        <div class="toolbar">
            <ul class="list-inline">
                <li data-toggle="tooltip" data-original-title="Preview API Initialisation Object"><a href="#"  data-toggle="modal" data-target="#initialisation-preview"><span class="glyphicon glyphicon-search"></span></a></li>
                <li data-toggle="tooltip" data-original-title="Visit the documentation"><a href="https://support.learnosity.com/hc/en-us/categories/360000101737-Learnosity-Assessments" title="Documentation"><span class="glyphicon glyphicon-book"></span></a></li>
            </ul>
        </div>
        <div class="overview">
            <h2>Right-to-Left Language Support</h2>
            <p>This demo demonstrates the Learnosity approach to handling right-to-left languages. In this demo, everything is localised to Arabic using <a href="https://reference.learnosity.com/items-api/initialization#config.labelBundle">label bundles</a>.</p>
        </div>
    </div>

    <div class="section pad-sml">
        <!-- Container for the assess api to load into -->
        <div id="learnosity_assess"></div>
    </div>

    <script src="<?php echo $url_items; ?>" data-lrn-dir="rtl"></script>
    <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
        var callbacks = {
            readyListener: function () {
                console.log("Items API has successfully initialized.");
            },
            errorListener: function (err) {
                console.log(err);
            }
        };

        var itemsApp = LearnosityItems.init(initializationObject, callbacks);
    </script>

<?php
include_once 'views/modals/initialisation-preview.php';
include_once 'includes/footer.php';
