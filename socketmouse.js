<script src="<?php echo $serveur;?>/socket.io/socket.io.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {

        var url = "<?php echo $serveur;?>";
        var socket = io.connect(url);
        socket.on('connect', function() {
            var params = {
                "speudo": "jojo",
                "position": {
                    'x': '10',
                    'y': '20'
                }
            };
            socket.emit('wpio_init', params);
        });
socket.on('retimer',function(tps){
jQuery('#retimer').html('prochain tirage dans '+(tps/1000)+' s.');
});
socket.on('tirage',function(w){
jQuery('#live_messages').append('<div class="mess">le nombre gagnant est '+w+'</div>');
socket.emit('tirage',w);
});
socket.on('gagne',function(w,id){
jQuery('#live_messages').append('<div class="mess">'+id+' gagne'+'</div>');
});
socket.on('perdu',function(){

jQuery('#live_messages').append('<div class="mess">'+'vous avez perdu'+'</div>');
});
        var x = 0;
        var y = 0;
        var pos = {
            'x': 0,
            'y': 0
        };
        var points = [];
        var down = false;
        var lastx = 0,
            lasty = 0;

        function findPos(obj) {
            var curleft = 0,
                curtop = 0;

            if (obj.offsetParent) {
                do {
                    curleft += obj.offsetLeft;
                    curtop += obj.offsetTop;
                } while (obj = obj.offsetParent);
                return {
                    x: curleft,
                    y: curtop
                };
            }
            return undefined;
        }
        jQuery('#page').mousemove(function(e) {
            console.log("maousse mouve");
            var pos = findPos(this);
            x = e.pageX - pos.x;
            y = e.pageY - pos.y;
            socket.emit('move', {
                'x': x,
                'y': y
            });
        });
        socket.on('move', function(pos, qui) {
            console.log('moving at ' + pos.x + ',' + pos.y + ' from ' + qui);
            jQuery('#' + qui).remove();
            jQuery('body').append(jQuery('<div class="cursor_user" id="' + qui + '">' + qui + '</div>'));
            jQuery('#' + qui).css({
                top: pos.y,
                left: pos.x
            });
//jQuery('body').addClass('cursors');
            jQuery('#' + qui).fadeOut(1000);
        });
jQuery('#envoie_mess').click(function(){
socket.emit('message',jQuery('#messinput').val());
jQuery('#live_messages').prepend(jQuery('<div class="mess">'+jQuery('#messinput').val()+'</div>').fadeIn(1000).delay(1000).fadeOut(10000));
});
socket.on('message',function(mess){
jQuery('#live_messages').prepend(jQuery('<div class="mess">'+mess+'</div>').fadeIn(1000).delay(1000).fadeOut(10000));
});
    });
</script>