    <?php $_SESSION[ 'ht_last_page' ] = get_permalink(get_queried_object());  ?>
    <?php wp_footer(); ?>
    <?php 
    if( function_exists('acf_add_options_page') ) {
        $script = get_field('ht_options_script_footer', 'option');
        if (!empty($script)) print $script;
    } ?>
    <?php
      if(!empty($_SESSION["ht-success"]))
      {
        ?>
        <script type="text/javascript">
        Swal.fire(
          'Tudo certo!',
          '<?php print $_SESSION["ht-success"]; ?>',
          'success'
        )
        </script>
        <?php

        $_SESSION["ht-success"] = null;
        unset($_SESSION["ht-success"]);
      }
    ?>
    <?php
      if(!empty($_SESSION["ht-error"]))
      {
        ?>
        <script type="text/javascript">
        Swal.fire(
          'Ops!',
          '<?php print $_SESSION["ht-error"]; ?>',
          'error'
        )
        </script>
        <?php

        $_SESSION["ht-error"] = null;
        unset($_SESSION["ht-error"]);
      }

    ?>
</body>
</html>

                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                           ./                                                                                                                                                           
                                         %%%%%%                                                                                                                                                         
                                      .%%%%%%%%%%/                                                                                                                                                      
                                    %%%%%%%%%%%%%%%%                                                                                                                                                    
                                 ,&&&%%%%%%%%%%%%%%&&&(                                                                                                                                                 
                               &&&&&&&&%%%%%%%%%#&&&&&&&&                                                                                                                                               
                            ,&&&&&&&&&&&&&%%%%&&&&&&&&&&&&&(                                                                                                                                            
                           &&&&&&&&&&&&&&&&&%&&&&&&&&&&&&&&&&#                                                                                                                                          
                             .&&&&&&&&&&&&&&&&&&&&&&&&&&&&%&&#                                                                                                                                          
                                &&&&&&&&&&&&&&&&&%&&&&&&&&&&&#                                                                                                                                          
                                  *&&&&&&&&&&&&&&&&&&%&&&&&&&#                                                                                                                                          
                                 ,%%%&&&&&&&&&&&&&&%%&%&&&&&&#                                                                                                                                          
                               %%%%%%%%%&&&&&&&&%%%%%%%%%&&&&#                                                                                                                                          
                            ,&%&%&%&%&%&%&&&&&%&%&%&%&%&%&%%&#                   (@@/                                                                                                                   
                          ,%%%%%%%%%%%%%%%%#%%%%%%%%%%%%%%%%%                  @@          @*                                                                                                           
                          ,%%%%&%&%&%&%&%%%%%%%&&&%&%&%&%&/                  .@            @,                                                                                                           
                          ,%%%%%%%%%%%#%%%%%%%%%%%%%%%%%                     @             @,                                                                                                           
                          ,%%%%%%%%%%%%%%%%%%%%%%%%%%*                       @             @,           *@             @.     @@@(,%@@@     &@@@*/@@@           @@@#,/@@@%                              
                          ,%%%%%%####%%%%%%%%%%%%%%###(                      @             @,           *@             @.  .@          .@ @@          @@     @&            @*                           
                          ,%%%%#########%%%%%%%%%########                    @@@@@@@@@     @,           *@             @.  @             @,            &@  *@               /@                          
                          ,%##############%%%%##############                 @             @,           *@             @. /@             @             .@  @                 @*                         
                           ################((################                @             &@           *@             @. /@             @             .@  @                 @(                         
                              ###########((((((###########*                  @              #@           @             @  /@             @             .@   @               @@(                         
                                ######((((((((((((######                     @                %@&         @&         &@   /@             @             .@    @@           @@ @(                         
                                   #((((((((((((((((#*                                            @@@@@      @@@@@@@      /@             @             .@       .@@@@@@@     @(                         
                                     ((((((((((((((                                                                                                                                                     
                                        ((((((((,                                                                                                                                                       
                                         ((((((*                                                                                                                                                        
                                         ((((((*                                                                                                                                                        
                                         ((((((*                                                                                                                                                        
                                         (((((                                                                                                                                                          
                                         (((                                                                                                                                                            
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
                                                                                                                                                                                                        
-->
