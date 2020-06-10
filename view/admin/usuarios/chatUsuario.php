<body class="fondo11">
        <div id="listaMensajes">
            <?php foreach ($datos as $row){ ?>
                <?php if ($_SESSION["id_usuario"]==$row->deId ){?>
                    <div>
                        <p class="mensajeDelChat" style="background-color: #defcc5; float: right "><strong><?php echo $row->mensaje ?></strong><br><span class="horaChat"><?php echo $row->creado ?>    <i class="fas fa-check-double fa-xs" style="font-size: 0.75rem;"></i></span></p>
                    </div>
                    <br>
                    <br>
                    <br>
                <?php }else{?>
                    <div>
                        <p class="mensajeDelChat" style="background-color: #ffffff "><strong><?php echo $row->mensaje ?></strong><br><span class="horaChat"><?php echo $row->creado ?>    <i class="fas fa-check-double fa-xs" style="font-size: 0.75rem;"></i></span></p>
                    </div>
                <?php }?>
            <?php } ?>
        </div>

<!--        <div id="listaMensajes"></div>-->
        <form class="formChat" action="" method="POST" role="form">
            <input class="inputChat" type="text" id="mensaje" name="mensaje" autocomplete="off" autofocus placeholder="Escribir mensaje...">
            <input class="inputChat" type="submit" value="Enviar" name="enviar">
        </form>
</body>
