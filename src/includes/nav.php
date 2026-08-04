<?php
$pages = array(
    'Authoring' => array(
        'authoring/index.php' => 'Author'
    ),
    'Assessment' => array(
        'assessment/index.php' => 'Assessments'
    ),
    'Analytics' => array(
        'analytics/index.php' => 'Analytics'
    ),
    'Use Cases' => array(
        'usecases/index.php' => 'Use Cases'
    ),
    'Partners' => array(
        'partners/index.php' => 'Partners'
    )
);

$url = 'https://github.com/Learnosity/learnosity-demos/blob/master/www' . $_SERVER['REQUEST_URI'];

if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
    $url = explode('?', $url)[0];
}
$santized_url = filter_var($url, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$hasViewSource = !str_starts_with($_SERVER['REQUEST_URI'], '/showcase');
?>

<header class="navbar navbar-expand-lg" role="navigation">
    <div class="container">
        <a href="/" class="logo">
            <img src="/static/images/lrn-demos-logo-2x.png" alt="Learnosity Demos" class="logo">
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav-main"
                aria-controls="nav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav-main">
            <ul class="navbar-nav">
                <?php
                foreach ($pages as $page => $name) {
                    if (sizeof($name) > 1) {
                        echo '
                                        <li class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle bottom-chevron" data-bs-toggle="dropdown" role="button" aria-expanded="false">' . $page . '</a>
                                            <ul class="dropdown-menu">';
                        foreach ($name as $subpage => $subname) {
                            echo '<li><a href="/' . $subpage . '" class="dropdown-item">' . $subname . '</a></li>' . PHP_EOL;
                        }
                        echo '
                                            </ul>
                                        </li>' . PHP_EOL;
                    } else {
                        foreach ($name as $key => $value) {
                            echo '<li class="nav-item"><a href="/' . $key . '" class="nav-link">' . $value . '</a></li>';
                        }
                    }
                }
                ?>
            </ul>
            <?php if ($hasViewSource): ?>
                <div class="nav-sec-wrapper">
                    <ul class="navbar-nav nav-sec">
                        <li class="nav-item"><a href="<?php echo $santized_url; ?>" class="view_source"><span>View source</span></a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
