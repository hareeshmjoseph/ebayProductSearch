<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Ebay Search</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">    
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
    </head>
    <body>
        
        <!-----------------NAVBAR---------------------------------->
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">E-Bay Product Search</a>
        </nav>
        
        <!----------- -----SEARCH BAR------------------------------>
        
        <div class="container">
            <div class="search">
                <form>
                    <input class="form-control shadow p-3 mb-5 bg-white rounded" type="text" placeholder="Type the Product Id(12- digit) of your product and press Enter" name="productid" onkeydown="onkeydown()"/>
                </form>
            </div>
        </div>
        
        <!----------------GETTING PRODUCT DETAILS------------------>
        
        <section>
            <div class="container-fluid">
                <div class="row">
                    <?php
                        if(isset($_GET['productid'])) {    
                        $arr = explode(' ', $_GET['productid']);?>
                        <?php for ($x = 0; $x < count($arr); $x++) {                 
                            $ch = curl_init('http://ebay-api.thedcevents.com/api/findproduct/' . $arr[$x]);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            $output = curl_exec($ch);
                            curl_close($ch); 
                            // $result = '{"title":"foo","url":"bar","img":"baz","thumbnails":["asd","qwe"]}';
                            $result = json_decode($output);
                            if($result->status == 'SUCCESS') {
                               $item = $result->data;
                            } else {
                            $error = true;
                            }
                            ?>            
                            <?php if(isset($error)) { ?>
                                <div>Please Enter the correct Product Id..!</div>
                            <?php } ?>
                    
         <!---------------DIPLAYING PRODUCT DETAILS------------------>
                    
                            <?php if(isset($item)) { ?>    
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-5">
                                    <div class="card  shadow p-3 mb-5 bg-white rounded p-3" style="width:400px">
                                        <h4 class="card-title"><?php echo $item->title ?></h4>
                                        <p class="card-text"><?php echo $item->url ?></p>
                                        <?php if(isset($item->img)){?>
                                        <p class="card-text"><?php echo $item->img ?></p>
                                        <?php } else{
                                        echo "No Other Imaage than the main image";
                                        }?>
                                        <div class="row">   
                                            <?php foreach($item->thumbnails as $thumb) { ?>
                                                <div class="col-lg-4">
                                                    <img class= "rounded" src="<?php echo $thumb; ?>" />
                                                </div>
                                            <?php } ?>
                                        </div>                                     
                                    </div>
                                </div>                                   
                            <?php } ?> 
                        <?php } ?> 
                    <?php } ?>  
                </div> 
            </div>
        </section>       
        <script>
            function onkeydown(e) {
                if(e.keyCode === 13) {
                    document.querySelector('form').submit();
                }
            }
        </script>
    </body>
</html>