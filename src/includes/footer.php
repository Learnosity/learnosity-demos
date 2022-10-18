    </div>
</div>
<div class="footer" role="contentinfo">
    <div class="section">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <a href="/">
                    <img src="/static/images/lrn-demos-logo-white-2x.png" alt="Learnosity Demos" class="logo">
                </a>
            </div>
            <div class="col-lg-9 col-md-12 footer-links">
                <a href="https://support.learnosity.com/hc/en-us">Developer Help</a>
                <a href="https://authorguide.learnosity.com/hc/en-us">Author Guide</a>
                <a href="https://reference.learnosity.com">API Reference</a>
                <a href="https://status.learnosity.com">API Status</a>
                <a href="https://learnosity.com">Visit Learnosity</a>
                <?php
                if ($_SERVER['REQUEST_URI'] == "/")
                {
                    echo '<a href="/?resetConsent=true">Reset Cookies</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
