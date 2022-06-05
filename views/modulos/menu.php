<aside class="main-sidebar">
	 <section class="sidebar">
		<ul class="sidebar-menu">

		<?php
		$modulo_usuario = ModeloUsuarios::MdlMostrarModulo_Usuarios($_SESSION["id"]);	
		

          foreach ($modulo_usuario as $key => $value) {
			
			if ($value["cmenu"]==1)
				{
						$menu_usuario = ModeloUsuarios::MdlMostrarMenu_Usuarios($_SESSION["id"],$value["cmodulo"]);	
						foreach ($menu_usuario as $key1 => $value1) 
						{
							echo 
								'<li>
									<a href="'.$value1["link"].'">
										<i class="'.$value1["icono_clase"].'"></i>
										<span>'.$value1["menu"].'</span>
									</a>
								</li>';		
						}  

				 }

			else  {
					$menu_usuario1 = ModeloUsuarios::MdlMostrarMenu_Usuarios($_SESSION["id"],$value["cmodulo"]);	
					echo '<li class="treeview">
								<a href="#">
									<i class="fa fa-list-ul"></i>
									<span>'.$value["modulo"].'</span>
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>';
					echo '<ul class="treeview-menu">';
						foreach ($menu_usuario1 as $key2 => $value2) 
						{
							echo 
										'<li>
											<a href="'.$value2["link"].'">										
												<i class="'.$value2["icono_clase"].'"></i>
												<span>'.$value2["menu"].'</span>
											</a>
										</li>';

						}
					echo '</ul>
						  </li>';          	
         }
     }

		?>

		</ul>

	 </section>

</aside>