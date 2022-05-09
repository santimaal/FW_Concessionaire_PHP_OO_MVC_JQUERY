<div id="contenido">
    <form autocomplete="on" method="post" name="update_cars" id="update_cars">
        <h1>Modificar coche</h1>
        <table border='0'>
            <tr>
                <td>Modelo: </td>
                <td><input type="text" id="modelo" name="modelo" placeholder="modelo" value="<?php echo $cars['modelo'];?>" readonly/></td>
                <td><font color="red">
                    <span id="error_modelo" class="error">
                        <?php
                        if (isset($error_modelo)) {
                            echo $error_modelo;
                        }                           ?>
                    </span>
                </font></font></td>
            </tr>
        
            <tr>
                <td>Marca: </td>
                <td><input type="marca" id="marca" name="marca" placeholder="marca" value="<?php echo $cars['marca'];?>" readonly/></td>
                <td><font color="red">
                    <span id="error_marca" class="error">
                        <?php
                        if (isset($error_marca)) {
                            echo $error_marca;
                        }                           ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td>Matricula: </td>
                <td><input type="text" id="matricula" name="matricula" placeholder="matricula" value="<?php echo $cars['matricula'];?>" readonly/></td>
                <td><font color="red">
                    <span id="error_matricula" class="error">
                        <?php
                        if (isset($error_matricula)) {
                            echo $error_matricula;
                        }                           ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td>km: </td>
                <td><input type="text" id= "km" name="km" placeholder="km" value="<?php echo $cars['km'];?>"/></td>
                <td><font color="red">
                    <span id="error_km" class="error">
                        <?php
                        if (isset($error_km)) {
                            echo $error_km;
                        }                           ?>
                    </span>
                </font></font></td>
            </tr>

            <tr>
                <td>Color: </td>
                <td><input type="color" id= "color" name="color" placeholder="color" value="<?php echo $cars['color'];?>"/></td>
                <td><font color="red">
                    <span id="error_color" class="error">
                        <?php
                        if (isset($error_color)) {
                            echo $error_color;
                        }                           ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td>Tipo: </td>
                <td>
                    <?php
                        if ($cars['tipo']==="Diesel"){
                    ?>
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Diesel" checked/>Diesel
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Gasolina"/>Gasolina
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Electrico"/>Electrico
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Hibrido"/>Hibrido
                    <?php    
                        }elseif ($cars['tipo']==="Gasolina") {
                    ?>
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Diesel"/>Diesel
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Gasolina" checked/>Gasolina
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Electrico"/>Electrico
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Hibrido"/>Hibrido
                    <?php   
                        }elseif ($cars['tipo']==="Electrico") { 
                    ?>                        
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Diesel"/>Diesel
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Gasolina" />Gasolina
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Electrico" checked/>Electrico
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Hibrido"/>Hibrido
                    <?php
                        }else  {
                    ?>
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Diesel"/>Diesel
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Gasolina" />Gasolina
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Electrico"/>Electrico
                        <input type="radio" id="tipo" name="tipo" placeholder="tipo" value="Hibrido" checked/>Hibrido
                    <?php   
                        } 
                    ?> 




                </td>
                <td><font color="red">
                    <span id="error_tipo" class="error">
                        <?php
                        if (isset($error_tipo)) {
                            echo $error_tipo;
                        }                           ?>
                    </span>
                </font></font></td>
            </tr>
            
            <tr>
                <td>Puertas: </td>
                <td><input type="text" id= "puertas" name="puertas" placeholder="puertas" value="<?php echo $cars['puertas'];?>"/></td>
                <td><font color="red">
                    <span id="error_puertas" class="error">
                        <?php
                        if (isset($error_puertas)) {
                            echo $error_puertas;
                        }                           ?>
                    </span>
                </font></font></td>
            </tr>

            <td>Cv: </td>
                <td><input type="text" id= "cv" name="cv" placeholder="cv" value="<?php echo $cars['cv'];?>"/></td>
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
                <td>Fecha de matriculacion: </td>
                <td><input type="datepicker" id="fecha" name="fecha" value="<?php echo $cars['fecha_matr'];?>" min="01/01/1980" max="<?php echo date("d/m/Y");?>"/></td>
                <td><font color="red">
                    <span id="error_fecha" class="error">
                        <?php
                        if (isset($error_fecha)) {
                            echo $error_fecha;
                        }                             
                        ?>
                    </span>
                </font></font></td>
                
            </tr>
            <?php echo $cars['fecha_matr'] ?>
            <tr>
                <td><input type="button" name="update" id="update" value="Enviar" onclick="validate_update()"/></td>
                <td align="right"><a href="index.php?page=controller_cars&op=list">Volver</a></td>
            </tr>
        </table>
    </form>
</div>