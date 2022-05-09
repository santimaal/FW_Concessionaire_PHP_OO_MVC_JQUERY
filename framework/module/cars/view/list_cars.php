<div id="contenido">
    <div class="container">
    	<div class="row">
    			<h3 data-tr="lista">LISTA DE COCHES</h3>
    	</div>
    	<div class="row">
    		<p>
                <a href="index.php?page=controller_cars&op=create"><img src="view/img/anadir.png"></a>
                <a href="index.php?page=controller_cars&op=dummies"><img src="view/img/anadir.png"></a>
                <a href="index.php?page=controller_cars&op=deleteall"><img src="view/img/deleteall.png"></a>

            </p>
    		
    		<table id="table_crud">
                <head>
                    <tr>
                        <td width=90 data-tr="Modelo"><b>Modelo</b></th>
                        <td width=90 data-tr="Marca"><b>Marca</b></th>
                        <td width=70 data-tr="Km"><b>km</b></th>
                        <th><b>cv</b></th>

                    </tr>
                </head>
                <body>
                <?php
                    if ($rdo->num_rows === 0){
                        echo '<tr>';
                        echo '<td align="center" data-tr="NO HAY NINGUN COCHE"  colspan="3">NO HAY NINGUN COCHE</td>';
                        echo '</tr>';
                    }else{
                        foreach ($rdo as $row) {
                       		echo '<tr>';
                    	   	echo '<td width=90>'. $row['modelo'] . '</td>';
                    	   	echo '<td width=90>'. $row['marca'] . '</td>';
                    	   	echo '<td width=70>'. $row['km'] . '</td>';
                            echo '<td>'. $row['cv'] . '</td>';
                        	//     echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';    
                            echo '<td width=450>';
                            echo '&nbsp;';
                            echo ("<div class='Button_blue' id='".$row['id']."'><a data-tr='read'>Read</a></div>");  //READ
                    	   	//echo '<a class="Button_blue" data-tr="read" href="index.php?page=controller_cars&op=read&id='.$row['id'].'">Read</a>';
                    	   	//echo '&nbsp;';
                    	   	echo '<a class="Button_green" data-tr="update" href="index.php?page=controller_cars&op=update&id='.$row['id'].'">Update</a>';
                    	   	echo '&nbsp;';
                    	   	echo '<a class="Button_red" data-tr="delete" href="index.php?page=controller_cars&op=delete&id='.$row['id'].'">Delete</a>';
                    	   	echo '</td>';
                    	   	echo '</tr>';
                        }
                    }
                ?>
                </body>
            </table>
    	</div>
    </div>
</div>
<section id="modalcontent">
    <div id="details_car" hidden>
    </div>
</section>