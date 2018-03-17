
        </div>
    </div>

    <footer>
        <p>Copyright <?php echo date("Y", time()); ?> ††† All Rights Reserved.</p>
    </footer>

    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/javascript/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/javascript/jquery-ui-1.12.1.min.js"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/javascript/RestClient.js"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Recipe/javascript/General.js"></script>

    </body>

</html>

<?php ob_end_flush(); ?>