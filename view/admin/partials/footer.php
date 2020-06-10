<?php if (isset($_SESSION['usuario'])){ ?>
    <footer class="footer page-footer font-small blue" style="background-color:#343a40">

        <div class="footer-copyright text-center py-3 text-secondary">© 2020 Copyright:
            <a href="#" class="text-white"> Alberto Pérez Regalado</a>
            <!--    VENTANA DE AYUDA Y SOBRE LA APP-->
            <div class="float-right ayuda">
                <a href="<?php echo $_SESSION['home'] ?>admin/usuarios/ayuda" title="Ayuda">
                    <i class="far fa-question-circle fa-2x text-white iconoAyuda"></i>
                 </a>
            </div>
        </div>

    </footer>
<?php } ?>

</body>
    <!--JS-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="<?php echo $_SESSION['public'] ?>js/admin.js"></script>
    <!--<script src="--><?php //echo $_SESSION['public'] ?><!--js/app.js"></script>-->

</html>