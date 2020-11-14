<!doctype html>
<html>
<head>	
<?php require PATH_INCLUDES . 'head.php'; ?>
<script type="text/javascript">
document.addEventListener('touchstart', handleTouchStart, false);      
document.addEventListener('touchmove', handleTouchMove, false);
document.addEventListener('touchend', handleTouchEnd, false);

var xDown = 0;                                                        
var yDown = 0;

function getTouches(evt) {
  return evt.touches ||             // browser API
         evt.originalEvent.touches; // jQuery
}                                                     

function handleTouchStart(evt) {
    const firstTouch = getTouches(evt)[0];                                      
    xDown = firstTouch.clientX;                                      
    yDown = firstTouch.clientY;                                 
};                                                

function handleTouchEnd(evt) {
	//console.log(evt); 
	var xUp = evt.changedTouches[0].clientX;                                    
    var yUp = evt.changedTouches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;
    console.log(Math.abs( yDiff )); 
    if(yDiff<0 && evt.changedTouches[0].clientY==evt.changedTouches[0].pageY )
    if ( Math.abs( yDiff ) >180 ) {/*most significant*/
    	//console.log(Math.abs( yDiff ) +" - "+  Math.abs( yDown )); 
    	location.reload();
    }                                     
};
function handleTouchMove(evt) {
    if ( ! xDown || ! yDown ) {
        return;
    }
    //console.log(evt.touches); 
    var xUp = evt.touches[0].clientX;                                    
    var yUp = evt.touches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;

	//console.log(yUp); 
    if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {/*most significant*/
        if ( xDiff > 0 ) {
            //alert('left swipe');
            /* left swipe */ 
        } else {
        	//alert('right swipe');
            /* right swipe */
        }                       
    } else {
        if ( yDiff > 0 ) {
        	//alert('up swipe');
        	
            /* up swipe */ 
        } else { 
//         	alert(yDiff);
            /* down swipe */
        }                                                                 
    }
    /* reset values */
                                          
};


</script>

</head>
<body id="body" class="lang<?=Session::get('lang')?>">
    
    <?php 
    //require PATH_INCLUDES. 'header.php';
    require $this->_fileView;
    require PATH_INCLUDES . 'popup.php'
    ?>    
</body>
</html>