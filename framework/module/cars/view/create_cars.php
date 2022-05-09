<div id="one">
    <form autocomplete="on" method="post" name="alta_cars" id="alta_cars">
        <h1 data-tr="coche nuevo">Coche nuevo</h1>
        <table border='0'>
            <tr>
                <td data-tr="Modelo">Modelo: </td>
                <td><input type="text" id="modelo" name="modelo" placeholder="''seat''" value=""/></td>
                <td><font color="red">
                    <span id="error_modelo" class="error">
                        <?php
                        if (isset($error_modelo)) {
                            echo $error_modelo;
                        }
                        ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td data-tr="Marca">Marca: </td>
                <td><input type="text" id="marca" name="marca" placeholder="''leon''" value=""/></td>
                <td><font color="red">
                    <span id="error_marca" class="error">
                        <?php
                        if (isset($error_marca)) {
                            echo $error_marca;
                        }                        ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td data-tr="Matricula">Matricula: </td>
                <td><input type="text" id="matricula" name="matricula" placeholder="''0000BCD''" value=""/></td>
                <td><font color="red">
                    <span id="error_matricula" class="error">
                        <?php
                        if (isset($error_matricula)) {
                            echo $error_matricula;
                        }                        ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td data-tr="Km">km: </td>
                <td><input type="text" id= "km" name="km" placeholder="''23000''" value=""/></td>
                <td><font color="red">
                    <span id="error_km" class="error">
                        <?php
                        if (isset($error_km)) {
                            echo $error_km;
                        }                        ?>
                    </span>
                </font></font></td>
            </tr>

            <!-- <tr>
                <td data-tr="Estado">Estado: </td>
                <td><input type="radio" id="estado" name="estado" placeholder="estado" value="KM0"/>Diesel
                    <input type="radio" id="estado" name="estado" placeholder="estado" value="Seg_Mano"/>Gasolina
                    <input type="radio" id="estado" name="estado" placeholder="estado" value="Semi_Nuevo"/>Electrico
                    <input type="radio" id="estado" name="estado" placeholder="estado" value="Nuevo"/>Hibrido
                </td>
                <td><font color="red">
                    <span id="error_tipo" class="error">
                        <?php
                        if (isset($error_tipo)) {
                            echo $error_tipo;
                        }                             ?>
                    </span>
                </font></font></td>
            </tr> -->
            
            <tr>
                <td data-tr="Tipo">Tipo: </td>
                <td><input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Diesel"/>Diesel
                    <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Gasolina"/>Gasolina
                    <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Electrico"/>Electrico
                    <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Hibrido"/>Hibrido
                </td>
                <td><font color="red">
                    <span id="error_tipo" class="error">
                        <?php
                        if (isset($error_tipo)) {
                            echo $error_tipo;
                        }                             ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td>Color: </td>
                <td><input id="color" name="color" type="color"/></td>
               <!-- <td><input id="color" type="text" name="color" placeholder="''azul''" value=""/></td> -->
                <td><font color="red">
                    <span id="error_color" class="error">
                        <?php
                        if (isset($error_color)) {
                            echo $error_color;
                        }                             ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td data-tr="Puertas">Puertas: </td>
                <td><input type="text" id="puertas" name="puertas" placeholder="''4''" value=""/></td>
                <td><font color="red">
                    <span id="error_puertas" class="error">
                        <?php
                        if (isset($error_puertas)) {
                            echo $error_puertas;
                        }                             ?>
                    </span>
                </font></font></td>
                
            </tr>

            <tr>
                <td>Cv: </td>
                <td><input type="text" id="cv" name="cv" placeholder="''100''" value=""/></td>
                <td><font color="red">
                    <span id="error_cv" class="error">
                        <?php
                        if (isset($error_cv)) {
                            echo $error_cv;
                        }                             
                        ?>
                    </span>
                </font></font></td>
                
            </tr>

            <tr>
                <td data-tr="Fechamatr">Fecha de matriculacion: </td>
                <td><input type="datepicker" id="fecha" name="fecha" value="01/01/1980" min="01/01/1980" max="<?php echo date("d/m/Y");?>"/></td>
                <td><font color="red">
                    <span id="error_fecha" class="error">
                        <?php
                        if (isset($error_cv)) {
                            echo $error_cv;
                        }                             
                        ?>
                    </span>
                </font></font></td>
                
            </tr>
            
            <tr>
                <td><input type="button" name="create" id="create" value="Enviar" onclick="validate_create()"/></td>
                <td align="right"><a href="index.php?page=controller_cars&op=list">Volver</a></td>
            </tr>
        </table>
    </form>
</div>