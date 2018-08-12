<!DOCTYPE html>
<html>
<head>
	<title></title>
    <style type="text/css">
        .page > li {
            border : solid 1px;
            padding: 7px;
            padding-top: 4px;
            padding-bottom: 4px;
            display: inline-block;
            margin: 10px;
            background-color: #808080;
        }

        .page > li > a{
            color: black;
        } 

        .page > li:hover{
            background-color: white;
        }

    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.page li').click(function() {
                $(this).addClass('active');
        });
     });       
    </script>
</head>
<body>
	<div class="container">
        <div class="row">
            <div class="col-lg-8 col-xs-12 col-md-8">
                    <div class="pull-left">
                    	<?php
                    		$url = '';
                    		if (isset($_GET['user_id'])) 
                    		{
                    			$url .= '&user_id='.$_GET['user_id'];
                    		}
                    		if (isset($_GET['tag_name'])) 
                    		{
                    			$url .= '&tag_name='.$_GET['tag_name'];
                    		}
                    		if (isset($_POST['search'])) 
                    		{
                    			$url .= '&search='.$_POST['search'];
                    		}
                            if (isset($_REQUEST['action'])) 
                            {
                                $url .= '&action='.$_REQUEST['action'];
                            }
                    	?>
                        <ul class="page">
                        	<li><a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1).$url; } ?>"><i class="fa fa-angle-left"></i></a></li>
                        	 <?php
                        	 	 for ($i=1; $i<=$total_pages ; $i++) 
                        	 	 { 
                        	 	 	echo '<li><a href="?pageno='.$i.$url.'">'.$i.'</a></li>';
                        	 	 }
                        	 ?>
                        	<li><a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1).$url; } ?>"><i class="fa fa-angle-right"></i></a></li> 
                        </ul>
                  	</div>
                    <!-- <div class="pull-left">
                    	<a href="<?php //if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><i class="fa fa-angle-right"></i></a>
                    </div> -->
                            
                    <div class="clearfix"></div>
            </div>
        </div>
    </div>
</body>
</html>