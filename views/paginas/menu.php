<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!--=====================================
  LOGO
  ======================================-->
  <a href="inicio" class="brand-link">
      <img src="views/img/plantilla/icono.jpg" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?php echo TITULO; ?></span>
  </a>

  <!--=====================================
  MENÚ
  ======================================-->

  <div class="sidebar sperfil" perfil= <?php echo funciones::var_encripta($_SESSION["idusuario"]) ; ?> >
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

  <?php
    $menu_usuario = ModeloUsuarios::MdlMostrarModulo_Usuarios($_SESSION["idperfil"]);
    //var_dump( $modulo_usuario);

    // for - primer nivel
    foreach ($menu_usuario as $key => $value)
    {
        // Primer nivel
        // Se evalua si no tiene hijos predecesoras
        if ($value["hijos"]==0)
        {
                echo '<li class="nav-item">
                        <a href="'.$value["link"].'" class="nav-link menu '.$value["link"].'">
                          <i class="'.$value["icono_clase"].' nav-icon"></i>
                          <p>'.$value["menu"].'</p>
                        </a>
                      </li>';
        }
        else {
                // Se prepara el inicio del arbol para segundo nivel
                echo '<li class="nav-item has-treeview">
                        <a href="#" class="nav-link menu '.$value["link"].'">
                          <i class="'.$value["icono_clase"].' nav-icon"></i>
                            <p>'.$value["menu"].'<i class="right fas fa-angle-left"></i> </p>
                        </a>';
                echo    '<ul class="nav nav-treeview">';
                 // Segundo nivel
                // Se evalua si no tiene hijos predecesoras
                $menu_usuario2 = ModeloUsuarios::MdlMostrarMenu_Usuarios($_SESSION["idperfil"],$value["idmenu"]);

                // for - segundo nivel
                foreach ($menu_usuario2 as $key2 => $value2)
                {
                     // Se evalua si no tiene hijos predecesoras
                    if ($value2["hijos"]==0)
                    {
                        echo
                          '<li class="nav-item">
                            <a href="'.$value2["link"].'" class="nav-link menu '.$value2["link"].'">
                              <i class="'.$value2["icono_clase"].' nav-icon"></i>
                              <p>'.$value2["menu"].'</p>
                            </a>
                          </li>';
                    }
                    else
                    {
                          // Se prepara el inicio del arbol para el tercer nivel
                          echo '<li class="nav-item has-treeview">
                                  <a href="#" class="nav-link menu '.$value2["link"].'">
                                    <i class="'.$value2["icono_clase"].' nav-icon"></i>
                                      <p>'.$value2["menu"].'<i class="right fas fa-angle-left"></i> </p>
                                  </a>';
                          echo     '<ul class="nav nav-treeview" >';

                          // Tercer nivel
                          $menu_usuario3 = ModeloUsuarios::MdlMostrarMenu_Usuarios($_SESSION["idperfil"],$value2["idmenu"]); 

                          // for - tercer nivel
                          foreach ($menu_usuario3 as $key3 => $value3) 
                          {
                              echo
                                '<li class="nav-item">
                                  <a href="'.$value3["link"].'" class="nav-link menu '.$value3["link"].'">
                                    <i class="'.$value3["icono_clase"].' nav-icon"></i>
                                    <p>'.$value3["menu"].'</p>
                                  </a>
                                </li>';
                          } // for - end tercer nivel
                              echo '</ul>
                                </li>';
                    }
                } // for - end segundo nivel

                echo '</ul>
                </li>';


        }


    } // for - end primer nivel
  ?>

      </ul>
    </nav>
  </div>
</aside>