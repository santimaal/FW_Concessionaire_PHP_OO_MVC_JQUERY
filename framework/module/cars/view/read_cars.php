<div id="contenido">
    <h1>Información del Coche</h1>
    <p>
    <table border='2'>
        <tr>
            <td>Modelo: </td>
            <td>
                <?php
                    echo $cars['modelo'];
                ?>
            </td>
        </tr>
    
        <tr>
            <td>Marca: </td>
            <td>
                <?php
                    echo $cars['marca'];
                ?>
            </td>
        </tr>
        
        <tr>
            <td>Matricula: </td>
            <td>
                <?php
                    echo $cars['matricula'];
                ?>
            </td>
        </tr>
        
        <tr>
            <td>km: </td>
            <td>
                <?php
                    echo $cars['km'];
                ?>
            </td>
        </tr>
        
        <tr>
            <td>Color: </td>
            <td>
                <input type=color value=<?php echo $cars['color']?> disabled/>
            </td>
        </tr>
        
        <tr>
            <td>Tipo:</td>
            <td>
                <?php
                    echo $cars['tipo'];
                ?>
            </td>
        </tr>
        
        <tr>
            <td>Puertas: </td>
            <td>
                <?php
                    echo $cars['puertas'];
                ?>
            </td>
            
        </tr>
        
        <tr>
            <td>cv: </td>
            <td>
                <?php
                    echo $cars['cv'];
                ?>
            </td>
        </tr>

        <tr>
            <td>Fecha matr: </td>
            <td>
                <?php
                    echo $cars['fecha_matr'];
                ?>
            </td>
        </tr>
    </table>
    </p>
    <p><a href="index.php?page=controller_cars&op=list">Volver</a></p>
</div>